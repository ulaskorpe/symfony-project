<?php
namespace App\Service ;

class NameGenerator 
{

   public function randomName(){
      $names = [ 'Ulaş','Özge','Fiko','Hakan'];
      $index = array_rand($names);

      return  $names[$index];
   }

}