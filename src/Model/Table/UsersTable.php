<?php 
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Validation\Validator;
class UsersTable extends Table
{

	 public function validationDefault(Validator $validator)
    {
        return $validator
            ->notEmpty('username', "Un nom d'utilisateur est nécessaire")
            ->notEmpty('password', 'Un mot de passe est nécessaire')
            ->add('username', 'validFormat', [
                    'rule' => 'email',
                    'message' => 'E-mail must be valid'
                ]);
    }
	public function initialize(array $config)
    {
       $this->addBehavior('Timestamp');
    }	
}