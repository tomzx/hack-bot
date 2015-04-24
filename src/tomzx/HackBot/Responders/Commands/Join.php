<?hh // strict

namespace tomzx\HackBot\Responders\Commands;

use Arry\Arry;
use tomzx\HackBot\Adapters\IRC;
use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Core\Responders\Command;

return [
	'type' => 'command',
	'identifier' => 'join',
	'command' => 'join',
	'parameters' => '(?<channels>.*)',
	'help' => 'channel(:password) [channels ...]',
	'answer' => function (Dispatcher $dispatcher, array $data = [])
	{
		$channels = explode(' ', $data['channels']);

		$commands = [];
		foreach ($channels as $channel) {
			list($channel, $password) = explode(':', $channel, 2) + [1 => null];
			if ( ! IRC::isChannel($channel)) {
				continue;
			}

			$command = 'JOIN '.$channel;
			if ($password) {
				$command .= ' '.$password;
			}
			$commands[] = $command;
		}

		if ($adapter = Arry::get($data, 'meta.irc.adapter')) {
			foreach ($commands as $command) {
				$adapter->send($command);
			}
			return;
		}

		return $commands;
	}
];