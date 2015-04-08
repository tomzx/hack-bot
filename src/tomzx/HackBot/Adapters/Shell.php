<?hh // strict

namespace tomzx\HackBot\Adapters;

use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Core\Request;

class Shell
{
	protected Dispatcher $dispatcher = null;

	public function setDispatcher(Dispatcher $dispatcher) : this
	{
		$this->dispatcher = $dispatcher;

		return $this;
	}

	public function run()
	{
		while(true) {
			$query = trim(fgets(STDIN));
			if ($query === 'exit') {
				break;
			}

			$request = new Request();
			$request->setRequest($query);

			$response = $this->dispatcher->dispatch($request);
			echo 'QUERY WAS: '.$query.PHP_EOL;
			var_dump($response->hasResponse());
			var_dump($response->getResponse());
		}
	}
}