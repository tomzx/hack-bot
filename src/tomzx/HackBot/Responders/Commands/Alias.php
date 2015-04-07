<?hh // strict

namespace tomzx\HackBot\Responders\Commands;

use tomzx\HackBot\Core\Responders\Command;

class Alias extends Command
{
	public string $command = 'alias';

	public string $parameters = '(?<command>[^ ]+)( (?<args>.*))?';

	public string $help = 'command <args>';

	public function answer(array $data = []) : string
	{
		return 'ALIAS';
	}
}