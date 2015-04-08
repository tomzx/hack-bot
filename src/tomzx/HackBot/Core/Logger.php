<?hh // strict

namespace tomzx\HackBot\Core;

use tomzx\HackBot\Core\Responders\Listener;

class Logger
{
	public function log($text)
	{
		echo '['.date('c').']['.Helper::formatBytes(memory_get_usage()).'] '.$text.PHP_EOL;
	}
}