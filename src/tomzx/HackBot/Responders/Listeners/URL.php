<?hh // strict

namespace tomzx\HackBot\Responders\Listeners;

use tomzx\HackBot\Core\Responders\Listener;

class URL extends Listener
{
	protected string $matcher = '/(?<url>(https?):\/\/\S+)/';

	public function answer(array $data = []) : ?string
	{
		// TODO: Limit request duration
		$page = file_get_contents($data['url']);
		if ( ! $page) {
			return null;
		}

		if (preg_match('/<title>(?<title>.*)<\/title>/siU', $page, $matches)) {
			$title = preg_replace('/\s+/', ' ', $matches['title']);
			return trim($title);
		}
	}
}
