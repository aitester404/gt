<?php

namespace CLADevs\Minion;

use pocketmine\player\Player;
use pocketmine\world\Position;

class Minion {

    private Player $owner;
    private Position $position;
    private int $level;
    private int $resource = 0;

    public function __construct(Player $owner, Position $position, int $level = 1) {
        $this->owner = $owner;
        $this->position = $position;
        $this->level = $level;
    }

    public function tick(): void {
        // Örnek: her tickte level kadar resource üret
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
}
