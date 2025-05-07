<?php

namespace App\Form;

use App\Entity\GameResult;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameResultType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('player1Result', PlayerGameResultType::class)
            ->add('player2Result', PlayerGameResultType::class)
            // Hidden fields
            ->add('date', HiddenType::class, [
                'mapped' => true,
            ])
            ->add('registeredBy', HiddenType::class, [
                'mapped' => true,
            ])
            ->add('status', HiddenType::class, [
                'mapped' => true,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GameResult::class,
        ]);
    }
}
