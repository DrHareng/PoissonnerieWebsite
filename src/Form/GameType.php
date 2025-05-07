<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\GameResult;
use App\Entity\Scenario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('_scenario', EntityType::class, [
                'class' => Scenario::class,
                'label' => 'Scénario joué',
            ])
            ->add('player1', PlayerGameType::class)
            ->add('player2', PlayerGameType::class)
            ->add('gameResult', GameResultType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
