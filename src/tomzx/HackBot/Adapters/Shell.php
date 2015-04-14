<?hh // strict

namespace tomzx\HackBot\Adapters;

use tomzx\HackBot\Core\Adapter;
use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Core\Request;

class Shell extends Adapter
{
	public function run()
	{
		while(true) {
			$query = trim(readline('> '));
			if ($query === 'exit') {
				break;
			}

			readline_add_history($query);

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