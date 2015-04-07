<?hh // strict

namespace tomzx\HackBot\Core\Responders;

use tomzx\HackBot\Core\Responder;

abstract class Listener extends Responder
{
	protected string $matcher = null;

	protected function getMatcher()
	{
		return $this->matcher;
	}

	public function setMatcher(string $matcher) : this
	{
		$this->matcher = $matcher;

		return $this;
	}
}