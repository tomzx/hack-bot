<?hh // strict

namespace tomzx\HackBot\Core;

use BeatSwitch\Lock\Lock;
use BeatSwitch\Lock\Manager;

class LockManager
{
	protected ArrayDriver $driver;

	protected Manager $manager;

	public function __construct() : void
	{
		$this->driver = new ArrayDriver();
		$this->driver->load(Helper::configPath('acl.php'));
		$this->manager = new Manager($this->driver);
	}

	public function __destruct() : void
	{
		$this->driver->save(Helper::configPath('acl.php'));
	}

	public function getManager() : Manager
	{
		return $this->manager;
	}
}