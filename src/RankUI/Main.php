<?php

namespace RankUI;

use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat as TF;
use jojoe77777\FormAPI\CustomForm;

class Main extends PluginBase {

    public function onEnable() {
        $this->getLogger()->info("Plugin RankUI telah diaktifkan!");
        $this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        switch ($command->getName()) {
            case "rank":
                if ($sender instanceof Player) {
                    $this->openRankForm($sender);
                } else {
                    $sender->sendMessage(TF::RED . "Gunakan perintah ini di dalam game!");
                }
                return true;
            default:
                return false;
        }
    }

    public function openRankForm(Player $player) {
        $form = new CustomForm(function (Player $player, ?array $data) {
            if ($data === null) {
                return;
            }
            $this->showRankInfo($player, $data[0]);
        });
        $form->setTitle("Pilih Rank");
        $form->addDropdown("Pilih rank:", ["VIP", "VIP+", "MVP", "MVP+", "MVP++"]);
        $player->sendForm($form);
    }

    public function showRankInfo(Player $player, int $rankIndex) {
        $ranks = ["VIP", "VIP+", "MVP", "MVP+", "MVP++"];
        $rank = $ranks[$rankIndex];
        switch ($rank) {
            case "VIP":
                $message = "VIP: Manfaat VIP";
                break;
            case "VIP+":
                $message = "VIP+: Manfaat VIP+";
                break;
            case "MVP":
                $message = "MVP: Manfaat MVP";
                break;
            case "MVP+":
                $message = "MVP+: Manfaat MVP+";
                break;
            case "MVP++":
                $message = "MVP++: Manfaat MVP++";
                break;
            default:
                $message = "Rank tidak valid!";
        }
        $player->sendMessage($message);
    }
}
