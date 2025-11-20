<?php

namespace MinyonPlugin;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\world\World;
use pocketmine\entity\EntityDataHelper;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\entity\EntityFactory;
use MinyonPlugin\entity\Minion;

class Main extends PluginBase {

    public function onEnable(): void {

        EntityFactory::getInstance()->register(
            Minion::class,
            function(World $world, CompoundTag $nbt) : Minion{
                return new Minion(EntityDataHelper::parseLocation($nbt, $world), $nbt);
            },
            ['Minion']
        );

        $this->getLogger()->info("MinyonPlugin aktif!");
    }


    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {

        if(!$sender instanceof Player) return false;

        if($command->getName() === "minyon"){

            $loc = $sender->getLocation();
            $nbt = Minion::createBaseNBT($loc);

            $minion = new Minion($loc, $nbt);
            $minion->spawnToAll();

            $sender->sendMessage("§aMinyon oluşturuldu!");
            return true;
        }

        return false;
    }
}
