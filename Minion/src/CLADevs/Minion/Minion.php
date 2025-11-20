<?php

namespace CLADevs\Minion;

use CLADevs\Minion\tasks\MinionEntity;
use pocketmine\player\Player;

class Minion {

    private Player $owner;
    private int $level;
    private int $resource = 0;
    private ?MinionEntity $entity = null;

    public function __construct(Player $owner, int $level = 1){
        $this->owner = $owner;
        $this->level = $level;

        $this->spawnEntity();
    }

    private function spawnEntity(): void {
        $eyePos = $this->owner->getEyePos();
        $direction = $this->owner->getDirectionVector();
        $spawnPos = $eyePos->add($direction); // İmlecin baktığı yere spawn

        $skin = $this->owner->getSkin(); // Oyuncunun skin'i
        $this->entity = new MinionEntity($spawnPos, $skin);
        $this->entity->setRotation($this->owner->getLocation()->getYaw(), $this->owner->getLocation()->getPitch());
        $this->entity->spawnToAll();
    }

    public function tick(): void {
        $this->resource += $this->level;
    }

    public function upgrade(): void {
        $this->level++;
    }

    public function getLevel(): int {
        return $this->level;
    }

    public function getResource(): int {
        return $this->resource;
    }

    public function getOwner(): Player {
        return $this->owner;
    }

    public function getEntity(): ?MinionEntity {
        return $this->entity;
    }
}
