<?php


namespace blackjack200\wdpe;


use pocketmine\network\mcpe\protocol\DebugInfoPacket;
use pocketmine\Player;

class WaterdogPlayer extends Player {
	private int $latency = -1;

	public function getLatency() : int {
		return $this->latency;
	}

	public function getPing() : int {
		return $this->getLatency();
	}

	/** @internal */
	public function updateLatency(int $latency) : void {
		$this->latency = $latency;
	}

	public function connectProxyServer(string $name) : void {
		$pk = DebugInfoPacket::create(0, 'waterdog:transfer:' . $name);
		$this->dataPacket($pk);
	}

	public function dispatchProxyCommand(string $command) : void {
		$pk = DebugInfoPacket::create(0, 'waterdog:dispatch:' . $command);
		$this->dataPacket($pk);
	}
}