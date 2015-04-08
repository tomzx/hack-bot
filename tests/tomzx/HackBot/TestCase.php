<?hh // strict

namespace tomzx\HackBot\Tests;

use Mockery as m;

class TestCase extends \PHPUnit_Framework_TestCase
{
	public function tearDown()
	{
		m::close();
	}
}
