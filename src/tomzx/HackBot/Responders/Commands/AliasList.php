<?hh // strict

namespace tomzx\HackBot\Responders\Commands;

use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Core\Responders\Command;

return [
	'type' => 'command',
	'identifier' => 'alias-list',
	'command' => 'alias-list',
	'parameters' => '',
	'help' => '',
	'answer' => function (Dispatcher $dispatcher, array $data = [])
	{
		// TODO: Check if target command exist?
		$dataDirectory = 'data';
		$dataFile = $dataDirectory.'/alias.json';

		$aliases = [];
		// TODO: Have a caching system so we don't read the file every time?
		if (file_exists($dataFile)) {
			$aliases = json_decode(file_get_contents($dataFile), true);
		}

		$output = '';
		foreach ($aliases as $command => $replacement) {
			$output .= $command.' -> '.$replacement.PHP_EOL;
		}

		if (empty($output)) {
			$output = 'Alias list is empty.';
		}

		return trim($output);
	}
];