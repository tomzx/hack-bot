<?hh // strict

namespace tomzx\HackBot\Core;

use tomzx\HackBot\Core\Responders\Listener;

class Logger
{
	protected static bool $enabled = true;

	public static function getEnabled() : bool
	{
		return self::$enabled;
	}

	public static function setEnabled($enabled) : void
	{
		self::$enabled = $enabled;
	}

	public static function log(string $text) : void
	{
		if ( ! self::$enabled) {
			return;
		}
		echo '['.date('c').']['.Helper::formatBytes(memory_get_usage()).'] '.$text.PHP_EOL;
	}
}