<?php 
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class RoomsTable extends Table
{
     public function initialize(array $config)
    {
       $this->addBehavior('Timestamp');
    }   
}