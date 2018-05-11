<?php

namespace uhc\listener;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\event\player\PlayerJoinEvent;
use uhc\UHC;
use pocketmine\event\Listener;
use uhc\UHCPlayer;

class PlayerListener implements Listener
{
    private $plugin;

    /**
     * PlayerListener constructor.
     * @param UHC $plugin
     */
    public function __construct(UHC $plugin)
    {
        $this->setPlugin($plugin);
        $plugin->getServer()->getPluginManager()->registerEvents($this, $plugin);
    }

    /**
     * @param PlayerJoinEvent $event
     */
    public function onJoin(PlayerJoinEvent $event)
    {
        $player = $event->getPlayer();
        if($player instanceof UHCPlayer){
            $player->initConfig();
        }
    }

    /**
     * @param PlayerCreationEvent $event
     */
    public function onCreation(PlayerCreationEvent $event)
    {
        $event->setPlayerClass(UHCPlayer::class);
    }

    /**
     * @param BlockBreakEvent $event
     */
    public function onBreak(BlockBreakEvent $event)
    {
        $player = $event->getPlayer();
        if($player instanceof UHCPlayer){
            if($player->getLevel()->getName() === $this->getPlugin()->getServer()->getDefaultLevel()->getName()){
                if (!$player->isOp() or !$player->hasPermission("lobby.break")){
                    $event->setCancelled(true);
                }
            }
        }
    }

    /**
     * @param BlockPlaceEvent $event
     */
    public function onPlace(BlockPlaceEvent $event)
    {
        $player = $event->getPlayer();
        if($player instanceof UHCPlayer){
            if($player->getLevel()->getName() === $this->getPlugin()->getServer()->getDefaultLevel()->getName()){
                if (!$player->isOp() or !$player->hasPermission("lobby.place")){
                    $event->setCancelled(true);
                }
            }
        }
    }

    /**
     * @param EntityDamageEvent $event
     */
    public function onDamage(EntityDamageEvent $event)
    {
        $player = $event->getEntity();
        if ($player instanceof UHCPlayer){
            if ($player->getLevel()->getName() === $this->getPlugin()->getServer()->getDefaultLevel()->getName()){
                $event->setCancelled(true);
            }
        }
    }

    /**
     * @return UHC
     */
    public function getPlugin(): UHC
    {
        return $this->plugin;
    }

    /**
     * @param UHC $plugin
     */
    public function setPlugin(UHC $plugin)
    {
        $this->plugin = $plugin;
    }
}
