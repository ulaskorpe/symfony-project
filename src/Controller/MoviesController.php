<?php

namespace App\Controller;

//use App\Repository\MovieRepository;

use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    
 
    private $em;

    public function __construct(EntityManagerInterface $em){

        $this->em = $em;

    }

    
    #[Route('/movies/{name}', name: 'app_movies',defaults:['name'=>'alien-2'],methods:['GET','HEAD'])]
    //public function index($name="alien"): JsonResponse
    public function index($name ): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!'.$name,
            'path' => 'src/Controller/MoviesController.php',
        ]);
    }

    /**
     *@Route("/old",name="old")  /// route requires 2 params 1 endpoint 2 name 
     *  
     */
 //   public function oldMethod(MovieRepository $movieRepository):Response {
  //  public function oldMethod(EntityManagerInterface $em):Response {
    public function oldMethod() : Response  {


        $repository = $this->em->getRepository(Movie::class);
      // $movies = $movieRepository->findAll();
        $movies = $repository->findAll();
      // $movies = $repository->find(17);
     //   $movies = $repository->findBy(['id'=>18,'title'=>'Myra O\'Kon'],['id'=>'DESC']);
        
        //return $this->render('old.html.twig',['title'=>'ssome title','movies'=>$movieRepository->findAll()]);
        return $this->render('old.html.twig',['title'=>'','movies'=>$movies]);
    }
}
