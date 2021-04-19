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
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**

     * @Route("/home", name="admin.property.home")

     */
    public function home()
    {

        $admins = $this->adminRepository->findAll();

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
                        'error' => null,
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
