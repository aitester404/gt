<?php

namespace MinyonPlugin\entity;

use pocketmine\entity\Human;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use pocketmine\math\Vector3;
use MinyonPlugin\task\MinionMineTask;

class Minion extends Human {

    protected array $storage = [];

    public static function createBaseNBT($pos): CompoundTag {
        return CompoundTag::create(); // ✔ PM5 için doğru yöntem
    }

    protected function initEntity(CompoundTag $nbt): void {
        parent::initEntity($nbt);

        $this->setScale(0.66);

        $this->getInventory()->setItemInHand(VanillaItems::DIAMOND_PICKAXE());

        $this->getServer()->getScheduler()->scheduleRepeatingTask(
            new MinionMineTask($this),
            40
        );
    }

    public function addItem(string $id, int $count = 1): void {
        if(!isset($this->storage[$id])) $this->storage[$id] = 0;
        $this->storage[$id] += $count;
    }

    public function onInteract(Player $player, Vector3 $clickPos): bool {

        $player->sendMessage("§b--- Minyon Envanteri ---");

        if(empty($this->storage)){
            $player->sendMessage("§7Envanter boş.");
            return true;
        }

        foreach($this->storage as $id => $count){
            $player->sendMessage("§a$id §fx§e$count");
        }
        return true;
    }
}
