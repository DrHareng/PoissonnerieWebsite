<?php

namespace App\Validator;

use App\Entity\Game;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class GameHasDifferentPlayersValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$value instanceof Game) {
            return;
        }

        // Check if player1 and player2 are the same
        $player1 = $value->getPlayer1();
        $player2 = $value->getPlayer2();

        if ($player1 && $player2 && $player1->getPlayer() === $player2->getPlayer()) {
            $this->context->buildViolation($constraint->message)
                ->atPath('player2._player') // or any path you want the error to show
                ->addViolation();
        }
    }
}
