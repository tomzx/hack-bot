<?hh // strict

namespace tomzx\HackBot\Responders\Listeners;

use Arry\Arry;
use Illuminate\Database\Capsule\Manager as Capsule;
use tomzx\HackBot\Adapters\IRC;
use tomzx\HackBot\Core\Dispatcher;
use tomzx\HackBot\Core\Responders\Listener;

return [
	'type' => 'listener',
	'identifier' => 'irc_recorder',
	'matcher' => '/(?<message>.*)/',
	'answer' => function (Dispatcher $dispatcher, array $data = [])
	{
		$start = microtime(true);
		$timestamp = time();
		$server = strtolower(Arry::get($data, 'meta.irc.server'));
		$channel = strtolower(Arry::get($data, 'meta.irc.sent_to'));
		$nick = Arry::get($data, 'meta.irc.nick');
		$message = Arry::get($data, 'message');

		if ( ! $server || ! $channel || ! $nick || ! $message ) {
			return;
		}

		$dbFile = $dispatcher->dataPath('irc-logs.sqlite');

		if ( ! file_exists($dbFile)) {
			touch($dbFile);
		}

		$capsule = new Capsule;
		$capsule->addConnection([
			'driver'   => 'sqlite',
			'database' => $dbFile,
			'prefix'   => '',
		]);
		$capsule->setAsGlobal();

		$db = Capsule::connection();

		$db->statement('CREATE TABLE IF NOT EXISTS logs (
			id INTEGER primary key autoincrement,
			channel_id INTEGER,
			timestamp INTEGER,
			nick VARCHAR(255),
			message TEXT
		);');

		// // TODO: server should be unique
		$db->statement('CREATE TABLE IF NOT EXISTS networks (
			id INTEGER primary key autoincrement,
			server VARCHAR(255)
		);');

		// // TODO: channel/network_id should be unique
		$db->statement('CREATE TABLE IF NOT EXISTS channels (
			id INTEGER primary key autoincrement,
			network_id INTEGER,
			channel VARCHAR(255)
		);');

		$db->statement('CREATE TABLE IF NOT EXISTS channels (
			id INTEGER primary key autoincrement,
			network_id INTEGER,
			channel VARCHAR(255)
		);');

		$targetNetwork = $db->table('networks')->select('id')->where('server', '=', $server)->first();
		if ($targetNetwork) {
			$network_id = $targetNetwork['id'];
		} else {
			$network_id = $db->table('networks')->insertGetId([
				'server' => $server,
			]);
		}

		$targetChannel = $db->table('channels')->select('id')->where('network_id', '=', $network_id)->where('channel', '=', $channel)->first();
		if ($targetChannel) {
			$channel_id = $targetChannel['id'];
		} else {
			$channel_id = $db->table('channels')->insertGetId([
				'network_id' => $network_id,
				'channel' => $channel,
			]);
		}

		$db->table('logs')->insert([
			'channel_id' => $channel_id,
			'timestamp' => $timestamp,
			'nick' => $nick,
			'message' => $message,
		]);

		echo microtime(true) - $start;
	}
];