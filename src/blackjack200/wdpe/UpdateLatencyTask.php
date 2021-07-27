<?php


namespace blackjack200\wdpe;


use pocketmine\network\mcpe\protocol\DebugInfoPacket;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class UpdateLatencyTask extends Task {

	public function onRun() : void {
		$pk = DebugInfoPacket::create(0, 'waterdog:ping');
		foreach (Server::getInstance()->getOnlinePlayers() as $player) {
			if ($player->spawned) {
				$player->getNetworkSession()->sendDataPacket($pk);
			}
		}
	}
}