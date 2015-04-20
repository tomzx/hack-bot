<?hh // strict

namespace tomzx\HackBot\Core\Responders;

use tomzx\HackBot\Core\Request;
use tomzx\HackBot\Core\Responder;

class Command extends Responder
{
	protected string $commandMatcher = '#';

	protected string $command = null;

	protected string $parameters = null;

	protected string $modifiers = null;

	public function respond(Request $request) : array
	{
		if ($response = parent::respond($request)) {
			return $response;
		}

		if (preg_match($this->getPartialMatcher(), $request->getRequest())) {
			return [$this->help()];
		}

		return [];
	}

	public function help() : string
	{
		return 'Usage: '.$this->getMatcherCommand().' '.$this->getHelp();
	}

	protected function getPartialMatcher() : string
	{
		return '/^'.$this->getMatcherCommand().'( |$)/';
	}

	protected function getMatcher() : string
	{
		$command = $this->getMatcherCommand();
		$command = $this->parameters ? $command.' '.$this->parameters : $command;
		return '/^'.$command.'$/'.$this->modifiers;
	}

	protected function getMatcherCommand() : string
	{
		return $this->commandMatcher.$this->command;
	}

	public function getCommandMatcher() : string
	{
		return $this->commandMatcher;
	}

	public function setCommandMatcher(string $commandMatcher) : this
	{
		$this->commandMatcher = $commandMatcher;

		return $this;
	}

	public function getCommand() : string
	{
		return $this->command;
	}

	public function setCommand(string $command) : this
	{
		$this->command = $command;

		return $this;
	}

	public function getParameters() : string
	{
		return $this->parameters;
	}

	public function setParameters(string $parameters) : this
	{
		$this->parameters = $parameters;

		return $this;
	}

	public function getModifiers() : string
	{
		return $this->modifiers;
	}

	public function setModifiers(string $modifiers) : this
	{
		$this->modifiers = $modifiers;

		return $this;
	}

	public static function fromDefinition(array $definition) : this
	{
		$definition += [
			'identifier' => null,
			'command' => null,
			'parameters' => '',
			'modifiers' => '',
			'help' => null,
			'answer' => null,
		];

		$command = new self;
		$command->setIdentifier($definition['identifier']);
		$command->setCommand($definition['command']);
		$command->setParameters($definition['parameters']);
		$command->setModifiers($definition['modifiers']);
		$command->setHelp($definition['help']);
		$command->setAnswer($definition['answer']);
		return $command;
	}
}