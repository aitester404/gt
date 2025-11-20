<?php

namespace MinyonPlugin\entity;

use pocketmine\entity\Human;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use pocketmine\block\BlockTypeIds;
use pocketmine\utils\TextFormat;
use MinyonPlugin\task\MinionMineTask;

class Minion extends Human {

    private array $inventory = [];

    protected function initEntity(CompoundTag $nbt): void {
        parent::initEntity($nbt);

        // Boyu küçült
        $this->setScale(0.66);

        // Elinde Efficiency V diamond pickaxe
        $item = VanillaItems::DIAMOND_PICKAXE()->setEnchantmentLevel(5);
        $this->getArmorInventory()->setItemInHand($item);

        // Kazma görevi
        $this->getServer()->getScheduler()->scheduleRepeatingTask(
            new MinionMineTask($this),
            40 // 2 saniye
        );
    }

    /** Kazılan itemleri ekler */
    public function addItem(string $id, int $count = 1){
        if(!isset($this->inventory[$id])) $this->inventory[$id] = 0;
        $this->inventory[$id] += $count;
    }

    /** Sağ tıklayınca */
    public function onInteract(Player $player, string $item): void {
        $player->sendMessage(TextFormat::AQUA . "Minyon Envanteri:");

        if(empty($this->inventory)){
            $player->sendMessage("Boş.");
            return;
        }

        foreach($this->inventory as $id => $count){
            $player->sendMessage("§7 - $id x$count");
        }
    }
}
