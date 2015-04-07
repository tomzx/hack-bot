<?hh // strict

namespace tomzx\HackBot\Core\Responders;

use tomzx\HackBot\Core\Responder;

abstract class Command extends Responder
{
	protected string $commandMatcher = '#';

	protected string $command = null;

	protected string $parameters = null;

	protected function getMatcher()
	{
		$command = $this->commandMatcher.$this->command;
		return $this->parameters ? '/^'.$command.' '.$this->parameters.'/' : '/^'.$command.'/';
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
}