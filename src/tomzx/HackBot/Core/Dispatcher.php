<?hh // strict

namespace tomzx\HackBot\Core;

class Dispatcher
{
	protected array $responders = [];

	public function initializeResponders() : void
	{
		// TODO: Dynamically load responders
		$responders = [
			new \tomzx\HackBot\Responders\Commands\Alias(),
			new \tomzx\HackBot\Responders\Commands\Help(),
			new \tomzx\HackBot\Responders\Commands\Info(),
			new \tomzx\HackBot\Responders\Listeners\URL(),
		];

		foreach ($responders as $responder) {
			$this->registerResponder($responder);
		}
	}

	public function registerResponder(Responder $responder) : void
	{
		$responder->setDispatcher($this);
		$key = $responder->getIdentifier();
		$this->responders[$key] = $responder;
	}

	public function getResponders() : array
	{
		return $this->responders;
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