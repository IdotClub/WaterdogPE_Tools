<?php


namespace blackjack200\wdpe;


use pocketmine\network\mcpe\protocol\ScriptCustomEventPacket;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class UpdateLatencyTask extends Task {

	public function onRun(int $currentTick) {
		$pk = new ScriptCustomEventPacket();
		$pk->eventName = 'waterdog:latency';
		$pk->eventData = '';
		foreach (Server::getInstance()->getOnlinePlayers() as $player) {
			assert($player instanceof WaterdogPlayer);
			$player->dataPacket($pk);
		}
	}
}