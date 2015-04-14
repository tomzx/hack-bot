<?hh // strict

namespace tomzx\HackBot\Adapters;

use tomzx\HackBot\Core\Adapter;
use tomzx\HackBot\Core\Request;

class Web extends Adapter
{
	public function run()
	{
		$query = $_GET['q'];

		$request = new Request();
		$request->setRequest($query);

		$responseBag = $this->dispatcher->dispatch($request);
		$outputResponse = [];
		foreach ($responseBag->all() as $response) {
			if ($response->hasResponse()) {
				$outputResponse[] = $response->getResponse();
			}
		}

		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($outputResponse);
	}
}