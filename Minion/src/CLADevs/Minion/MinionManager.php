<?php

namespace CLADevs\Minion;

use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\world\Position;

class MinionManager {

    /** @var Minion[] */
    private array $minions = [];
    private PluginBase $plugin;

    public function __construct(PluginBase $plugin) {
        $this->plugin = $plugin;
    }

    public function addMinion(Player $player, Position $position): void {
        $this->minions[$player->getName()] = new Minion($player, $position);
    }

    public function getMinion(Player $player): ?Minion {
        return $this->minions[$player->getName()] ?? null;
    }

    public function tickMinions(): void {
        foreach($this->minions as $minion) {
            $minion->tick();
        }
    }
}
