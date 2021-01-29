<?php

namespace Referans\Event;

use Referans\Base;
use pocketmine\{
  Player,
  event\Listener,
  utils\Config,
  event\player\PlayerJoinEvent
};

use jojoe77777\FormAPI\{
  SimpleForm,
  CustomForm
};

use onebone\economyapi\EconomyAPI;

class EventListener implements Listener{

public function onJoin(PlayerJoinEvent $e){
if(!file_exists(Base::getInstance()->getDataFolder()."ReferansOyuncular/".$e->getPlayer()->getName().".yml")){
     $rand = rand(1, 2203);
     $kod = $rand . "aUfzSkE" . $rand;
     $cfg = new Config(Base::getInstance()->getDataFolder()."Referans/".$kod.".yml", Config::YAML);
     $cfgg = new Config(Base::getInstance()->getDataFolder()."ReferansOyuncular/".$e->getPlayer()->getName().".yml", Config::YAML);
    $o = $e->getPlayer();
     $cfg->set("Referans Kodu", $kod);
     $cfg->set("Nick", $o->getName());
     $cfg->save();
     $cfgg->set("Referans Kodu", $kod);
     $cfgg->set("Nick", $o->getName());
     $cfgg->save(); 
     $this->yeniReferans($o);
     }else{
 $o = $e->getPlayer();
       $this->yeniReferans($o);
     }
   } 
    public function yeniReferans(Player $o){
       $f = new CustomForm(function(Player $o, $args){
         if($args === null){
           return true;
         }
         if(file_exists(Base::getInstance()->getDataFolder()."Referans/".$args[1].".yml")){
           $cfg = new Config(Base::getInstance()->getDataFolder()."ReferansOyuncular/".$o->getName().".yml", Config::YAML);
     $cfggg = new Config(Base::getInstance()->getDataFolder()."Referans/".$args[1].".yml", Config::YAML);
           if(!$cfg->get($o->getName())){
              if(!$args[1] == ""){
              if($o->getName() == $cfggg->get("Nick")){
             $o->sendMessage("§a$args[1] Kodunu Başarıyla Kullandın Hesabına 10.000TL Aktarıldı!");
             EconomyAPI::getInstance()->addMoney($o, 10000);
             EconomyAPI::getInstance()->addMoney($cfggg->get("Nick"), 10000);
             $cfgg = new Config(Base::getInstance()->getDataFolder()."ReferansOyuncular/".$o->getName().".yml", Config::YAML);
                $cfgg->set($args[1]);
                $cfgg->save();
             }else{
             $o->sendMessage("§cKendi Referans Kodunu Kullanamazsın!");
             }
            }else{
             $o->sendMessage("§cBoşluk Bir Referans Kodu Değil!");
            }
           }else{
           $o->sendMessage("§cBu Referans Kodunu Önceden Kullanmışsın!");
          }
         }else{
        $o->sendMessage("§c$args[1] diye bir referans kodu bulunamadı");
       } 
       });
       $veri = new Config(Base::getInstance()->getDataFolder()."ReferansOyuncular/".$o->getName().".yml", Config::YAML);
       $cveri = $veri->get("Referans Kodu");
       $f->setTitle("Referans");
       $f->addLabel("§7Merhaba Referans Menüsüne Hoşgeldin! §6$cveri §7Kodunu arkadaşına göndererirsen ve arkadaşın kodu girerse hem sen para kazanırsın hemde arkadaşın! arkadaşının kodu var ve sana yollamış ise aşşağıdan kodu girip ödülü kazanabilirsin!");
       $f->addInput("Kodu Gir Kazan", "Örn; zEqafIr3");
       $f->sendToPlayer($o);
     }
  
   
}
