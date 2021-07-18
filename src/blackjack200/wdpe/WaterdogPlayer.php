<?php


namespace blackjack200\wdpe;


use pocketmine\network\mcpe\protocol\ScriptCustomEventPacket;
use pocketmine\Player;

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
		$pk = new ScriptCustomEventPacket();
		$pk->eventName = 'waterdog:transfer';
		$pk->eventData = $name;
		$this->dataPacket($pk);
	}

	public function dispatchProxyCommand(string $command) : void {
		$pk = new ScriptCustomEventPacket();
		$pk->eventName = 'waterdog:dispatch';
		$pk->eventData = $command;
		$this->dataPacket($pk);
	}
}