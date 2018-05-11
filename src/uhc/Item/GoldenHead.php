<?php

namespace uhc\Item;


use pocketmine\entity\Effect;
use pocketmine\item\GoldenApple;
use pocketmine\utils\TextFormat;
use pocketmine\inventory\ShapedRecipe;

class GoldenHead extends GoldenApple
{
    /**
     * GoldenHead constructor.
     * @param int $meta
     */
    public function __construct($meta = 0)
    {
        parent::__construct($meta);
    }

    /**
     * @return array
     */
    public function getAdditionalEffects() : array
    {
        return [
            Effect::getEffect(Effect::REGENERATION)->setAmplifier(1)->setDuration(20 * ($this->getDamage() == 1 ? 10 : 5)),
            Effect::getEffect(Effect::ABSORPTION)->setDuration(20 * 120)

    }

    /**
     * @return string
     */
    public function getCustomName() : string
    {
        //Hope it will change the name Lol
        return $this->getDamage() == 1 ? TextFormat::RESET . TextFormat::GOLD . "GoldenHead" : TextFormat::RESET . TextFormat::YELLOW . "GoldenApple";
    }

    /**
     * @return bool
     */
    public function hasCustomName(): bool
    {
        return true;
    }

}
