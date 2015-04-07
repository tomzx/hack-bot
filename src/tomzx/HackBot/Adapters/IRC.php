<?hh // strict

namespace tomzx\HackBot\Adapters;

use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Core\Helper;
use tomzx\HackBot\Core\Request;

class IRC
{
	protected resource $socket = null;

	protected array $configuration = [];

	protected Dispatcher $dispatcher = null;

	const ENDLINE = "\r\n";

	public function __construct(array $configuration) : this
	{
		$this->configuration = $configuration;
		register_shutdown_function([$this, 'shutdown']);
	}

	public function setDispatcher(Dispatcher $dispatcher) : this
	{
		$this->dispatcher = $dispatcher;

		return $this;
	}

	public function shutdown() : void
	{
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
			$this->out($data);

			$parts = explode(' :', $data);
			$trailing = count($parts) > 1 ? implode(array_slice($parts, 1)) : '';
			$parts = explode(' ', $parts[0]);
			if ($parts[0] === 'PING') {
				$this->send('PONG '.$trailing);
				continue;
			}

			if ($parts[1] === 'PRIVMSG') {
				$query = $trailing;
				$meta = [
					'from' => substr($parts[0], 1),
					'command' => $parts[1],
					'sent_to' => $parts[2],
					'reply_to' => '#umbreon',
					'args' => explode(' ', $query),
				];

				$request = new Request();
				$request->setRequest($query);
				$request->setMeta($meta);
				if ($this->dispatcher) {
					$response = $this->dispatcher->dispatch($request);
					if ($response->hasResponse()) {
						$this->send('PRIVMSG '.$response->getMeta()['reply_to'].' :'.$response->getResponse());
					}
				}
			}
		}
	}

	protected function send() : void
	{
		$args = func_get_args();
		$message = implode(' ', $args).self::ENDLINE;
		$this->in($message);
		fputs($this->socket, $message);
	}

	private function in($text) : void
	{
		echo $this->debugPrefix().'[INPUT]  <<< '.trim($text).PHP_EOL;
	}

	private function out($text) : void
	{
		echo $this->debugPrefix().'[OUTPUT] <<< '.trim($text).PHP_EOL;
	}

	private function debugPrefix() : string
	{
		return '['.date('c').']['.Helper::formatBytes(memory_get_usage()).']';
	}

	public function run() : void
	{
		$this->connect();
		$this->login();
		$this->join();
		$this->loop();
		$this->disconnect();
	}
}