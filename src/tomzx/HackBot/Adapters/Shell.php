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

			echo 'QUERY WAS: '.$query.PHP_EOL;

			$request = new Request();
			$request->setRequest($query);

			$responseBag = $this->dispatcher->dispatch($request);
			foreach ($responseBag->all() as $index => $response) {
				echo 'Reply #'.$index.PHP_EOL;
				var_dump($response->hasResponse());
				var_dump($response->getResponse());
			}
		}
	}
}