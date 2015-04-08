<?hh // strict

namespace tomzx\HackBot\Core;

class Request
{
	protected array $meta = [];

	protected string $request = null;

	public function getMeta() : array
	{
		return $this->meta;
	}

	public function setMeta(array $meta) : this
	{
		$this->meta = $meta;

		return $this;
	}

	public function getRequest() : ?string
	{
		return $this->request;
	}

	public function setRequest(?string $request) : this
	{
		$this->request = $request;

		return $this;
	}
}