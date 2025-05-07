<?php

namespace App\Form;

use App\Entity\Faction;
use App\Entity\GameResult;
use App\Entity\PlayerGame;
use App\Entity\PlayerGameResult;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;

class PlayerGameResultType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('objectivePoints', IntegerType::class, [
                'label' => 'Points d\'objectifs',
                'attr' => [
                    'min' => 0,
                    'max' => 10
                ],
                'constraints' => [
                    new Range(['min' => 0, 'max' => 10]),
                ],
            ])
            ->add('survivorPoints', IntegerType::class, [
                'label' => 'Points de survivants',
                'attr' => [
                    'min' => 0,
                    'max' => 300,
                ],
                'constraints' => [
                    new Range(['min' => 0, 'max' => 300]),
                ],
            ])
            // Hidden, will be filled in controller
            ->add('tournamentPoints', HiddenType::class, [
                'mapped' => true,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PlayerGameResult::class,
        ]);
    }
}
