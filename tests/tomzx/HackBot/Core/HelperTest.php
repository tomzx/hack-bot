<?hh // strict

namespace tomzx\HackBot\Tests\Responders\Listeners;

use tomzx\HackBot\Core\Helper;
use tomzx\HackBot\Tests\TestCase;

class HelperTest extends TestCase
{
	/**
	 * @dataProvider formatBytes
	 */
	public function testFormatBytes($expected, $size, $level = 0, $precision = 2, $base = 1024)
	{
		$actual = Helper::formatBytes($size, $level, $precision, $base);
		$this->assertSame($expected, $actual);
	}

	public function formatBytes()
	{
		return [
			['50.00 B', 50],
			['2.00 kB', 2048],
			['0.001 kB', 1, 1, 3, 1000],
		];
	}
}
