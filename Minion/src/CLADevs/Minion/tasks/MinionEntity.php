<?php

namespace CLADevs\Minion\tasks;

use pocketmine\entity\Human;
use pocketmine\entity\location\Location;
use pocketmine\player\Skin;
use pocketmine\nbt\tag\CompoundTag;

class MinionEntity extends Human {

    private int $tickCount = 0;

    public function __construct(Location $location, Skin $skin, ?CompoundTag $nbt = null){
        parent::__construct($location, $nbt);
        $this->setSkin($skin);
        $this->setScale(0.66);
        $this->setNameTag("§bMinion");
        $this->setNameTagAlwaysVisible(true);
        $this->setImmobile(true);
    }

    protected function initEntity(CompoundTag $nbt): void {
        parent::initEntity($nbt);
    }

    public function onUpdate(int $currentTick): bool {
        $this->tickCount++;
        if($this->tickCount % 10 === 0){
            $this->broadcastEntityEvent(Human::ARM_SWING);
        }
        return parent::onUpdate($currentTick);
    }
}
