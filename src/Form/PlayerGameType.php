<?php

namespace App\Form;

use App\Entity\Faction;
use App\Entity\Game;
use App\Entity\PlayerGame;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlayerGameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('_player', EntityType::class, [
                'class' => User::class,
            ])
            ->add('_faction', EntityType::class, [
                'class' => Faction::class,
                    'choice_label' => 'label',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlayerGame::class,
        ]);
    }
}
