<?php


namespace blackjack200\wdpe;


interface WaterdogInterface {
	public function getPing() : int;

	/** @internal */
	public function updatePing(int $ping) : void;
}