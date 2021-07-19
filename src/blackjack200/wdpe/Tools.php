<?php


namespace blackjack200\wdpe;


use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\DebugInfoPacket;
use pocketmine\plugin\PluginBase;

class Tools extends PluginBase implements Listener {
	public function onEnable() : void {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getScheduler()->scheduleRepeatingTask(new UpdateLatencyTask(), 10);
	}

	public function onDataPacketReceive(DataPacketReceiveEvent $event) : void {
		$pk = $event->getPacket();
		if ($pk::NETWORK_ID === DebugInfoPacket::NETWORK_ID) {
			$player = $event->getPlayer();
			assert($pk instanceof DebugInfoPacket);
			assert($player instanceof WaterdogPlayer);
			$parts = explode(':', $pk->getData());
			if (count($parts) > 2 && $parts[0] === 'waterdog') {
				if ($parts[1] === 'ping') {
					$player->updateLatency((int) $parts[2]);
				}
			}
		}
	}

	public function onPlayerCreation(PlayerCreationEvent $event) : void {
		$event->setPlayerClass(WaterdogPlayer::class);
	}
}