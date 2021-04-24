<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
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
use App\Repository\ContactRepository;

use App\Entity\Target;
use App\Form\TargetType;
use App\Repository\TargetRepository;

use App\Entity\Agent;
use App\Form\AgentType;
use App\Repository\AgentRepository;

use App\Entity\Mission;
use App\Form\MissionType;
use App\Repository\MissionRepository;

use App\Entity\Stash;
use App\Form\StashType;
use App\Repository\StashRepository;

use App\Entity\Speciality;
use App\Form\SpecialityType;
use App\Repository\SpecialityRepository;

class SecurityController extends AbstractController
{

    private $em;

    private $adminRepository;
    private $contactRepository;
    private $targetRepository;
    private $agentRepository;
    private $missionRepository;
    private $stashRepository;
    private $specialityRepository;

    public function __construct(EntityManagerInterface $em, 
                                AdminRepository $adminRepository,
                                ContactRepository $contactRepository,
                                TargetRepository $targetRepository,
                                AgentRepository $agentRepository,
                                MissionRepository $missionRepository,
                                StashRepository $stashRepository,
                                SpecialityRepository $specialityRepository)
    {
        $this->em = $em;
        $this->adminRepository = $adminRepository;
        $this->contactRepository = $contactRepository;
        $this->targetRepository = $targetRepository;
        $this->agentRepository = $agentRepository;
        $this->missionRepository = $missionRepository;
        $this->stashRepository = $stashRepository;
        $this->specialityRepository = $specialityRepository;
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
        return $this->redirectToRoute('home');
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
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('home/home.html.twig', [
            'title' => 'Accueil',
            'error' => $error
        ]);
    }


    /**
     * @Route("/admin/gestion/admin", name="admin.gestion.admin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function gestionAdmin()
    {
        return $this->gestion("Gestion Admin", "Admin", "admin");
    }

    /**
     * @Route("/admin/gestion/contact", name="admin.gestion.contact")
     * @IsGranted("ROLE_ADMIN")
     */
    public function gestionContact()
    {
        return $this->gestion("Gestion Contact", "Contact", "contact");
    }

    /**
     * @Route("/admin/gestion/target", name="admin.gestion.target")
     * @IsGranted("ROLE_ADMIN")
     */
    public function gestionTarget()
    {
        return $this->gestion("Gestion Target", "Target", "target");
    }
    /**
     * @Route("/admin/gestion/agent", name="admin.gestion.agent")
     * @IsGranted("ROLE_ADMIN")
     */
    public function gestionAgent()
    {
        return $this->gestion("Gestion Agent", "Agent", "agent", ["speciality" => "specialities"]);
    }

    /**
     * @Route("/admin/gestion/stash", name="admin.gestion.stash")
     * @IsGranted("ROLE_ADMIN")
     */
    public function gestionStash()
    {
        return $this->gestion("Gestion Stash", "Stash", "stash");
    }

    /**
     * @Route("/admin/gestion/speciality", name="admin.gestion.speciality")
     * @IsGranted("ROLE_ADMIN")
     */
    public function gestionSpeciality()
    {
        return $this->gestion("Gestion Speciality", "Speciality", "speciality", ["agent" => "agents"]);
    }

    /**
     * @Route("/admin/gestion/mission", name="admin.gestion.mission")
     * @IsGranted("ROLE_ADMIN")
     */
    public function gestionMission()
    {
        return $this->gestion("Gestion Mission", "Mission", "mission", ["agent" => "agents", "target" => "targets", "contact" => "contacts", "stash" => "stashs"]);
    }

    private function gestion(string $title, string $formName, string $page, array $datas = [])
    {
        $repositories = [
            "admin" => $this->adminRepository,
            "contact" => $this->contactRepository,
            "target" => $this->targetRepository,
            "agent" => $this->agentRepository,
            "stash" => $this->stashRepository,
            "speciality" => $this->specialityRepository,
            "mission" => $this->missionRepository
        ];
        $headers = [
            "admin" => ["ID", "Identifiant", "Mot de passe", "Roles", "Nom", "Prénom", "Email", "Date Inscription"],
            "contact" => ["ID", "Identifiant", "Mot de passe", "Roles", "Nom", "Prénom", "Date Naissance", "Nationalité", "Nom de code", "Mission (ManyToOne)"],
            "target" => ["ID", "Identifiant", "Mot de passe", "Roles", "Nom", "Prénom", "Date Naissance", "Nationalité", "Nom de code", "Mission (ManyToOne)"],
            "agent" => ["ID", "Identifiant", "Mot de passe", "Roles", "Nom", "Prénom", "Date Naissance", "Nationalité", "Code ID", "Spécialité(s) (ManyToMany)", "Mission (ManyToOne)"],
            "stash" => ["ID", "Code", "Adresse", "Pays", "Type", "Mission (OneToOne)"],
            "speciality" => ["ID", "Nom", "Agent (ManyToMany)", "Mission (ManyToOne)"],
            "mission" => ["ID", "Titre", "Description", "Nom de code", "Pays", "Date début", "Date fin", "Statut", "Type", "Spécialité (OneToOne)", "Agent(s) (OneToMany)", "Contact(s) (OneToMany)", "Cible(s) (OneToMany)", "Planque(s) (OneToOne)"]
        ];
        $properties = [
            "admin" => ["id", "username", "id", "roles", "lastName", "firstName", "email", "registrationDate"],
            "contact" => ["id", "username", "id", "roles", "lastName", "firstName", "birthDate", "nationality", "codeName", "idMission"],
            "target" => ["id", "username", "id", "roles", "lastName", "firstName", "birthDate", "nationality", "codeName", "idMission"],
            "agent" => ["id", "username", "id", "roles", "lastName", "firstName", "birthDate", "nationality", "codeId", "specialities", "idMission"],
            "stash" => ["id", "code", "adress", "country", "type", "idMission"],
            "speciality" => ["id", "name", "agents", "missions"],
            "mission" => ["id", "title", "description", "codeName", "country", "startDate", "endDate", "state", "type", "idSpeciality", "agents", "contacts", "targets", "idStash"]
        ];
        $array = [
            'title' => $title,
            'formName' => $formName,
            'datas' => $repositories[$page]->findAll(),
            'headers' => $headers[$page],
            'properties' => $properties[$page]
        ];
        foreach($datas as $k => $v)
        {
            $array[$v] = $repositories[$k]->findAll();
        }
        return $this->render('admin/home.html.twig', $array);
    }
    

    /**
     * @Route("/admin/add/{formName}", name="admin.add")
     * @IsGranted("ROLE_ADMIN")
     */
    public function add(string $formName, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->form($formName, $request, null, $passwordEncoder, "add");
        if($request->getMethod() == "POST")
        {
            return $this->redirectToRoute('admin.gestion.'. strtolower($formName));
        }
        return $this->render('admin/form.html.twig', [
            'title' => 'Ajouter un enregistrement à '. $formName,
            'type' => 'add',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/update/{formName}/{id}", name="admin.update")
     * @IsGranted("ROLE_ADMIN")
     */
    public function update(string $formName, int $id, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->form($formName, $request, $id, $passwordEncoder, "update");
        if($request->getMethod() == "POST")
        {
            return $this->redirectToRoute('admin.gestion.'. strtolower($formName));
        }
        return $this->render('admin/form.html.twig', [
            'title' => 'Modifier un enregistrement à '. $formName,
            'type' => 'update',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/remove/{formName}/{id}", name="admin.remove", methods="DELETE")
     * @IsGranted("ROLE_ADMIN")
     */
    public function remove(string $formName, int $id, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->form($formName, $request, $id, $passwordEncoder, "remove");
        return $this->redirectToRoute('admin.gestion.'. strtolower($formName));
    }

    private function form(string $formName, Request $request, ?int $id, UserPasswordEncoderInterface $passwordEncoder, string $mode)
    {
        switch($formName)
        {
            case "Admin":
                $entity = is_int($id) ? $this->adminRepository->find($id) : new Admin();
                $form = $this->createForm(AdminType::class, $entity);
                break;
            case "Contact":
                $entity = is_int($id) ? $this->contactRepository->find($id) : new Contact();
                $form = $this->createForm(ContactType::class, $entity);
                break;
            case "Target":
                $entity = is_int($id) ? $this->targetRepository->find($id) : new Target();
                $form = $this->createForm(TargetType::class, $entity);
                break;
            case "Agent":
                $entity = is_int($id) ? $this->agentRepository->find($id) : new Agent();
                $form = $this->createForm(AgentType::class, $entity);
                break;
            case "Mission":
                $entity = is_int($id) ? $this->missionRepository->find($id) : new Mission();
                $form = $this->createForm(MissionType::class, $entity);
                break;
            case "Stash":
                $entity = is_int($id) ? $this->stashRepository->find($id) : new Stash();
                $form = $this->createForm(StashType::class, $entity);
                break;
            case "Speciality":
                $entity = is_int($id) ? $this->specialityRepository->find($id) : new Speciality();
                $form = $this->createForm(SpecialityType::class, $entity);
                break;
        }

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() || $mode == "remove")
        {
            switch($formName .".". $mode)
            {
                case "Admin.add":
                    $password = $passwordEncoder->encodePassword($entity, $entity->getPassword());
                    $entity->setPassword($password);
                    $entity->setRoles(array("ROLE_ADMIN"));
                    $entity->setRegistrationDate(new \DateTime());
                    break;
                case "Admin.update":
                    $password = $passwordEncoder->encodePassword($entity, $entity->getPassword());
                    $entity->setPassword($password);
                    break;
                case "Contact.add":
                    $password = $passwordEncoder->encodePassword($entity, $entity->getPassword());
                    $entity->setPassword($password);
                    $entity->setRoles(array("ROLE_CONTACT"));
                    break;
                case "Contact.update":
                    $password = $passwordEncoder->encodePassword($entity, $entity->getPassword());
                    $entity->setPassword($password);
                    break;
                case "Target.add":
                    $password = $passwordEncoder->encodePassword($entity, $entity->getPassword());
                    $entity->setPassword($password);
                    $entity->setRoles(array("ROLE_TARGET"));
                    break;
                case "Target.update":
                    $password = $passwordEncoder->encodePassword($entity, $entity->getPassword());
                    $entity->setPassword($password);
                    break;
                case "Agent.add":
                    $password = $passwordEncoder->encodePassword($entity, $entity->getPassword());
                    $entity->setPassword($password);
                    $entity->setRoles(array("ROLE_AGENT"));
                    break;
                case "Agent.update":
                    $password = $passwordEncoder->encodePassword($entity, $entity->getPassword());
                    $entity->setPassword($password);
                    break;
                case "Mission.add":
                
                    break;
                case "Mission.update":
                    
                    break;
                case "Stash.add":
                
                    break;
                case "Stash.update":
                    
                    break;
                case "Speciality.add":
                
                    break;
                case "Speciality.update":
                    
                    break;
            }

            // Permet de vérifier la valider CSRF Token des 2 méthodes utilisées

            $csrfToken = $mode == "remove" ? 'delete'. $entity->getId() : strtolower($formName);
            $formToken = $mode == "remove" ? $request->get('_token') : $request->request->get(strtolower($formName))['_token'];

            if($this->isCsrfTokenValid($csrfToken, $formToken))
            {
                if($mode == "remove") $this->em->remove($entity);
                else $this->em->persist($entity);
                $this->em->flush();
            }
            //dump($this->container->get('security.csrf.token_manager'));die();
        }

        return $form;
    }


    /**
     * @Route("/admin/gestion/mission/addContact", name="admin.gestion.mission.addContact", methods="POST")
     * @IsGranted("ROLE_ADMIN")
     */
    public function addMissionToContact(Request $request)
    {
        return $this->addMissionToOne($request, "contact", "Ce contact est déjà affecté à une mission !");
    }

    /**
     * @Route("/admin/gestion/mission/addTarget", name="admin.gestion.mission.addTarget", methods="POST")
     * @IsGranted("ROLE_ADMIN")
     */
    public function addMissionToTarget(Request $request)
    {
        return $this->addMissionToOne($request, "target", "Cette cible est déjà affecté à une mission !");
    }

    /**
     * @Route("/admin/gestion/mission/addAgent", name="admin.gestion.mission.addAgent", methods="POST")
     * @IsGranted("ROLE_ADMIN")
     */
    public function addMissionToAgent(Request $request)
    {
        return $this->addMissionToOne($request, "agent", "Cette agent est déjà affecté à une mission !");
    }

    /**
     * @Route("/admin/gestion/mission/addStash", name="admin.gestion.mission.addStash", methods="POST")
     * @IsGranted("ROLE_ADMIN")
     */
    public function addMissionToStash(Request $request)
    {
        return $this->addMissionToOne($request, "stash", "Cette planque est déjà affecté à une mission !");
    }

    private function addMissionToOne(Request $request, string $many, string $errorMsg)
    {
        if($request->isXmlHttpRequest())
        {
            $mission = $this->missionRepository->find($request->request->get('idOne'));
            
            switch($many)
            {
                case "contact": $repository = $this->contactRepository; break;
                case "target": $repository = $this->targetRepository; break;
                case "agent": $repository = $this->agentRepository; break;
                case "stash": $repository = $this->stashRepository; break;
            }
            
            $entity = $repository->find($request->request->get('idMany'));

            if($entity->getIdMission())
            {
                if($entity->getIdMission()->getId())
                {
                    return new JsonResponse(['statut' => "ng", "error" => $errorMsg]);
                }
            }

            $entity->setIdMission($mission);
                
            $this->em->persist($entity);
            $this->em->flush();

            switch($many)
            {
                case "contact": $response = $entity->getCodeName(); break;
                case "target": $response = $entity->getCodeName(); break;
                case "agent": $response = $entity->getCodeId(); break;
                case "stash": $response = $entity->getCode(); break;
            }
            
            return new JsonResponse(['statut' => "ok", 'text' => $response]);
        }
    }


    /**
     * @Route("/admin/gestion/speciality/addToAgent", name="admin.gestion.speciality.addToAgent", methods="POST")
     * @IsGranted("ROLE_ADMIN")
     */
    public function addSpecialityToAgent(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $agent = $this->agentRepository->find($request->request->get('idOne'));
            $speciality = $this->specialityRepository->find($request->request->get('idMany'));
            $agent->addSpecialities($speciality);
            
            $this->em->persist($agent);
            $this->em->flush();

            $response = $speciality->getName();

            return new JsonResponse(['statut' => "ok", 'text' => $response]);
        }
    }

}
