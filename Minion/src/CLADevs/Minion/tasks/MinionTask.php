<?php

namespace CLADevs\Minion\tasks;

use pocketmine\entity\Human;
use pocketmine\entity\location\Location;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Skin;
use pocketmine\world\World;

class MinionTask extends Human {

    public const NETWORK_ID = Human::NETWORK_ID;

    private int $tickCount = 0;

    public function __construct(Location $location, Skin $skin, ?CompoundTag $nbt = null) {
        parent::__construct($location, $nbt);
        $this->setSkin($skin);
        $this->setScale(0.66); // 2/3 boyut
        $this->setNameTagAlwaysVisible(true);
        $this->setNameTag("§bMinion");
        $this->setImmobile(true); // Kendi başına yürüyemez
    }

    protected function initEntity(CompoundTag $nbt): void {
        parent::initEntity($nbt);
    }

    public function onUpdate(int $currentTick): bool {
        $this->tickCount++;
        // Her 10 tickte kazma animasyonu
        if($this->tickCount % 10 === 0){
            $this->swingArm(); // Animasyon efekti
        }
        return parent::onUpdate($currentTick);
    }

    private function swingArm(): void {
        $this->broadcastEntityEvent(Human::ARM_SWING);
    }
}
