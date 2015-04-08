<?hh // strict

namespace tomzx\HackBot\Tests\Core\Responders;

use Mockery as m;
use tomzx\HackBot\Core\Responders\Listener;
use tomzx\HackBot\Tests\Core\ResponderTest;

class ListenerTest extends ResponderTest
{
	protected Listener $listener;

	public function setUp()
	{
		$this->listener = new Listener();
		$this->responder = $this->listener;
	}

	public function testFromDefinition()
	{
		$definition = [
			'identifier' => 'identifier',
			'matcher' => 'matcher',
			'answer' => function() {},
		];
		$listener = Listener::fromDefinition($definition);

		$this->assertSame($listener->getIdentifier(), $definition['identifier']);
		$this->assertSame($listener->getMatcher(), $definition['matcher']);
		$this->assertSame($listener->getAnswer(), $definition['answer']);
		$this->assertSame($listener->getHelp(), null);
	}
}