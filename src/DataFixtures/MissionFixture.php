<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



use Faker\Factory;

use App\Entity\Admin;
use App\Entity\Contact;
use App\Entity\Target;
use App\Entity\Agent;
use App\Entity\Stash;
use App\Entity\Speciality;
use App\Entity\Mission;

class MissionFixture extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // Vars

        $countries = ["France", "Espagne", "Maroc", "Belgique"];

        // Faker

        $faker = Factory::create("fr_FR");

        // Admin

        $admin = new Admin();
        $admin
            ->setUsername("Admin")
            ->setRoles(array("ROLE_ADMIN"))
            ->setPassword($this->encoder->encodePassword($admin, "123"))
            ->setLastname("Azzougui")
            ->setFirstname("David")

            ->setEmail("admin@test.com")
            ->setRegistrationDate(new \DateTime());
        
        $manager->persist($admin);

        // Spécialites

        for($i = 0; $i < 10; $i++)
        {
            $specialities[$i] = new Speciality();
            $specialities[$i]
                ->setName($faker->words(3, true));

            $manager->persist($specialities[$i]);
        }

        // Contacts

        for($i = 0; $i < 10; $i++)
        {
            $contacts[$i] = new Contact();
            $contacts[$i]
                ->setUsername($faker->words(3, true))
                ->setRoles(array("ROLE_CONTACT"))
                ->setPassword($this->encoder->encodePassword($admin, "123"))
                ->setLastname($faker->words(3, true))
                ->setFirstname($faker->words(3, true))

                ->setBirthDate(new \DateTime())
                ->setNationality($faker->randomElement($countries))

                ->setCodeName($faker->words(3, true));

            $manager->persist($contacts[$i]);
        }

        // Targets

        for($i = 0; $i < 10; $i++)
        {
            $targets[$i] = new Target();
            $targets[$i]
                ->setUsername($faker->words(3, true))
                ->setRoles(array("ROLE_TARGET"))
                ->setPassword($this->encoder->encodePassword($admin, "123"))
                ->setLastname($faker->words(3, true))
                ->setFirstname($faker->words(3, true))

                ->setBirthDate(new \DateTime())
                ->setNationality($faker->randomElement($countries))

                ->setCodeName($faker->words(3, true));

            $manager->persist($targets[$i]);
        }

        // Agents

        for($i = 0; $i < 10; $i++)
        {
            $agents[$i] = new Agent();
            $agents[$i]
                ->setUsername($faker->words(3, true))
                ->setRoles(array("ROLE_AGENT"))
                ->setPassword($this->encoder->encodePassword($admin, "123"))
                ->setLastname($faker->words(3, true))
                ->setFirstname($faker->words(3, true))

                ->setBirthDate(new \DateTime())
                ->setNationality($faker->randomElement($countries))

                ->setCodeId($faker->words(3, true))
                
                ->addSpecialities($specialities[$i % 3]);

            $manager->persist($agents[$i]);
        }

        // Stashs

        for($i = 0; $i < 10; $i++)
        {
            $stashs[$i] = new Stash();
            $stashs[$i]
                ->setCode($faker->words(3, true))
                ->setAdress($faker->address)
                ->setCountry($faker->randomElement($countries))
                ->setType($faker->words(3, true));

            $manager->persist($stashs[$i]);
        }

        // Missions

        for($i = 0; $i < 100; $i++)
        {
            $missions[$i] = new Mission();
            $missions[$i]
                ->setTitle($faker->words(3, true))
                ->setDescription($faker->words(10, true))
                ->setCodeName($faker->words(3, true))
                ->setCountry($faker->country)
                ->setStartDate($faker->dateTimeBetween('-30 years', 'now', null))
                ->setEndDate($faker->dateTimeBetween('-30 years', 'now', null))
                ->setState($faker->randomElement($countries))
                ->setType($faker->randomElement(["En préparation", "En cours", "Terminé", "Echec"]))
                ->setIdSpeciality($specialities[$i % 3]);
            
            $manager->persist($missions[$i]);
        }

        $manager->flush();
    }

}
