<?php

namespace App\Controller ;

use App\Service\MessageGenerator;
 
use App\Service\NameGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
 use Symfony\Component\Routing\Annotation\Route;
class HelloController extends AbstractController{
    /**
     * @Route("/hello")
     */
    public function index(RequestStack $requestStack) : Response
    {
        $mg = new MessageGenerator(new NameGenerator(),$requestStack);
     
        $message = $mg->helloMessage();
        return new Response( $message );
    }
}