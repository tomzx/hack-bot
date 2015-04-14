<?hh // strict

namespace tomzx\HackBot\Core;

use tomzx\HackBot\Core\Logger;
use tomzx\HackBot\Core\Responders\Command;
use tomzx\HackBot\Core\Responders\Listener;

class Dispatcher
{
	protected array $responders = [];

	public function initializeResponders(array $toInitialize = []) : array
	{
		// TODO: Support specifying paths where to find responders
		$baseDir = realpath(__DIR__.'/../Responders');
		$responders = glob($baseDir.'/*/*.php');

		$initializedResponders = [];
		foreach ($responders as $responder) {
			// TODO: Hack until hhvm supports dynamic include (https://github.com/facebook/hhvm/issues/1447)
			$responderDefinition = eval(str_replace('<?hh // strict', '', file_get_contents($responder)));

			if ( ! $responderDefinition) {
				Logger::debug('Error while parsing responder definition file '.$responder.'. Skipped.');
				continue;
			}

			// Skip responder if it is not to be initialized.
			if ( ! empty($toInitialize) && ! in_array($responderDefinition['identifier'], $toInitialize)) {
				continue;
			}

			if ($responderDefinition['type'] === 'listener') {
				$responder = Listener::fromDefinition($responderDefinition);
			} elseif ($responderDefinition['type'] === 'command') {
				$responder = Command::fromDefinition($responderDefinition);
			} else {
				Logger::debug('Unknown responder type for file '.$responder.'. Skipped.');
				continue;
			}

			$this->registerResponder($responder);
			$initializedResponders[] = $responder;
		}

		return $initializedResponders;
	}

	public function registerResponder(Responder $responder) : void
	{
		$responder->setDispatcher($this);
		$key = $responder->getIdentifier();
		$this->responders[$key] = $responder;
		Logger::info('Registered responder '.$key);
	}

	public function getResponders() : array
	{
		return $this->responders;
	}

	public function reloadResponders(array $toReload = []) : array
	{
		foreach ($toReload as $responder) {
			if (isset($this->responders[$responder])) {
				unset($this->responder[$responder]);
				Logger::debug('Unloaded responder '.$responder);
			}
		}
		return $this->initializeResponders($toReload);
	}

	public function reloadResponder($identifier) : array
	{
		return $this->reloadResponders([$identifier]);
	}

	public function dispatch(Request $request) : ResponseBag
	{
		$responseBag = new ResponseBag();
		// Check if any responder can respond
		foreach ($this->responders as $responder) {
			$responses = $responder->respond($request);
			foreach ($responses as $response) {
				if (empty($response)) {
					continue;
				}
				$responseBag->add($this->buildResponse($request, $response));
			}
		}

		return $responseBag;
	}

	protected function buildResponse(Request $request, ?string $response) : Response
	{
		$reply = new Response();
		$reply->setMeta($request->getMeta());
		$reply->setResponse($response);
		return $reply;
	}
}