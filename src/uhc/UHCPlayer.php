<?php

namespace uhc;


use pocketmine\network\SourceInterface;
use pocketmine\Player;
use pocketmine\tile\Tile;
use pocketmine\utils\Config;

class UHCPlayer extends Player
{
    const PLAYER_FOLDER = "players";

    private $config;

    /**
     * UHCPlayer constructor.
     * @param SourceInterface $interface
     * @param null $clientID
     * @param string $ip
     * @param int $port
     */
    public function __construct(SourceInterface $interface, $clientID, $ip, $port)
    {
        parent::__construct($interface, $clientID, $ip, $port);
    }

    public function initConfig(){
        if(!is_dir($this->getPlugin()->getDataFolder() . self::PLAYER_FOLDER)) @mkdir($this->getPlugin()->getDataFolder() . self::PLAYER_FOLDER);
        $this->setConfig(new Config($this->getPlugin()->getDataFolder() . self::PLAYER_FOLDER . DIRECTORY_SEPARATOR . $this->getLowerCaseName() . ".yml", Config::JSON, [
            "stats" => [
                "wins" => 0,
                "deaths" => 0,
                "kills" => 0
            ],
            "lang" => UHC::getLangmanager()->getDefault()
        ]));
    }

    public function getTilesAround()
    {
        $this->getLevel()->getTileById(Tile::CHEST);
    }

    /**
     * @return string
     */
    public function getLang() : string
    {
        return $this->getConfig()->get("lang");
    }

    /**
     * @param string $lang
     */
    public function setLang(string $lang)
    {
        $this->getConfig()->set("lang", $lang);
        $this->getConfig()->save(true);
    }

    /**
     * @return UHC
     */
    public function getPlugin() : UHC
    {
        return UHC::getInstance();
    }

    /**
     * @return bool
     */
    public function isPlaying() : bool
    {
        return UHC::getInstance()::getUHCManager()->isPlaying($this);
    }

    /**
     * @param string $message
     */
    public function sendTranslatedMessage(string $message)
    {
        $this->sendMessage(str_replace("{winner}", UHC::getUHCManager()->getLastWinner(), str_replace("{dead}", UHC::getUHCManager()->getLastDeath(), str_replace("{prefix}", Utils::getPrefix(), LangManager::translate($message, $this->getLang())))));
    }

    /**
     * @return Config
     */
    public function getConfig() : Config
    {
        return $this->config;
    }

    /**
     * @param Config $config
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;
    }

}