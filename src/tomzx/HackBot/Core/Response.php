<?hh // strict

namespace tomzx\HackBot\Core;

class Response
{
	protected array $meta = [];

	protected string $response = null;

	public function getMeta() : array
	{
		return $this->meta;
	}

	public function setMeta(array $meta = []) : this
	{
		$this->meta = $meta;

		return $this;
	}

	public function getResponse() : ?string
	{
		return $this->response;
	}

	public function setResponse(?string $response) : this
	{
		$this->response = $response;

		return $this;
	}

	public function hasResponse() : bool
	{
		return $this->response !== null;
	}
}