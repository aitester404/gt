<?php

namespace MinyonPlugin\entity;

use pocketmine\entity\Human;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use pocketmine\math\Vector3;
use pocketmine\item\Item;
use pocketmine\entity\EntityDataHelper;
use pocketmine\utils\TextFormat;
use MinyonPlugin\task\MinionMineTask;

class Minion extends Human {

    /** ✔ Human::$inventory ile çakışmaması için farklı isim */
    protected array $storage = [];

    public static function createBaseNBT($pos): CompoundTag {
        return EntityDataHelper::createBaseNBT($pos);
    }

    protected function initEntity(CompoundTag $nbt): void {
        parent::initEntity($nbt);

        $this->setScale(0.66);

        // El
        $this->getInventory()->setItemInHand(VanillaItems::DIAMOND_PICKAXE());

        // Görev
        $this->getServer()->getScheduler()->scheduleRepeatingTask(
            new MinionMineTask($this),
            40
        );
    }

    public function addItem(string $id, int $count = 1): void {
        if(!isset($this->storage[$id])) $this->storage[$id] = 0;
        $this->storage[$id] += $count;
    }

    /** PM5 doğru imza */
    public function onInteract(Player $player, Item $item, Vector3 $clickPos): bool {
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

