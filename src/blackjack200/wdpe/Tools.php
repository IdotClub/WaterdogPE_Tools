<?php


namespace blackjack200\wdpe;


use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\ScriptCustomEventPacket;
use pocketmine\plugin\PluginBase;

class Tools extends PluginBase implements Listener {
	public function onEnable() : void {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	public function onDataPacketReceive(DataPacketReceiveEvent $event) : void {
		$pk = $event->getPacket();
		if ($pk::NETWORK_ID === ScriptCustomEventPacket::NETWORK_ID) {
			$player = $event->getPlayer();
			assert($pk instanceof ScriptCustomEventPacket);
			assert($player instanceof WaterdogPlayer);
			if ($pk->eventName === 'waterdog:latency') {
				$player->updateLatency((int) $pk->eventData);
			}
		}
	}
}