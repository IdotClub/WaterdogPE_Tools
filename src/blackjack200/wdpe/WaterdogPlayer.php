<?php


namespace blackjack200\wdpe;


use pocketmine\network\mcpe\protocol\DebugInfoPacket;
use pocketmine\player\Player;

class WaterdogPlayer extends Player {
	private int $latency = -1;

	public function getLatency() : int {
		return $this->latency;
	}

	/** @internal */
	public function updateLatency(int $latency) : void {
		$this->latency = $latency;
	}

	public function connectProxyServer(string $name) : void {
		$pk = DebugInfoPacket::create(0, 'waterdog:transfer:' . $name);
		$this->getNetworkSession()->sendDataPacket($pk);
	}

	public function dispatchProxyCommand(string $command) : void {
		$pk = DebugInfoPacket::create(0, 'waterdog:dispatch:' . $command);
		$this->getNetworkSession()->sendDataPacket($pk);
	}
}