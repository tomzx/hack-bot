<?hh // strict

namespace tomzx\HackBot\Responders\Commands;

use Arry\Arry;
use tomzx\HackBot\Adapters\IRC;
use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Core\User;
use tomzx\HackBot\Core\Responders\Command;

return [
	'type' => 'command',
	'identifier' => 'permission-allow',
	'command' => 'permission-allow',
	'parameters' => '(?<user>\S+) (?<permissions>.*)',
	'help' => 'user permission [permissions ...]',
	'answer' => function (Dispatcher $dispatcher, array $data = [])
	{
		// TODO: Only allow logged-in/server authenticated users to give users permissions
		$adapter = Arry::get($data, 'meta.irc.adapter');
		if ( ! $adapter) {
			return;
		}

		$from = Arry::get($data, 'meta.irc.nick');
		$user = Arry::get($data, 'user');
		$permissions = explode(' ', Arry::get($data, 'permissions'));

		$lockManager = $dispatcher->getLockManager();

		$fromLock = $lockManager->caller(new User($from));

		if ( ! $fromLock->can('permissions.write')) {
			return 'You are not allowed to edit permissions.';
		}

		$userLock = $lockManager->caller(new User($user));

		foreach ($permissions as $permission) {
			$userLock->allow($permission);
		}

		return 'The following permissions were given to user '.$user.': '.implode(', ', $permissions);
	}
];