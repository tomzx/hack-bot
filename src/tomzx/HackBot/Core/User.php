<?hh // strict

namespace tomzx\HackBot\Core;

use BeatSwitch\Lock\Callers\Caller;

class User implements Caller
{
	protected string $name;

	public function __construct(string $name) : void
	{
		$this->name = $name;
	}

	public function getCallerType() : string
	{
		return 'users';
	}

	public function getCallerId() : string
	{
		return $this->name;
	}

	public function getCallerRoles() : array
	{
		return [];
	}
}