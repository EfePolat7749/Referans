<?php

namespace Referans;

use pocketmine\{
  plugin\PluginBase,
  command\CommandSender,
  command\Command,
  event\Listener,
  utils\Config
};
use Referans\{
  Commands\Referans,
  Event\EventListener
};
class Base extends PluginBase implements Listener{
  
     private static $instance;

    public function onLoad(){
        self::$instance = $this;
    }

    public static function getInstance(): Base{
        return self::$instance;
    }

   public function onEnable(){
  @mkdir($this->getDataFolder()."Referans/");
 @mkdir($this->getDataFolder()."ReferansOyuncular/");
 $this->getServer()->getCommandMap()->register("referans", new Referans($this));
 $this->getServer()->getPluginManager()->registerEvents(new EventListener(),$this);
   }
            
}
