<?hh // strict

namespace tomzx\HackBot\Tests\Core\Responders;

use Mockery as m;
use tomzx\HackBot\Core\Responders\Command;
use tomzx\HackBot\Tests\Core\ResponderTest;

class CommandTest extends ResponderTest
{
	protected Command $command;

	public function setUp()
	{
		$this->command = new Command();
		$this->responder = $this->command;
	}

	public function testFromDefinition()
	{
		$definition = [
			'identifier' => 'identifier',
			'command' => 'command',
			'parameters' => 'parameters',
			'help' => 'help',
			'answer' => function() {},
		];
		$listener = Command::fromDefinition($definition);

		$this->assertSame($listener->getIdentifier(), $definition['identifier']);
		$this->assertSame($listener->getCommand(), $definition['command']);
		$this->assertSame($listener->getParameters(), $definition['parameters']);
		$this->assertSame($listener->getHelp(), $definition['help']);
		$this->assertSame($listener->getAnswer(), $definition['answer']);
	}
}