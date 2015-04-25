<?hh // strict

namespace tomzx\HackBot\Adapters;

use tomzx\HackBot\Core\Adapter;
use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Core\Helper;
use tomzx\HackBot\Core\Logger;
use tomzx\HackBot\Core\Request;

class IRC extends Adapter
{
	protected resource $socket = null;

	protected array $configuration = [];

	protected float $lastMessageTimestamp = 0;

	protected array $loggedUsers = [];

	const ENDLINE = "\r\n";

	public function __construct(array $configuration) : void
	{
		$this->configuration = $configuration;
		register_shutdown_function([$this, 'shutdown']);
	}

	public function shutdown() : void
	{
		$this->send('QUIT :Good bye bro!');
		$this->out('BAI ;-;');
	}

	protected function connect() : void
	{
		$this->socket = fsockopen($this->configuration['server'], $this->configuration['port'], $errno, $errstr, 0);
		stream_set_blocking($this->socket, 1);
		stream_set_timeout($this->socket, 0);
	}

	protected function disconnect() : void
	{
		fclose($this->socket);
		$this->socket = null;
	}

	protected function login() : void
	{
		if (isset($this->configuration['password'])) {
			$this->send('PASS '.$this->configuration['password']);
		}
		$this->send('NICK '.$this->configuration['nick']);
		$this->send('USER '.$this->configuration['nick'].' 0 * :'.$this->configuration['real_name']);
	}

	protected function reconnect() : void
	{
		$this->disconnect();
		$this->connect();
		$this->login();
		$this->join();
	}

	protected function join() : void
	{
		foreach ($this->configuration['channels'] as $channelData) {
			$query = count($channelData) === 2 ? $channelData[0].' '.$channelData[1] : $channelData[0];
			$this->send('JOIN '.$query);
		}
	}

	protected function loop() : void
	{
		while($data = fgets($this->socket)) {
			$this->parseLine($data);
		}
	}

	protected function parseLine(string $data) : void
	{
		$this->out($data);

		$parts = explode(' :', $data, 2) + [1 => null];
		$trailing = trim($parts[1]);
		$parts = explode(' ', $parts[0]);
		if ($parts[0] === 'PING') {
			$this->send('PONG '.$trailing);
			return;
		}

		$from = substr($parts[0], 1);
		list($nick) = explode('!', $from);

		$command = $parts[1];

		switch ($command) {
			case 'PRIVMSG':
				$query = $trailing;
				$to = $parts[2];
				$reply_to = $this->isChannel($to) ? $to : $nick;
				$meta = [
					'irc' => [
						'adapter' => $this,
						'server' => $this->configuration['server'].':'.$this->configuration['port'],
						'from' => $from,
						'nick' => $nick,
						'command' => $parts[1],
						'sent_to' => $parts[2],
						'reply_to' => $reply_to,
						'args' => explode(' ', $query),
					]
				];

				$request = new Request();
				$request->setRequest($query);
				$request->setMeta($meta);
				if ($this->dispatcher) {
					$responseBag = $this->dispatcher->dispatch($request);
					foreach ($responseBag->all() as $response) {
						$lines = explode(PHP_EOL, $response->getResponse());
						foreach ($lines as $line) {
							if ($line) {
								$this->privmsg($reply_to, $line);
							}
						}
					}
				}
				break;
			case 'JOIN':
				break;
			case 'PART':
				break;
			case 'QUIT':
				break;
			case 'NOTICE':
				break;
			case 'KICK':
				break;
			case 'NICK':
				break;
			default:
				if (is_int($command)) {
					$this->parseNumeric($command, $trailing);
				}
		}
	}

	protected function parseNumeric(int $commandNumber, $parameters) : void
	{
		switch ($commandNumber) {
			case 353: // List all users in joined channel
				break;
			case 376: // Identify
				break;
			case 471:
			case 472:
			case 473:
			case 474:
			case 475: // Cannot join channel
				break;
		}
	}

	public function send() : void
	{
		$args = func_get_args();
		$message = implode(' ', $args).self::ENDLINE;
		$this->in($message);
		fputs($this->socket, $message);

		$this->delaySend();
	}

	private function delaySend() : void
	{
		$now = microtime(true);
		$toSleep = $this->configuration['delay'] - ($now - $this->lastMessageTimestamp);
		if ($toSleep > 0) {
			usleep($toSleep*1e6);
		}
		$this->lastMessageTimestamp = $now;
	}

	public function privmsg($target, $message) : void
	{
		$this->send('PRIVMSG '.$target.' :'.$message);
	}

	private function in($text) : void
	{
		Logger::info('[I] >>> '.trim($text));
	}

	private function out($text) : void
	{
		Logger::info('[O] <<< '.trim($text));
	}

	public function run() : void
	{
		$this->connect();
		$this->login();
		$this->join();
		$this->loop();
		$this->disconnect();
	}

	public static function isChannel($target) : bool
	{
		return $target[0] === '#';
	}

	public function getChannelList() : array
	{

	}

	public function getUsersInChannel(string $channel) : array
	{

	}

	protected function addLoggedUser($nick) : void
	{
		if ( ! $this->isKnownLoggedIn($nick)) {
			$this->loggedUsers[$nick] = time();
			Logger::debug('Logged in user '.$nick.' was added to the logged user list.');
		}
	}

	protected function removeLoggedUser($nick) : void
	{
		if ($this->isKnownLoggedIn($nick)) {
			unset($this->loggedUsers[$nick]);
			Logger::debug('Logged in user '.$nick.' was removed to the logged user list.');
		}
	}

	protected function isKnownLoggedIn($nick) : bool
	{
		return array_key_exists($nick, $this->loggedUsers);
	}

	public function isLoggedIn(string $nick) : bool
	{
		Logger::debug('Checking if user '.$nick.' is logged in...');

		if ($this->isKnownLoggedIn($nick)) {
			Logger::debug('User '.$nick.' is logged in!');
			return true;
		} else {
			Logger::debug('User '.$nick.' logged in state is unknown, querying server...');
			$this->privmsg('NICKSERV', 'ACC '.$nick);

			return false;
		}
	}
}