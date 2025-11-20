<?php

namespace CLADevs\Minion;

use pocketmine\player\Player;

class MinionManager {

    /** @var Minion[] */
    private array $minions = [];
    private \pocketmine\plugin\PluginBase $plugin;

    public function __construct(\pocketmine\plugin\PluginBase $plugin) {
        $this->plugin = $plugin;
    }

    public function addMinion(Player $player, $position): void {
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
