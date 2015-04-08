<?hh // strict

namespace tomzx\HackBot\Tests\Core;

use Mockery as m;
use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Tests\TestCase;

class DispatcherTest extends TestCase
{
	public function setUp()
	{
		$this->dispatcher = new Dispatcher();
	}

	public function testInitializeResponders()
	{
		$this->dispatcher->initializeResponders();
	}

	public function testRegisterResponder()
	{
		$responder = m::mock('tomzx\HackBot\Core\Responder');

		$responder->shouldReceive('setDispatcher')->with($this->dispatcher)->once()
			->shouldReceive('getIdentifier')->once()->andReturn('identifier');

		$this->dispatcher->registerResponder($responder);
	}

	public function testGetResponders()
	{
		$this->dispatcher->getResponders();
	}

	public function testReloadResponders()
	{
		$this->dispatcher->reloadResponders();
	}

	public function testDispatch()
	{
		$request = m::mock('tomzx\HackBot\Core\Request');

		$meta = [
			'a' => 'b',
		];

		$request->shouldReceive('getMeta')->once()->andReturn($meta);

		$actual = $this->dispatcher->dispatch($request);
		$this->assertSame($meta, $actual->getMeta());
		$this->assertSame(null, $actual->getResponse());
	}
}
