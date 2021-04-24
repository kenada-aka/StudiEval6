<?php

namespace App\Form;

use App\Entity\Mission;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

use App\Entity\Speciality;
use App\Entity\Agent;

class MissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('codeName', TextType::class)
            ->add('country', ChoiceType::class, [
                'choices'  => [  
                    "France" => "France",
                    "Espagne" => "Espagne",
                    "Maroc" => "Maroc",
                    "Belgique" => "Belgique"
                ]])
            ->add('startDate', DateType::class, [
                'widget' => 'single_text',
            
                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => true,
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('state', ChoiceType::class, [
                'choices'  => [  
                    "En préparation" => "En préparation",
                    "En cours" => "En cours",
                    "Terminé" => "Terminé",
                    "Echec" => "Echec"
                ]])
            ->add('type', ChoiceType::class, [
                'choices'  => [  
                    "Surveillance" => "Surveillance",
                    "Infiltration" => "Infiltration"
                ]])
            ->add('idSpeciality', EntityType::class, ['class' => Speciality::class, 'choice_label' => 'name']) 
            //->add('agents', EntityType::class, ['class' => Agent::class, 'choice_label' => 'username'])
            /*
            ->add('agents', CollectionType::class, array(
                'entry_type'   => EntityType::class,
                'entry_options'  => array(
                    'class'      => Agent::class,
                    'choice_label' => 'username'
                )
            ))
            */
/*
            ->add('agents', CollectionType::class, [
                'entry_type' => AgentType::class,
                'allow_add' => true,
            'allow_delete' => true,
            'prototype' => true,
            'by_reference' => false,*/
                /*
                'class' => Agent::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.username', 'ASC');
                },
                'choice_label' => 'username',
            */
            //])
            //->add('idSpeciality')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
        ]);
    }
}
