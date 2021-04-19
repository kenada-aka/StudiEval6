<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;                         // Permet d'utiliser les routes sans "config/routes.yaml


use Doctrine\ORM\EntityManagerInterface;
//use Doctrine\Common\Persistence\ObjectManager;



class DefaultController extends AbstractController

{

    private $repository; 
    private $em;

    private $adminRepository;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    /**

     * @Route("/test", name="home.property.home")

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
     * @Route("/posts/{id}", name="admin.property.edit", methods="GET|POST")
     * @param User $user
     */
/*
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
*/
    

     /**
     * @Route("/posts/{id}", name="admin.property.delete", methods="DELETE")
     * @param User $user
     */
/*
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
*/
}