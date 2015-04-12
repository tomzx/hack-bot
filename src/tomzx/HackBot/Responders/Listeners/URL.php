<?hh // strict

namespace tomzx\HackBot\Responders\Listeners;

use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Core\Responders\Listener;

return [
	'type' => 'listener',
	'identifier' => 'url',
	'matcher' => '/(?<url>(https?):\/\/\S+)/',
	'answer' => function (Dispatcher $dispatcher, array $data = [])
	{
		// TODO: Limit request duration
		$page = file_get_contents($data['url']);
		if ( ! $page) {
			return null;
		}

		if (preg_match('/<title>(?<title>.*)<\/title>/siU', $page, $matches)) {
			$title = preg_replace('/\s+/', ' ', $matches['title']);
			return trim(html_entity_decode($title));
		}
	}
];