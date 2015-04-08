<?hh // strict

namespace tomzx\HackBot\Core;

class ResponseBag
{
	protected array $responses = [];

	public function all() : array
	{
		return $this->responses;
	}

	public function add(Response $response) : this
	{
		return $this->responses[] = $response;

		return $this;
	}

	public function hasResponses() : bool
	{
		return ! empty($this->responses);
	}
}