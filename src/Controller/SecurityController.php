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
        

        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('home/home.html.twig', [
            'title' => 'Accueil',
            'error' => $error
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
        //dump($request);die();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            // Règles métiers

            switch($formName)
            {
                case "Admin":
                    $password = $passwordEncoder->encodePassword($entity, $entity->getPassword());
                    $entity->setPassword($password);
                    $entity->setRoles(array("ROLE_ADMIN"));
                    $entity->setRegistrationDate(new \DateTime());
                    break;
                case "Contact":
                    $password = $passwordEncoder->encodePassword($entity, $entity->getPassword());
                    $entity->setPassword($password);
                    $entity->setRoles(array("ROLE_CONTACT"));
                    break;
                case "Target":
                    $password = $passwordEncoder->encodePassword($entity, $entity->getPassword());
                    $entity->setPassword($password);
                    $entity->setRoles(array("ROLE_TARGET"));
                    break;
                case "Agent":
                    $password = $passwordEncoder->encodePassword($entity, $entity->getPassword());
                    $entity->setPassword($password);
                    $entity->setRoles(array("ROLE_AGENT"));
                    break;
                case "Mission":
                    //$entity->setIdMision($password);
                    break;
                case "Stash":
                    
                    break;
                case "Speciality":
                    
                    break;
            }
            // id de mission est null ici
            $this->em->persist($entity);
            //dump($entity);die();
            $this->em->flush();
            
            return $this->redirectToRoute('admin.gestion.'. strtolower($formName));
        }

        return $this->render('admin/form.html.twig', [
            'title' => 'Ajouter un enregistrement à '. $formName,
            'type' => 'add',
            'form' => $form->createView()
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
     * @Route("/admin/update/{formName}/{id}", name="admin.update")
     * @IsGranted("ROLE_ADMIN")
     */
    public function update(string $formName, int $id, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        switch($formName)
        {
            case "Admin":
                $entity = $this->adminRepository->find($id);
                $form = $this->createForm(AdminType::class, $entity);
                break;
            case "Contact":
                $entity = $this->contactRepository->find($id);
                $form = $this->createForm(ContactType::class, $entity);
                break;
            case "Target":
                $entity = $this->targetRepository->find($id);
                $form = $this->createForm(TargetType::class, $entity);
                break;
            case "Agent":
                $entity = $this->agentRepository->find($id);
                $form = $this->createForm(AgentType::class, $entity);
                break;
            case "Mission":
                $entity = $this->missionRepository->find($id);
                $form = $this->createForm(MissionType::class, $entity);
                break;
            case "Stash":
                $entity = $this->stashRepository->find($id);
                $form = $this->createForm(StashType::class, $entity);
                break;
            case "Speciality":
                $entity = $this->specialityRepository->find($id);
                $form = $this->createForm(SpecialityType::class, $entity);
                break;
        }
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {

            switch($formName)
            {
                case "Admin":
                    $password = $passwordEncoder->encodePassword($entity, $entity->getPassword());
                    $entity->setPassword($password);
                    break;
                case "Contact":
                    $password = $passwordEncoder->encodePassword($entity, $entity->getPassword());
                    $entity->setPassword($password);
                    break;
                case "Target":
                    $password = $passwordEncoder->encodePassword($entity, $entity->getPassword());
                    $entity->setPassword($password);
                    break;
                case "Agent":
                    $password = $passwordEncoder->encodePassword($entity, $entity->getPassword());
                    $entity->setPassword($password);
                    break;
                case "Mission":
                    
                    break;
                case "Stash":
                    
                    break;
                case "Speciality":
                    
                    break;
            }
            
            $this->em->persist($entity);
            $this->em->flush();
            
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
    public function remove(string $formName, int $id, Request $request)
    {
        switch($formName)
        {
            case "Admin":
                $entity = $this->adminRepository->find($id);
                $form = $this->createForm(AdminType::class, $entity);
                break;
            case "Contact":
                $entity = $this->contactRepository->find($id);
                $form = $this->createForm(ContactType::class, $entity);
                break;
            case "Target":
                $entity = $this->targetRepository->find($id);
                $form = $this->createForm(TargetType::class, $entity);
                break;
            case "Agent":
                $entity = $this->agentRepository->find($id);
                $form = $this->createForm(AgentType::class, $entity);
                break;
            case "Mission":
                $entity = $this->missionRepository->find($id);
                $form = $this->createForm(MissionType::class, $entity);
                break;
            case "Stash":
                $entity = $this->stashRepository->find($id);
                $form = $this->createForm(StashType::class, $entity);
                break;
            case "Speciality":
                $entity = $this->specialityRepository->find($id);
                $form = $this->createForm(SpecialityType::class, $entity);
                break;
        }

        if($this->isCsrfTokenValid('delete'. $entity->getId(), $request->get('_token')))
        {
            $this->em->remove($entity);
            $this->em->flush();
        }
        
        return $this->redirectToRoute('admin.gestion.'. strtolower($formName));
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

    /**
     * @Route("/admin/gestion/mission/addContact", name="admin.gestion.mission.addContact", methods="POST")
     * @IsGranted("ROLE_ADMIN")
     */
    public function addMissionToContact(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $mission = $this->missionRepository->find($request->request->get('idOne'));
            $contact = $this->contactRepository->find($request->request->get('idMany'));

            // 1 Contact peut être affecté qu'à 1 Mission

            if($contact->getIdMission())
            {
                if($contact->getIdMission()->getId() == $request->request->get('idOne'))
                {
                    return new JsonResponse(['statut' => "ng", "error" => "Ce contact est déjà affecté à une mission !"]);
                }
            }

            $contact->setIdMission($mission);
                
            $this->em->persist($contact);
            $this->em->flush();

            $response = $contact->getCodeName();

            return new JsonResponse(['statut' => "ok", 'text' => $response]);
        }
    }

    /**
     * @Route("/admin/gestion/mission/addTarget", name="admin.gestion.mission.addTarget", methods="POST")
     * @IsGranted("ROLE_ADMIN")
     */
    public function addMissionToTarget(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $mission = $this->missionRepository->find($request->request->get('idOne'));
            $target = $this->targetRepository->find($request->request->get('idMany'));

            // 1 Target peut être affecté qu'à 1 Mission

            if($target->getIdMission())
            {
                if($target->getIdMission()->getId() == $request->request->get('idOne'))
                {
                    return new JsonResponse(['statut' => "ng", "error" => "Cette cible est déjà affecté à une mission !"]);
                }
            }

            $target->setIdMission($mission);
                
            $this->em->persist($target);
            $this->em->flush();

            $response = $target->getCodeName();

            return new JsonResponse(['statut' => "ok", 'text' => $response]);
        }
    }

    /**
     * @Route("/admin/gestion/mission/addAgent", name="admin.gestion.mission.addAgent", methods="POST")
     * @IsGranted("ROLE_ADMIN")
     */
    public function addMissionToAgent(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $mission = $this->missionRepository->find($request->request->get('idOne'));
            $agent = $this->agentRepository->find($request->request->get('idMany'));

            // 1 Agent peut être affecté qu'à 1 Mission

            if($agent->getIdMission())
            {
                if($agent->getIdMission()->getId() == $request->request->get('idOne'))
                {
                    return new JsonResponse(['statut' => "ng", "error" => "Cette agent est déjà affecté à une mission !"]);
                }
            }

            $agent->setIdMission($mission);
                
            $this->em->persist($agent);
            $this->em->flush();

            $response = $agent->getCodeId();

            return new JsonResponse(['statut' => "ok", 'text' => $response]);
        }
    }

    /**
     * @Route("/admin/gestion/mission/addStash", name="admin.gestion.mission.addStash", methods="POST")
     * @IsGranted("ROLE_ADMIN")
     */
    public function addMissionToStash(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $mission = $this->missionRepository->find($request->request->get('idOne'));
            $stash = $this->stashRepository->find($request->request->get('idMany'));

            // 1 Stash peut être affecté qu'à 1 Mission

            if($stash->getIdMission())
            {
                if($stash->getIdMission()->getId())
                {
                    return new JsonResponse(['statut' => "ng", "error" => "Cette planque est déjà affecté à une mission !"]);
                }
            }

            $stash->setIdMission($mission);
                
            $this->em->persist($stash);
            $this->em->flush();

            $response = $stash->getCode();

            return new JsonResponse(['statut' => "ok", 'text' => $response]);
        }
    }

}
