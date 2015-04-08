<?hh // strict

namespace tomzx\HackBot\Tests\Core;

use Mockery as m;
use tomzx\HackBot\Core\Response;
use tomzx\HackBot\Tests\TestCase;

class ResponseTest extends TestCase
{
	public function setUp()
	{
		$this->response = new Response();
	}

	public function testGetMeta()
	{
		$actual = $this->response->getMeta();
		$this->assertSame([], $actual);
	}

	public function testSetMeta()
	{
		$meta = [
			'a' => 'b',
		];
		$this->response->setMeta($meta);

		$actual = $this->response->getMeta();
		$this->assertSame($meta, $actual);
	}

	public function testGetResponse()
	{
		$actual = $this->response->getResponse();
		$this->assertSame(null, $actual);
	}

	public function testSetresponse()
	{
		$response = 'test';
		$this->response->setResponse($response);

		$actual = $this->response->getResponse();
		$this->assertSame($response, $actual);
	}
}
