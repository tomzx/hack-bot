<?hh // strict

namespace tomzx\HackBot\Core\Responders;

use tomzx\HackBot\Core\Responder;

abstract class Command extends Responder
{
	protected string $commandMatcher = '#';

	protected string $command = null;

	protected string $parameters = null;

	public function respond(?string $text) : ?string
	{
		if ($response = parent::respond($text)) {
			return $response;
		}

		if (preg_match('/^'.$this->getMatcherCommand().'/', $text)) {
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
}