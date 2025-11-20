<?php

namespace CLADevs\Minion\tasks;

use pocketmine\scheduler\Task;
use CLADevs\Minion\MinionManager;

class MinionTask extends Task {

    private MinionManager $manager;

    public function __construct(MinionManager $manager) {
        $this->manager = $manager;
    }

    public function onRun(): void {
        $this->manager->tickMinions();
    }
}
