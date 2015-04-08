<?hh // strict

namespace tomzx\HackBot\Core;

use tomzx\HackBot\Core\Logger;
use tomzx\HackBot\Core\Responders\Command;
use tomzx\HackBot\Core\Responders\Listener;

class Dispatcher
{
	protected array $responders = [];

	public function initializeResponders() : void
	{
		// TODO: Support specifying paths where to find responders
		$baseDir = realpath(__DIR__.'/../Responders');
		$responders = glob($baseDir.'/*/*.php');

		foreach ($responders as $responder) {
			// TODO: Hack until hhvm supports dynamic include (https://github.com/facebook/hhvm/issues/1447)
			$responderDefinition = eval(str_replace('<?hh // strict', '', file_get_contents($responder)));
			if ($responderDefinition['type'] === 'listener') {
				$responder = Listener::fromDefinition($responderDefinition);
			} elseif ($responderDefinition['type'] === 'command') {
				$responder = Command::fromDefinition($responderDefinition);
			} else {
				Logger::log('Unknown responder type for file '.$responder.'. Skipped.');
				continue;
			}

			$this->registerResponder($responder);
		}
	}

	public function registerResponder(Responder $responder) : void
	{
		$responder->setDispatcher($this);
		$key = $responder->getIdentifier();
		$this->responders[$key] = $responder;
		Logger::log('Registered responder '.$responder->getIdentifier());
	}

	public function getResponders() : array
	{
		return $this->responders;
	}

	public function reloadResponders() : void
	{
		$this->responders = [];
		$this->initializeResponders();
	}

	public function dispatch(Request $request) : Response
	{
		// Check if any responder can respond
		foreach ($this->responders as $responder) {
			$response = $responder->respond($request->getRequest());
			if ($response) {
				// TODO: Support returning multiple responses (yield?)
				return $this->buildResponse($request, $response);
			}
		}

		// Return response to caller
		return $this->buildResponse($request, null);
	}

	protected function buildResponse(Request $request, ?string $response) : Response
	{
		$reply = new Response();
		$reply->setMeta($request->getMeta());
		$reply->setResponse($response);
		return $reply;
	}
}