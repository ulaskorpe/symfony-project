<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class MessageGenerator
{

    /**
     * @var $nameGenerator
     */
    private $nameGenerator;
    private $requestStack;
     public function __construct(NameGenerator $nameGenerator,RequestStack $requestStack){
        $this->nameGenerator = $nameGenerator;
        $this->requestStack = $requestStack;
     }

     public function helloMessage(){
        $name = (!empty( $this->requestStack->getCurrentRequest()->get('name')))? $this->requestStack->getCurrentRequest()->get('name'):$this->nameGenerator->randomName();
            $message = "Hello ".$name." !";
            return $message;
     }
}