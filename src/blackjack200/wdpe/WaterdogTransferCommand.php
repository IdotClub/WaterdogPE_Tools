<?php


namespace blackjack200\wdpe;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Server;

class WaterdogTransferCommand extends Command {
	public function __construct() {
		parent::__construct('wdtransfer', 'WaterdogPE transfer', '/wdtransfer <player> <server>');
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) {
		if ($sender->isOp() && count($args) >= 2) {
			[$name, $server] = $args;
			$player = Server::getInstance()->getPlayerExact($name);
			if ($player !== null) {
				Tools::connectProxyServer($player, $server);
			} else {
				$sender->sendMessage('player not exist');
			}
		}
	}
}