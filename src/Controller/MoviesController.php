<?php

namespace App\Controller;

//use App\Repository\MovieRepository;

use App\Entity\Movie;
use App\Form\MovieFormType;
use App\Form\MovieTypeFormType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    
 
    private $em;
    private $movieRepository;
    public function __construct(EntityManagerInterface $em, MovieRepository $movieRepository){

        $this->em = $em;
        $this->movieRepository = $movieRepository;

    }

    
    #[Route('/movies', name: 'movies',methods:['GET','HEAD'])]
    
    public function index(MovieRepository $movieRepository): Response
    {

      //  $movies = $movieRepository->findAll();
        $movies = $movieRepository->findBy([],['id'=>'DESC']);

       return $this->render("movie-list.html.twig",['title'=>'movies','movies'=>$movies]);
    }
    #[Route('/movie/{id}', name: 'movie',methods:['GET','HEAD'])]
    
    public function show($id): Response
    {

        $repository = $this->em->getRepository(Movie::class);
      //  $movie = $repository->find($id);
        $movie = $repository->findOneBy(['id'=>$id]);
    
       

       return $this->render("movie-detail.html.twig",['title'=>'movies','movies'=>$movie]);
    }


    #[Route('/movies/edit/{id}', name:'edit_movie')]
    public function edit($id,Request $request){
      $movie = $this->movieRepository->find($id);
      $form = $this->createForm(MovieTypeFormType::class,$movie);
        $form->handleRequest($request);
        $imagePath = $form->get('imagePath')->getData();
        if($form->isSubmitted() && $form->isValid()){
            if($imagePath) {
                 
              if(file_exists(
                $this->getParameter('kernel.project_dir').$movie->getImagePath()
                )){
                  unlink($this->getParameter('kernel.project_dir').'/public/uploads',$movie->getImagePath());
                }
              
                    $newFileName = uniqid().".".$imagePath->guessExtension();
                   
                    try{
                      $imagePath->move(
                        $this->getParameter('kernel.project_dir').'/public/uploads',$newFileName
                      );
                      $movie->setImagePath('/uploads/'.$newFileName);
                      $this->em->flush();
                    }catch(FileException $e){
                        return new Response($e->getMessage());
                    }
        
                 
                
                
           
            }

            $movie->setTitle($form->get('title')->getData());
            $movie->setReleaseYear($form->get('releaseYear')->getData());
            $movie->setDescription($form->get('description')->getData());
            $this->em->flush();
            return $this->redirectToRoute('movies');
        }


        return $this->render('edit-movie.html.twig',['movie'=>$movie,'form'=>$form->createView(),'title'=>'edit movie']);
    }

    #[Route('/movies/create', name:'create_movie')]
    public function create(Request $request) {
        $movie = new Movie();
        $form = $this->createForm(MovieTypeFormType::class,$movie);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
         // $newMovie = new Movie();
          $newMovie = $form->getData();
      
           $imagePath = $form->get('imagePath')->getData();
           if($imagePath){
            $newFileName = uniqid().".".$imagePath->guessExtension();
            try{
              $imagePath->move(
                $this->getParameter('kernel.project_dir').'/public/uploads',$newFileName
              );
            }catch(FileException $e){
                return new Response($e->getMessage());
            }

            $newMovie->setImagePath('/uploads/'.$newFileName);

           }
            $this->em->persist($newMovie);
           $this->em->flush();
            return $this->redirectToRoute('movies');
          //  dd($newMovie);
          //   exit;
        }
        return $this->render('create-movie.html.twig',['form'=>$form->createView(),'title'=>'createmovie']);
    }
    #[Route('/movies/delete/{id}', name:'delete_movie',methods : ['GET','DELETE'])]
    public function delete($id){
      $movie = $this->movieRepository->find($id);
      $this->em->remove($movie);
      $this->em->flush();
      return $this->redirectToRoute('movies');
      
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
