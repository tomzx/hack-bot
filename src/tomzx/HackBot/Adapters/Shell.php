<?hh // strict

namespace tomzx\HackBot\Adapters;

use tomzx\HackBot\Core\Adapter;
use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Core\Request;

class Shell extends Adapter
{
	public function run()
	{
		pcntl_signal(SIGINT, [$this, 'interrupt'], false);
		register_shutdown_function([$this, 'shutdown']);

		$dataDirectory = 'data';
		$dataFile = $dataDirectory.'/shell.readline';
		if (file_exists($dataFile)) {
			readline_read_history($dataFile);
		}

		while(true) {
			$query = trim(readline('> '));
			if ($query === 'exit') {
				break;
			}

			readline_add_history($query);

			echo 'Initial query: '.$query.PHP_EOL;

			$request = new Request();
			$request->setRequest($query);

			$responseBag = $this->dispatcher->dispatch($request);

			echo 'Processed query: '.$request->getRequest().PHP_EOL;

			foreach ($responseBag->all() as $index => $response) {
				echo 'Reply #'.$index.PHP_EOL;
				var_dump($response->hasResponse());
				var_dump($response->getResponse());
			}
		}
	}

	public function interrupt()
	{
		exit;
	}

	public function shutdown()
	{
		$dataDirectory = 'data';
		$dataFile = $dataDirectory.'/shell.readline';
		readline_write_history($dataFile);
	}
}