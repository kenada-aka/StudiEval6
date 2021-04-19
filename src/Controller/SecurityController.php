<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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
     * @IsGranted("ROLE_ADMIN")
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

    /**
     * @Route("/admin/gestion/admin", name="admin.gestion.admin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function gestionAdmin()
    {
        return $this->render('admin/home.html.twig', [
            'title' => 'Gestion Admin'
        ]);
    }

    /**
     * @Route("/admin/gestion/contact", name="admin.gestion.contact")
     * @IsGranted("ROLE_ADMIN")
     */
    public function gestionContact()
    {
        return $this->render('admin/home.html.twig', [
            'title' => 'Gestion Contact'
        ]);
    }

    /**
     * @Route("/admin/gestion/target", name="admin.gestion.target")
     * @IsGranted("ROLE_ADMIN")
     */
    public function gestionTarget()
    {
        return $this->render('admin/home.html.twig', [
            'title' => 'Gestion Target'
        ]);
    }

    /**
     * @Route("/admin/gestion/agent", name="admin.gestion.agent")
     * @IsGranted("ROLE_ADMIN")
     */
    public function gestionAgent()
    {
        return $this->render('admin/home.html.twig', [
            'title' => 'Gestion Agent'
        ]);
    }

    /**
     * @Route("/admin/gestion/mission", name="admin.gestion.mission")
     * @IsGranted("ROLE_ADMIN")
     */
    public function gestionMission()
    {
        return $this->render('admin/home.html.twig', [
            'title' => 'Gestion Mission'
        ]);
    }

    /**
     * @Route("/admin/gestion/stash", name="admin.gestion.stash")
     * @IsGranted("ROLE_ADMIN")
     */
    public function gestionStash()
    {
        return $this->render('admin/home.html.twig', [
            'title' => 'Gestion Stash'
        ]);
    }

    /**
     * @Route("/admin/gestion/speciality", name="admin.gestion.speciality")
     * @IsGranted("ROLE_ADMIN")
     */
    public function gestionSpeciality()
    {
        return $this->render('admin/home.html.twig', [
            'title' => 'Gestion Speciality'
        ]);
    }

}
