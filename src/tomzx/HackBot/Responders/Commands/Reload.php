<?hh // strict

namespace tomzx\HackBot\Responders\Commands;

use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Core\Responders\Command;

return [
	'type' => 'command',
	'identifier' => 'reload',
	'command' => 'reload',
	'parameters' => '(?<target>\S+|all)',
	'help' => 'plugin|all',
	'answer' => function (Dispatcher $dispatcher, array $data = [])
	{
		$targets = $data['target'] === 'all' ? [] : explode(' ', $data['target']);
		$reloadedResponders = $dispatcher->reloadResponders($targets);
		$reloadedResponders = array_map(function($responder) { return $responder->getIdentifier(); }, $reloadedResponders);
		$reloadedResponders = ! empty($reloadedResponders) ? 'reloaded '.implode(', ', $reloadedResponders) : 'Nothing reloaded';
		return $reloadedResponders;
	}
];