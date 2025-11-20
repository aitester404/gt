<?php

namespace CLADevs\Minion\tasks;

use pocketmine\entity\Human;
use pocketmine\player\Skin;
use pocketmine\world\Position;
use pocketmine\nbt\tag\CompoundTag;

class MinionEntity extends Human {

    private int $tickCount = 0;

    public function __construct(Position $pos, Skin $skin, ?CompoundTag $nbt = null){
        parent::__construct($pos, $nbt);
        $this->setSkin($skin);
        $this->setScale(0.66); // 2/3 boyut
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
            $this->broadcastEntityEvent(Human::ARM_SWING); // Kazma animasyonu
        }
        return parent::onUpdate($currentTick);
    }
}

