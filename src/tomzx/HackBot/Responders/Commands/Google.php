<?hh // strict

namespace tomzx\HackBot\Responders\Commands;

use Goutte\Client;
use tomzx\HackBot\Adapters\IRC;
use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Core\Responders\Command;

return [
	'type' => 'command',
	'identifier' => 'google',
	'command' => 'google',
	'parameters' => '(?<query>.*)',
	'help' => 'query',
	'answer' => function (Dispatcher $dispatcher, array $data = [])
	{
		$client = new Client();

		$crawler = $client->request('GET', 'https://www.google.com/search?q='.$data['query']);
		if ( ! $crawler) {
			return null;
		}

		$resultStats = $crawler->filter('#resultStats')->text();

		if ( ! $resultStats) {
			return 'No results.';
		}

		$firstResult = $crawler->filter('#ires li.g')->first();

		if ( ! $firstResult) {
			return 'No results.';
		}

		$url = $firstResult->filter('.kv cite')->first();
		$url = $url->count() ? $url->text() : 'n/a';
		$title = $firstResult->filter('a')->first();
		$title = $title->count() ? $title->text() : 'n/a';
		$description = $firstResult->filter('.st')->first();
		$description = $description->count() ? $description->text() : 'n/a';

		return $title.' ['.$url.'] ('.$resultStats.')'.PHP_EOL.$description;
	}
];