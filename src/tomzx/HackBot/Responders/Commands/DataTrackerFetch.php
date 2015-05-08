<?hh // strict

namespace tomzx\HackBot\Responders\Commands;

use Arry\Arry;
use GuzzleHttp\Client;
use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Core\Helper;
use tomzx\HackBot\Core\Logger;
use tomzx\HackBot\Core\Responders\Command;

return [
	'type' => 'command',
	'identifier' => 'data-tracker-fetch',
	'command' => 'data-tracker-fetch',
	'parameters' => '((?<from>\S+)?@(?<to>\S+)? )?(?<keys>(\S+ ?)+)',
	'help' => 'timestamp key1=value1 <key2=value2>',
	'answer' => function (Dispatcher $dispatcher, array $data = [])
	{
		$config = require Helper::configPath('data-tracker.php');

		$from = Arry::get($data, 'from');
		$to = Arry::get($data, 'to');
		$keys = explode(' ', $data['keys']);

		$output = [];
		foreach ($keys as $key) {
			try {
				$client = new Client();
				$response = $client->get($config['base_url'].$key, [
					'query' => [
						'from' => $from,
						'to' => $to,
					],
				]);
				$result = $response->json();
			} catch (\Exception $e) {
				Logger::error($e->getMessage());
				continue;
			}
			$partialOutput = [];
			foreach ($result as $datum) {
				$partialOutput[] = date('c', $datum[0]).' => '.$datum[1];
			}
			$output[] = $key.': '.implode(' ', $partialOutput);
		}
		return $output;
	}
];