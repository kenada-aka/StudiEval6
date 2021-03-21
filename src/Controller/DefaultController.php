<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;                         // Permet d'utiliser les routes sans "config/routes.yaml"
use App\Repository\UserRepository;                                      // Class UserRepository

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class DefaultController extends AbstractController

{

    /**

     * @Route("/home", name="default_home")

     */
    public function home(UserRepository $userRepository)

    {

        $user = new User();
        $user->setLastName("test");
        $user->setFirstName("kenada");

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();


        return $this->render('index.html.twig', [
                        'title' => 'Ma page de contact ',
                        'test' => $userRepository->findAll()
                    ]);

    }
    /**

     * @Route("/posts/{id}")

     */
    public function post(int $id)

    {

        return $this->render('index.html.twig', [

            'title' => 'Ma page de contact'. $id,

        ]);

    }

}