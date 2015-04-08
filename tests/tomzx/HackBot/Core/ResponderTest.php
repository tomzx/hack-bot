<?hh // strict

namespace tomzx\HackBot\Tests\Core;

use Mockery as m;
use tomzx\HackBot\Core\Responder;
use tomzx\HackBot\Tests\TestCase;

abstract class ResponderTest extends TestCase
{
	protected Responder $responder;

	public function testGetIdentifier()
	{
		$actual = $this->responder->getIdentifier();
		$this->assertSame(null, $actual);
	}

	public function testSetIdentifier()
	{
		$identifier = 'identifier';
		$this->responder->setIdentifier($identifier);

		$actual = $this->responder->getIdentifier();
		$this->assertSame($identifier, $actual);
	}

	public function testGetAnswer()
	{
		$actual = $this->responder->getAnswer();
		$this->assertTrue(is_callable($actual));
	}

	public function testSetAnswer()
	{
		$answer = function() {};
		$this->responder->setAnswer($answer);

		$actual = $this->responder->getAnswer();
		$this->assertSame($answer, $actual);
	}

	public function testGetHelp()
	{
		$actual = $this->responder->getHelp();
		$this->assertSame(null, $actual);
	}

	public function testSetHelp()
	{
		$help = 'help';
		$this->responder->setHelp($help);

		$actual = $this->responder->getHelp();
		$this->assertSame($help, $actual);
	}
}
