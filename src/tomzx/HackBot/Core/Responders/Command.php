<?hh // strict

namespace tomzx\HackBot\Core\Responders;

use tomzx\HackBot\Core\Request;
use tomzx\HackBot\Core\Responder;

class Command extends Responder
{
	protected string $commandMatcher = '#';

	protected string $command = null;

	protected string $parameters = null;

	public function respond(Request $request) : ?string
	{
		if ($response = parent::respond($request)) {
			return $response;
		}

		if (preg_match('/^'.$this->getMatcherCommand().'/', $request->getRequest())) {
			return $this->help();
		}

		return null;
	}

	public function help()
	{
		return 'Usage: '.$this->getMatcherCommand().' '.$this->getHelp();
	}

	protected function getMatcher()
	{
		$command = $this->getMatcherCommand();
		return $this->parameters ? '/^'.$command.' '.$this->parameters.'/' : '/^'.$command.'/';
	}

	protected function getMatcherCommand()
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

	public static function fromDefinition(array $definition) : this
	{
		$command = new self;
		$command->setIdentifier($definition['identifier']);
		$command->setCommand($definition['command']);
		$command->setParameters($definition['parameters']);
		$command->setHelp($definition['help']);
		$command->setAnswer($definition['answer']);
		return $command;
	}
}