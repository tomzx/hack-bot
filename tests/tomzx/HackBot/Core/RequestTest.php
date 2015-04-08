<?hh // strict

namespace tomzx\HackBot\Tests\Core;

use Mockery as m;
use tomzx\HackBot\Core\Request;
use tomzx\HackBot\Tests\TestCase;

class RequestTest extends TestCase
{
	public function setUp()
	{
		$this->request = new Request();
	}

	public function testGetMeta()
	{
		$actual = $this->request->getMeta();
		$this->assertSame([], $actual);
	}

	public function testSetMeta()
	{
		$meta = [
			'a' => 'b',
		];
		$this->request->setMeta($meta);

		$actual = $this->request->getMeta();
		$this->assertSame($meta, $actual);
	}

	public function testGetRequest()
	{
		$actual = $this->request->getRequest();
		$this->assertSame(null, $actual);
	}

	public function testSetRequest()
	{
		$request = 'test';
		$this->request->setRequest($request);

		$actual = $this->request->getRequest();
		$this->assertSame($request, $actual);
	}
}
