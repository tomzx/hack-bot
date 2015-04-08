<?hh // strict

namespace tomzx\HackBot\Core\Responders;

use tomzx\HackBot\Core\Responder;

class Listener extends Responder
{
	protected string $matcher = null;

	public function getMatcher()
	{
		return $this->matcher;
	}

	public function setMatcher(string $matcher) : this
	{
		$this->matcher = $matcher;

		return $this;
	}

	public static function fromDefinition(array $definition) : this
	{
		$listener = new self;
		$listener->setIdentifier($definition['identifier']);
		$listener->setMatcher($definition['matcher']);
		$listener->setAnswer($definition['answer']);
		return $listener;
	}
}