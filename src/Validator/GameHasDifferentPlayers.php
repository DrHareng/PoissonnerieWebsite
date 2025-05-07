<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_CLASS)]
final class GameHasDifferentPlayers extends Constraint
{
    public string $message = 'Les deux adversaires ne peuvent être le même joueur.';
    
    public function getTargets(): string|array
    {
        return self::CLASS_CONSTRAINT;
    }
}
