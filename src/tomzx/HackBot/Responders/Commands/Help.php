<?hh // strict

namespace tomzx\HackBot\Responders\Commands;

use tomzx\HackBot\Core\Responders\Command;

class Help extends Command
{
	public string $command = 'help';

	public function answer(array $data = []) : ?string
	{
		$responders = $this->dispatcher->getResponders();
		return implode(',', array_keys($responders));
	}
}
