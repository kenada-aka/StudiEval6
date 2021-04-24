<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MissionFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < 100; $i++)
        {
            $mission = new Mission();
            $mission
                ->setTitle()
                ->setDescription()
                ->setCountry()
                ->setStartDate()
                ->setEndDate()
                ->setState()
                ->setType()
                ->setIdSpeciality()
        }

/*
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
            //->add('idAgent', EntityType::class, ['class' => Agent::class, 'choice_label' => 'username'])
            ->add('idSpeciality', EntityType::class, ['class' => Speciality::class, 'choice_label' => 'name']) 
            */
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
