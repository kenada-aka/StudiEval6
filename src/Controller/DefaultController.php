<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;                         // Permet d'utiliser les routes sans "config/routes.yaml

use Doctrine\ORM\EntityManagerInterface;

use Knp\Component\Pager\PaginatorInterface;


use App\Entity\Mission;
use App\Form\MissionType;
use App\Repository\MissionRepository;


class DefaultController extends AbstractController

{

    private $em;

    private $missionRepository;

    private $paginator;

    public function __construct(EntityManagerInterface $em,
                                MissionRepository $missionRepository,
                                PaginatorInterface $paginator)
    {
        $this->em = $em;
        $this->missionRepository = $missionRepository;;
        $this->paginator = $paginator;
    }

    /**

     * @Route("/", name="home")

     */
    public function home(Request $request)
    {
        $repository = $this->missionRepository;
        $headers = [
            "id" => "ID", 
            "username" => "Identifiant", 
            "password" => "Mot de passe", 
            "roles" => "Roles", 
            "lastname" => "Nom", 
            "firstname" => "Prénom", 
            "email" => "Email", 
            "registrationDate" => "Date Inscription",
            "birthDate" => "Date Naissance",
            "nationality" => "Nationalité",
            "codeName" => "Nom de code",
            "codeId" => "Code ID",
            "code" => "Code",
            "adress" => "Adresse",
            "country" => "Pays",
            "type" => "Type",
            "name" => "Nom",
            "title" => "Titre",
            "description" => "Description",
            "startDate" => "Date début",
            "endDate" => "Date fin",
            "state" => "Statut",
            "agents" => "Agent(s)",
            "missions" => "Mission(s)",
            "contacts" => "Contact(s)",
            "targets" => "Cible(s)",
            "specialities" => "Spécialité(s)",
            "idSpeciality" => "Spécialité",
            "idMission" => "Mission",
            "idStash" => "Planque"
        ];
        $sortables = ["title", "country", "startDate", "endDate"];
        $filters = ["codeName", "country", "state", "type"];
        $properties = ["title", "description", "codeName", "country", "startDate", "endDate", "state", "type", "idSpeciality"];
        $pagination = $this->paginator->paginate(
            $repository->findAllWhereFinishQuery(),
            $request->query->getInt('page', 1), // page number
            3 // limit per page
        );
        $pagination->setTemplate('@KnpPaginator/Pagination/twitter_bootstrap_v4_pagination.html.twig');
        $pagination->setSortableTemplate('@KnpPaginator/Pagination/twitter_bootstrap_v4_font_awesome_sortable_link.html.twig');
        $pagination->setFiltrationTemplate('@KnpPaginator/Pagination/twitter_bootstrap_v4_filtration.html.twig');
        $array = [
            'title' => "Agence de surveillance : Secret Agency X",
            'datas' => $pagination,
            'headers' => $headers,
            'sortables' => $sortables,
            'filters' => $filters,
            'properties' => $properties
        ];
        return $this->render('home/home.html.twig', $array);
    }

    /**

     * @Route("/mission/{idMission}", name="mission.specs")

     */
    public function missionSpecs(int $idMission)
    {
        $mission = $this->missionRepository->find($idMission);
        $array = [
            'title' => "Mission spécifications : ". $mission->getTitle(),
            'mission' => $mission,
        ];
        return $this->render('home/specs.html.twig', $array);
    }

}