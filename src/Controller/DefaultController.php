<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;                         // Permet d'utiliser les routes sans "config/routes.yaml"
use App\Repository\UserRepository;                                      // Class UserRepository

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
//use Doctrine\Common\Persistence\ObjectManager;

class DefaultController extends AbstractController

{

    private $repository; 
    private $em;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $em) {
        $this->repository = $userRepository;
        $this->em = $em;
    }

    /**

     * @Route("/home", name="admin.property.home")

     */
    public function home(UserRepository $userRepository)

    {
/*
        $user = new User();
        $user->setLastName("test");
        $user->setFirstName("kenada");

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
*/
        
        

        return $this->render('index.html.twig', [
                        'title' => 'Ma page de contact ',
                        'test' => $userRepository->findAll()
                        
                    ]);

    }

    /**
     * @Route("/posts/{id}", name="admin.property.edit", methods="GET|POST")
     * @param User $user
     */

    public function post(User $user, int $id, Request $request)

    {
        //dump($user);
        //dump($id);
        $form = $this->createForm(UserType::class,  $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

           
           // $this->em->persist($user);
            $this->em->flush();
            
        }

       

        return $this->render('edit.html.twig', [

            'title' => 'Ma page de contact (edit)',
            'form' => $form->createView()

        ]);

    }

    /**
     * @Route("/addUser", name="admin.property.new")
     */

    public function addUser(Request $request)

    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $this->em = $this->getDoctrine()->getManager();

            $this->em->persist($user);
            $this->em->flush();
            return $this->redirectToRoute('admin.property.home');
        }

        return $this->render('new.html.twig', [

            'title' => 'Ma page de contact (new)',
            'form' => $form->createView()

        ]);

    }

     /**
     * @Route("/posts/{id}", name="admin.property.delete", methods="DELETE")
     * @param User $user
     */

    public function delete(User $user, Request $request)

    {
        //dump($request);
        if($this->isCsrfTokenValid('delete'. $user->getId(), $request->get('_token')))
        {
            //$this->em = $this->getDoctrine()->getManager();
            $this->em->remove($user);
            $this->em->flush();


            
        }
        
        return $this->redirectToRoute('admin.property.home');
        
        

    }

}