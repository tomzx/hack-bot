<?hh // strict

namespace tomzx\HackBot\Responders\Commands;

use tomzx\HackBot\Core\Responders\Command;

class Info extends Command
{
	public string $command = 'info';

	public function answer(array $data = []) : ?string
	{
		return 'INFO';
	}
}
