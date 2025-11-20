<?php

namespace CLADevs\Minion;

use CLADevs\Minion\entity\MinionEntity;
use pocketmine\player\Player;
use pocketmine\world\Position;

class Minion {

    private Player $owner;
    private Position $position;
    private int $level;
    private int $resource = 0;

    private ?MinionEntity $entity = null;

    public function __construct(Player $owner, Position $position, int $level = 1) {
        $this->owner = $owner;
        $this->position = $position;
        $this->level = $level;

        $this->spawnEntity();
    }

    private function spawnEntity(): void {
        $skin = $this->owner->getSkin(); // Oyuncunun skin'i
        $this->entity = new MinionEntity($this->position, $skin);
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
