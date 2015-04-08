<?hh // strict

namespace tomzx\HackBot\Core;

abstract class Responder
{
	protected Dispatcher $dispatcher;

	protected string $identifier = null;

	protected callable $answer;

	protected string $help = null;

	public function __construct() : void
	{
		$this->answer = function(Dispatcher $dispatcher, array $data) {};
	}

	public function respond(Request $request) : array
	{
		if (preg_match($this->getMatcher(), $request->getRequest(), $matches)) {
			$matches = $this->cleanMatches($matches);
			$data = ['meta' => $request->getMeta()] + $matches;
			return $this->answer($data);
		}

		return [];
	}

	private function cleanMatches(array $matches) : array
	{
		foreach($matches as $k => $v) {
			if(is_int($k)) {
				unset($matches[$k]);
			}
		}
		return $matches;
	}

	protected abstract function getMatcher() : string;

	public function answer(array $data = []) : array
	{
		return (array)($this->answer)($this->dispatcher, $data);
	}

	public function help() : string
	{
		return '';
	}

	public function setDispatcher(Dispatcher $dispatcher) : this
	{
		$this->dispatcher = $dispatcher;

		return $this;
	}

	public function getIdentifier() : ?string
	{
		return $this->identifier;
	}

	public function setIdentifier(string $identifier) : this
	{
		$this->identifier = $identifier;

		return $this;
	}

	public function getAnswer() : callable
	{
		return $this->answer;
	}

	public function setAnswer(callable $answer) : this
	{
		$this->answer = $answer;

		return $this;
	}

	public function getHelp() : ?string
	{
		return $this->help;
	}

	public function setHelp(string $help) : this
	{
		$this->help = $help;

		return $this;
	}
}