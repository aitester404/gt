<?php

namespace MinyonPlugin\task;

use pocketmine\scheduler\Task;
use MinyonPlugin\entity\Minion;
use pocketmine\math\Vector3;
use pocketmine\block\BlockTypeIds;
use pocketmine\block\VanillaBlocks;
use pocketmine\network\mcpe\protocol\ActorEventPacket;

class MinionMineTask extends Task {

    public function __construct(private Minion $minion){}

    public function onRun(): void {

        $world = $this->minion->getWorld();
        $center = $this->minion->getPosition();

        for($x=-2;$x<=2;$x++){
            for($z=-2;$z<=2;$z++){

                $pos = $center->add($x, -1, $z);
                $block = $world->getBlock($pos);

                if($block->getTypeId() === BlockTypeIds::STONE){

                    // Animasyon
                    $pk = ActorEventPacket::create(
                        $this->minion->getId(),
                        ActorEventPacket::ARM_SWING,
                        0
                    );
                    foreach($world->getPlayers() as $p){
                        $p->getNetworkSession()->sendDataPacket($pk);
                    }

                    // Kır
                    $world->setBlock($pos, VanillaBlocks::AIR());
                    $this->minion->addItem("cobblestone");

                    // 1 sn sonra geri
                    $world->scheduleDelayedTask(function() use ($world, $pos){
                        $world->setBlock($pos, VanillaBlocks::COBBLESTONE());
                    }, 20);

                    return; // tick'te 1 blok
                }
            }
        }
    }
}
