<?php

namespace CLADevs\Minion;

use pocketmine\player\Player;

class MinionManager {

    /** @var Minion[] */
    private array $minions = [];

    public function addMinion(Player $player, int $level = 1): void {
        $minion = new Minion($player, $level);
        $this->minions[spl_object_id($minion)] = $minion;
    }

    public function getMinions(): array {
        return $this->minions;
    }
}
