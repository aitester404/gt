<?php

namespace CLADevs\Minion;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\VanillaItems;
use CLADevs\Minion\tasks\MinionTaskScheduler;

class Main extends PluginBase implements Listener {

    private MinionManager $manager;

    protected function onEnable(): void {
        $this->saveDefaultConfig();
        $this->manager = new MinionManager($this);
        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        $tickDelay = (int)$this->getConfig()->get("minion.tick-delay", 20);
        $this->getScheduler()->scheduleRepeatingTask(new MinionTaskScheduler($this->manager), $tickDelay);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if(!$sender instanceof Player) return false;

        if(strtolower($command->getName()) === "minion") {
            $minion = $this->manager->getMinion($sender);
            if(isset($args[0])){
                switch(strtolower($args[0])){
                    case "spawn":
                        if($minion === null){
                            $this->manager->addMinion($sender, $sender->getPosition());
                            $sender->sendMessage("Minion spawn edildi!");
                        } else {
                            $sender->sendMessage("Zaten bir minionun var!");
                        }
                        break;
                    case "upgrade":
                        if($minion !== null){
                            $minion->upgrade();
                            $sender->sendMessage("Minion level up oldu! Level: ".$minion->getLevel());
                        } else {
                            $sender->sendMessage("Önce minion spawn etmelisin!");
                        }
                        break;
                    case "info":
                        if($minion !== null){
                            $sender->sendMessage("Minion Level: ".$minion->getLevel()." | Resource: ".$minion->getResource());
                        } else {
                            $sender->sendMessage("Minion yok.");
                        }
                        break;
                    default:
                        $sender->sendMessage("Geçersiz argüman. Kullanım: /minion spawn|upgrade|info");
                }
            } else {
                $sender->sendMessage("Kullanım: /minion spawn|upgrade|info");
            }
            return true;
        }

        return false;
    }

    // Yumurta ile spawn
    public function onInteract(PlayerInteractEvent $event): void {
        $player = $event->getPlayer();
        $item = $event->getItem();

        if($item->getTypeId() === VanillaItems::EGG()->getTypeId()){
            if($this->manager->getMinion($player) === null){
                $this->manager->addMinion($player, $player->getPosition());
                $player->sendMessage("Minion spawn edildi!");
                $item->pop();
                $event->cancel();
            } else {
                $player->sendMessage("Zaten bir minionun var!");
            }
        }
    }

    public function getManager(): MinionManager {
        return $this->manager;
    }
}
