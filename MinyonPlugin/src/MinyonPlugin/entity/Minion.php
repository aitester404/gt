<?php

namespace MinyonPlugin\entity;

use pocketmine\entity\Human;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use pocketmine\entity\EntityDataHelper;
use pocketmine\world\World;
use pocketmine\event\player\PlayerInteractEntityEvent;
use MinyonPlugin\task\MinionMineTask;

class Minion extends Human {

    /** Envanter → protected olmak zorunda */
    protected array $inventory = [];

    public static function createBaseNBT($pos) : CompoundTag {
        return EntityDataHelper::createBaseNBT($pos);
    }

    protected function initEntity(CompoundTag $nbt): void {
        parent::initEntity($nbt);

        // Boyu %66
        $this->setScale(0.66);

        // Elinde Efficiency V Diamond Pickaxe
        $pick = VanillaItems::DIAMOND_PICKAXE();
        $this->getInventory()->setItemInHand($pick);

        // Kazma AI Görevi
        $this->getServer()->getScheduler()->scheduleRepeatingTask(
            new MinionMineTask($this),
            40 // 2 saniyede bir
        );
    }

    /** Envantere item ekle */
    public function addItem(string $id, int $count = 1): void {
        if(!isset($this->inventory[$id])){
            $this->inventory[$id] = 0;
        }
        $this->inventory[$id] += $count;
    }

    /** Sağ tıklama */
    public function onInteract(Player $player, Item $item, Vector3 $clickPos) : bool {
        $player->sendMessage(TextFormat::AQUA . "---- Minyon Envanteri ----");

        if(empty($this->inventory)){
            $player->sendMessage("§7Minyonun envanteri boş.");
            return true;
        }

        foreach($this->inventory as $id => $count){
            $player->sendMessage("§b$id §fx §e$count");
        }

        return true;
    }
}
