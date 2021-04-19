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

use App\Entity\Contact;
use App\Form\ContactType;

use App\Entity\Target;
use App\Form\TargetType;

use App\Entity\Agent;
use App\Form\AgentType;

use App\Entity\Mission;
use App\Form\MissionType;

use App\Entity\Stash;
use App\Form\StashType;

use App\Entity\Speciality;
use App\Form\SpecialityType;

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
     * @Route("/admin/add/{formName}", name="admin.add")
     * @IsGranted("ROLE_ADMIN")
     */
    public function add(string $formName, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        switch($formName)
        {
            case "Admin":
                $entity = new Admin();
                $form = $this->createForm(AdminType::class, $entity);
                break;
            case "Contact":
                $entity = new Contact();
                $form = $this->createForm(ContactType::class, $entity);
                break;
            case "Target":
                $entity = new Target();
                $form = $this->createForm(TargetType::class, $entity);
                break;
            case "Agent":
                $entity = new Agent();
                $form = $this->createForm(AgentType::class, $entity);
                break;
            case "Mission":
                $entity = new Mission();
                $form = $this->createForm(MissionType::class, $entity);
                break;
            case "Stash":
                $entity = new Stash();
                $form = $this->createForm(StashType::class, $entity);
                break;
            case "Speciality":
                $entity = new Speciality();
                $form = $this->createForm(SpecialityType::class, $entity);
                break;
        }
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            // Règles métiers

            switch($formName)
            {
                case "Admin":
                    $password = $passwordEncoder->encodePassword($entity, $entity->getPassword());
                    $entity->setPassword($password);
                    $entity->setRegistrationDate(new \DateTime());
                    break;
                case "Contact":
                    
                    break;
                case "Target":
                    
                    break;
                case "Agent":
                    
                    break;
                case "Mission":
                    
                    break;
                case "Stash":
                    
                    break;
                case "Speciality":
                    
                    break;
            }
            /*
            $this->em->persist($user);
            $this->em->flush();
            */
            return $this->redirectToRoute('admin.gestion.'. strtolower($formName));
        }

        return $this->render('admin/form.html.twig', [
            'title' => 'Ajouter un enregistrement à '. $formName,
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
            'title' => 'Gestion Admin',
            'formName' => 'Admin'
        ]);
    }

    /**
     * @Route("/admin/gestion/contact", name="admin.gestion.contact")
     * @IsGranted("ROLE_ADMIN")
     */
    public function gestionContact()
    {
        return $this->render('admin/home.html.twig', [
            'title' => 'Gestion Contact',
            'formName' => 'Contact'
        ]);
    }

    /**
     * @Route("/admin/gestion/target", name="admin.gestion.target")
     * @IsGranted("ROLE_ADMIN")
     */
    public function gestionTarget()
    {
        return $this->render('admin/home.html.twig', [
            'title' => 'Gestion Target',
            'formName' => 'Target'
        ]);
    }

    /**
     * @Route("/admin/gestion/agent", name="admin.gestion.agent")
     * @IsGranted("ROLE_ADMIN")
     */
    public function gestionAgent()
    {
        return $this->render('admin/home.html.twig', [
            'title' => 'Gestion Agent',
            'formName' => 'Agent'
        ]);
    }

    /**
     * @Route("/admin/gestion/mission", name="admin.gestion.mission")
     * @IsGranted("ROLE_ADMIN")
     */
    public function gestionMission()
    {
        return $this->render('admin/home.html.twig', [
            'title' => 'Gestion Mission',
            'formName' => 'Mission'
        ]);
    }

    /**
     * @Route("/admin/gestion/stash", name="admin.gestion.stash")
     * @IsGranted("ROLE_ADMIN")
     */
    public function gestionStash()
    {
        return $this->render('admin/home.html.twig', [
            'title' => 'Gestion Stash',
            'formName' => 'Stash'
        ]);
    }

    /**
     * @Route("/admin/gestion/speciality", name="admin.gestion.speciality")
     * @IsGranted("ROLE_ADMIN")
     */
    public function gestionSpeciality()
    {
        return $this->render('admin/home.html.twig', [
            'title' => 'Gestion Speciality',
            'formName' => 'Speciality'
        ]);
    }

}
