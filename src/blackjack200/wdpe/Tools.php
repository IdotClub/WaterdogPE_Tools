<?php


namespace blackjack200\wdpe;


use blackjack200\essential\Essentials;
use blackjack200\protocol\PracticeProtocol;
use blackjack200\wdpe\player\PMPlayer;
use blackjack200\wdpe\player\PracticeCorePlayer;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\DebugInfoPacket;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;

class Tools extends PluginBase implements Listener {
	private string $class;

	public function onEnable() : void {
		$server = $this->getServer();
		$map = $server->getCommandMap();

		$map->register('', new WaterdogTransferCommand());
		$map->register('', new ExtendedWaterdogTransferCommand());

		$server->getPluginManager()->registerEvents($this, $this);
		$this->getScheduler()->scheduleRepeatingTask(new UpdateLatencyTask(), 100);
		$fulfill = static fn($p) => $server->getPluginManager()->getPlugin($p) !== null;

		if ($fulfill('PracticeCore')) {
			$this->class = PracticeCorePlayer::class;
		} else {
			$this->class = PMPlayer::class;
		}
		if ($fulfill('PracticeProtocol')) {
			Essentials::register('transfer', static fn(string $player, string $type) => PracticeProtocol::getInstance()->getReporter()->select($type)->whenFulfill(static function(?string $result) use ($type, $player) : void {
				$player = Server::getInstance()->getPlayerByPrefix($player);
				if ($player !== null) {
					if ($result === null) {
						$player->sendMessage("§5Failed connected to $type, please try again later.");
						return;
					}
					$player->sendMessage("§aTransfering to $result");
					self::connectProxyServer($player, $result);
				}
			})->settle());
		}
	}

	/** @priority MONITOR */
	public function onPlayerCreation(PlayerCreationEvent $event) : void {
		$event->setPlayerClass($this->class);
	}

	public function onDataPacketReceive(DataPacketReceiveEvent $event) : void {
		$pk = $event->getPacket();
		if ($pk::NETWORK_ID === DebugInfoPacket::NETWORK_ID) {
			$player = $event->getOrigin()->getPlayer();
			if ($player !== null) {
				assert($pk instanceof DebugInfoPacket);
				assert($player instanceof WaterdogInterface);
				$parts = explode(':', $pk->getData());
				if (count($parts) > 2 && $parts[0] === 'waterdog' && $parts[1] === 'ping') {
					$player->updatePing((int) $parts[2]);
				}
			}
		}
	}

	public static function connectProxyServer(Player $player, string $name) : void {
		$pk = DebugInfoPacket::create(0, 'waterdog:transfer:' . $name);
		$player->getNetworkSession()->sendDataPacket($pk);
	}

	public static function dispatchProxyCommand(Player $player, string $command) : void {
		$pk = DebugInfoPacket::create(0, 'waterdog:dispatch:' . $command);
		$player->getNetworkSession()->sendDataPacket($pk);
	}
}