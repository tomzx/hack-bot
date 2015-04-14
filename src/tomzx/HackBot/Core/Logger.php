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

	public static function debug(string $text) : void
	{
		self::logLevel('DEBUG', $text);
	}

	public static function info(string $text) : void
	{
		self::logLevel('INFO', $text);
	}

	public static function notice(string $text) : void
	{
		self::logLevel('NOTICE', $text);
	}

	public static function warning(string $text) : void
	{
		self::logLevel('WARNING', $text);
	}

	public static function error(string $text) : void
	{
		self::logLevel('ERROR', $text);
	}

	public static function critical(string $text) : void
	{
		self::logLevel('CRITICAL', $text);
	}

	public static function alert(string $text) : void
	{
		self::logLevel('ALERT', $text);
	}

	public static function emergency(string $text) : void
	{
		self::logLevel('EMERGENCY', $text);
	}

	protected static function logLevel(string $level, string $text) : void
	{
		self::log('['.$level.'] '.$text);
	}

	protected static function log(string $text) : void
	{
		if ( ! self::$enabled) {
			return;
		}
		echo '['.date('c').']['.Helper::formatBytes(memory_get_usage()).']'.$text.PHP_EOL;
	}
}