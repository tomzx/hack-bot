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
	'identifier' => 'data-tracker-push',
	'command' => 'data-tracker-push',
	'parameters' => '((?<timestamp>.*?) )??(?<elements>(\S+=\S+ ?)+)',
	'help' => 'timestamp key1=value1 <key2=value2>',
	'answer' => function (Dispatcher $dispatcher, array $data = [])
	{
		$config = require Helper::configPath('data-tracker.php');

		preg_match_all('/(?:(?<key>\S+)=(?<value>\S+))+/', $data['elements'], $matches);

		$body = [
			'timestamp' => Arry::get($data, 'timestamp', 'now'),
		];
		$items = array_combine($matches['key'], $matches['value']);
		foreach ($items as $key => $value) {
			$body[$key] = $value;
		}

		try {
			$client = new Client();
			$response = $client->post($config['base_url'], [
				'headers' =>['Content-Type' => 'application/json'],
				'body' => json_encode($body),
			]);
			$result = $response->json();
		} catch (\Exception $e) {
			Logger::error($e->getMessage());
			return;
		}
		return 'Data entered @ '.date('c', $result['timestamp']);
	}
];