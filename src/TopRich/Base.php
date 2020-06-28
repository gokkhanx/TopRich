<?php

namespace TopRich;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use pocketmine\level\particle\FloatingTextParticle;
use pocketmine\math\Vector3;
use pocketmine\level\Level;
use pocketmine\level\Position;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\{Player, Server};
use onebone\economyapi\EconomyAPI;

class Base extends PluginBase implements Listener{



	  public static $default = ["Null" => 1];

	  public function onEnable(){
	  	$this->getLogger()->info("Aktif.");
	  	$this->economy = EconomyAPI::getInstance();
	  	$this->getServer()->getPluginManager()->registerEvents($this, $this);
	  }
		public function onJoin(PlayerJoinEvent $event){
			$x = 256;
			$y = 56;
			$z = 256;
			$particle = new FloatingTextParticle(new Vector3($x, $y, $z), $this->getTopTenList());
			$this->getServer()->getDefaultLevel()->addParticle($particle, [$event->getPlayer()]);
		}
	  public function getTopTenList(){
        $data = $this->economy->getAllMoney() ?? self::$default;
        arsort($data);
        $i = 1;
        $text = "";
        foreach(array_slice($data, 0, 10, false) as $key => $value){
            $text .= TextFormat::DARK_GRAY . "[" . TextFormat::AQUA . $i . TextFormat::DARK_GRAY . "] " . TextFormat::YELLOW . $key . TextFormat::DARK_RED . " => " . TextFormat::GOLD . $value . TextFormat::DARK_PURPLE . " Para" . TextFormat::EOL;
            $i++;
        }
				return $text;
    }

    public function getTitle(){
        return TextFormat::GRAY . "-==[ " . TextFormat::GREEN . "Sunucudaki en zengin 10 kişi" . TextFormat::GRAY . " ]==-";
    }
}
