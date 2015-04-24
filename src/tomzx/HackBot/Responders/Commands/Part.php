<?hh // strict

namespace tomzx\HackBot\Responders\Commands;

use Arry\Arry;
use tomzx\HackBot\Adapters\IRC;
use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Core\Responders\Command;

return [
	'type' => 'command',
	'identifier' => 'part',
	'command' => 'part',
	'parameters' => '(?<channels>.*)',
	'help' => 'channel [channels ...]',
	'answer' => function (Dispatcher $dispatcher, array $data = [])
	{
		$channels = explode(' ', $data['channels']);

		$commands = [];
		foreach ($channels as $channel) {
			if ( ! IRC::isChannel($channel)) {
				continue;
			}

			$commands[] = 'PART '.$channel;
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