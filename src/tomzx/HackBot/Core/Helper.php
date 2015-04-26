<?hh // strict

namespace tomzx\HackBot\Core;

class Helper
{
	public function configPath($path = '')
	{
		return __DIR__.'/../../../../config/'.$path;
	}

	public function dataPath($path = '')
	{
		return __DIR__.'/../../../../data/'.$path;
	}

	public static function formatBytes($size, $level = 0, $precision = 2, $base = 1024) : string
	{
		$unit = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB','YB'];
		$times = floor(log($size, $base));
		return sprintf('%.'.$precision.'f', $size/pow($base, $times+$level)).' '.$unit[$times+$level];
	}
}