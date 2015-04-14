<?hh // strict

namespace tomzx\HackBot\Core;

abstract class Adapter
{
	protected Dispatcher $dispatcher = null;

	public function setDispatcher(Dispatcher $dispatcher) : this
	{
		$this->dispatcher = $dispatcher;

		return $this;
	}

	public abstract function run();
}