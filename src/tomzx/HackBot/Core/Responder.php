<?hh // strict

namespace tomzx\HackBot\Core;

abstract class Responder
{
	protected Dispatcher $dispatcher;

	protected string $help = null;

	public function respond(?string $text) : ?string
	{
		if ($text === null) {
			return null;
		}

		if (preg_match($this->getMatcher(), $text, $matches)) {
			return $this->answer($matches);
		}

		return null;
	}

	protected abstract function getMatcher() : string;

	public abstract function answer(array $data = []) : ?string;

	public function help() : string
	{
		return '';
	}

	public function setDispatcher(Dispatcher $dispatcher) : this
	{
		$this->dispatcher = $dispatcher;

		return $this;
	}

	public function getHelp() : string
	{
		return $this->help;
	}

	public function setHelp(string $help) : this
	{
		$this->help = $help;

		return $this;
	}

	public function getIdentifier() : string
	{
		return get_class($this);
	}
}