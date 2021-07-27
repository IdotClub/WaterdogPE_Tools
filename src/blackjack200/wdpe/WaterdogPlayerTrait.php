<?php


namespace blackjack200\wdpe;


trait WaterdogPlayerTrait {
	protected int $ping;

	public function getPing() : int {
		return $this->ping;
	}

	/** @internal */
	public function updatePing(int $ping) : void {
		$this->ping = $ping;
	}
}