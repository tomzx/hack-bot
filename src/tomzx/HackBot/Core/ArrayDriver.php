<?hh // strict

namespace tomzx\HackBot\Core;

use BeatSwitch\Lock\Drivers\ArrayDriver as BaseArrayDriver;

class ArrayDriver extends BaseArrayDriver
{
	public function load(string $file) : void
	{
		if ( ! file_exists($file)) {
			return;
		}
		$this->permissions = unserialize(file_get_contents($file));
	}

	public function save(string $file) : void
	{
		file_put_contents($file, serialize($this->permissions));
	}
}