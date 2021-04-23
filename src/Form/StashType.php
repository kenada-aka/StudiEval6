<?php

namespace App\Form;

use App\Entity\Stash;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;

class StashType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', TextType::class)
            ->add('adress', TextType::class)
            ->add('country', ChoiceType::class, [
                'choices'  => [  
                    "France" => "France",
                    "Espagne" => "Espagne",
                    "Maroc" => "Maroc",
                    "Belgique" => "Belgique"
                ]])
            ->add('type', TextType::class)
            //->add('idMission')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stash::class,
        ]);
    }
}
