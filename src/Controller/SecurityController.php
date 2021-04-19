<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Admin;
use App\Form\AdminType;
use App\Repository\AdminRepository;

class SecurityController extends AbstractController
{

    private $em;

    private $adminRepository;

    public function __construct(EntityManagerInterface $em, AdminRepository $adminRepository)
    {
        $this->em = $em;
        $this->adminRepository = $adminRepository;
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(): Response
    {
        if($this->getUser())
        {
            return $this->redirectToRoute('admin.home');
        }
        return $this->redirectToRoute('admin.home');
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        return $this->redirectToRoute('home');
    }

    /**

     * @Route("/home", name="admin.home")

     */
    public function home(AuthenticationUtils $authenticationUtils)
    {

        $admins = $this->adminRepository->findAll();

        $error = $authenticationUtils->getLastAuthenticationError();
/*
        $user = new User();
        $user->setLastName("test");
        $user->setFirstName("kenada");

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
*/
        


        return $this->render('home/home.html.twig', [
                        'title' => 'Accueil',
                       'error' => $error,
                        //'test' => $userRepository->findAll()
                        'admins' => $admins
                        
                    ]);

    }

    /**
     * @Route("/addAdmin", name="addAdmin")
     */

    public function addUser(Request $request, UserPasswordEncoderInterface $passwordEncoder)

    {
        $user = new Admin();

        $form = $this->createForm(AdminType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            // Encode the password

            $password = $passwordEncoder->encodePassword($user, $user->getPassword());

            $user->setPassword($password);
            $user->setRegistrationDate(new \DateTime());

            $this->em->persist($user);
            $this->em->flush();
            return $this->redirectToRoute('admin.property.home');
        }

        return $this->render('old/form.html.twig', [

            'title' => 'Formulaire',
            'form' => $form->createView()

        ]);

    }
}
