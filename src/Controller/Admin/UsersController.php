<?php
namespace App\Controller\Admin;
use Cake\ORM\TableRegistry;
use Cake\Controller\Component\CookieComponent;
use Cake\Network\Email\Email;
use Cake\Utility\Security;
use Cake\Controller\Component\RequestHandlerComponent;
class UsersController extends AdminController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Flash');
    	$this->layout = "login";
        $this->Auth->allow(['add','identify','reset','active']);
    }
    public function login() 
    {
     if ($this->request->is('post') || $this->Cookie->read('User.username')) {
        if ($this->Cookie->read('User.username')) {
            $this->request->data = [
            'username' => $this->Cookie->read('User.username'),
            'password' => $this->Cookie->read('User.password')
            ];
        }
        $user = $this->Auth->identify();
        if ($user) {
            if($this->request->data['remember'] == 1){
               $this->Cookie->write('User.username', $this->request->data['username']);
               $this->Cookie->write('User.password', $this->request->data['password']);
            }
                $this->Auth->setUser($user);
                $userTable = TableRegistry::get('Users');
                $userEntity = $userTable->get($user['id']); // article with id 12
                $userEntity->last_access = date('Y-m-d H:i:s');  
                $userTable->save($userEntity);
            return $this->redirect($this->Auth->redirectUrl());
        }
        $this->Flash->error(__("Nom d'utilisateur ou mot de passe incorrect, essayez à nouveau."));
    }
    }
    public function add(){
    	$userEntity = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $users =  TableRegistry::get('Users');
            if($data['agree'] == 1){
                $userArry = $users->find()
                    ->where(['username' => $data['username']])
                    ->toArray(); 
              
                if(empty($userArry)){
                    $userEntity = $this->Users->newEntity($data);
                    if ($this->Users->save($userEntity)) {
                        $userArry = $userEntity->toArray();
                        $userArry['username'] = Security::hash($userEntity->username,'sha1', true);
                        $email = new Email('default');
                        $email  ->template('registration','default')
                                ->emailFormat('html')
                                ->to($userEntity->username)
                                ->from('noreply@gmail.com')
                                ->viewVars($userArry)
                                ->send();
                        $this->Flash->success(__("Compte Ajouter a ete bien ajouter "));
                    }
                    else
                    {   
                        $this->Flash->error(__("Impossible d'ajouter l'utilisateur"));
                    }
                }
                else
                {
                    $this->Flash->error(__("impossible de creer compte adresse E-mail est déjà utilisée"));
                }   
            }
            else
            {
                 $this->Flash->error(__("Vous deuvez accepter le contrat"));
            }
        }
        $this->set(compact('userEntity'));
    }
    public function identify()
    {


        if($this->request->data){
            $data = $this->request->data;
            $users =  TableRegistry::get('Users');
            $userEntity = $users->find()
                                ->where(['username' => $data['username']])
                                ->first();
            $userArry = $userEntity->toArray();
            if(!empty($userArry)){
                $query = $users->query();
                $query->update()
                      ->set(['token' => Security::hash($userEntity->username,'sha1', true)])
                      ->where(['username' => $userEntity->username])
                      ->execute();
                $userArry['token'] = Security::hash($userEntity->username,'sha1', true);
                $email = new Email('default');
                $email->template('identify','default')
                      ->emailFormat('html')
                      ->to($userEntity->username)
                      ->from('noreply@gmail.com')
                      ->viewVars($userArry)
                      ->send();
                $this->Flash->success(__("votre boite email"));
            }
            else
            {
                $this->Flash->error(__("no user"));
            }

        }
            
    }
   	public function logout()
   	{
             if ($this->Cookie->read('User.username')) {
                $this->Cookie->delete('User');
             }
   	return $this->redirect($this->Auth->logout());
   	}
    public function index()
    {
        $this->layout = "manager";
        $userTable = TableRegistry::get('Users');
        $users = $userTable->find('all');
        $this->set(compact('users'));

    }
    public function destroy(){
     if ($this->request->data) {
            $aids = explode("|" , $this->request->data['aids']);
            
            for($i = 0 ; $i < count($aids) -1 ; $i++){
                $entity = $this->Users->get($aids[$i]);
                $this->Users->delete($entity);
            }
            $this->set('resp', true);
            $this->set('_serialize', 'resp');
        } 
        else
        {
            $this->set('resp', false);
            $this->set('_serialize', 'resp');
        }
    }
    public function edit($aid = null){
         $this->layout = "manager";
    }
    public function reset($val='')
    {
        if ($this->request->data) {
            $data = $this->request->data;
            $users =  TableRegistry::get('Users');
            $userEntity = $users->find()
                                ->where(['token' => $val])
                                ->first();
            if (!empty($userEntity->toArray())) {
                    $userEntityPass = $this->Users->newEntity(['password' => $data['password']]);
                    $query = $users->query();
                    $query->update()
                      ->set(['token' => null,'password' => $userEntityPass->password])
                      ->where(['username' => $userEntity->username])
                      ->execute();
                 $this->Flash->success(__("updated"));
            }


        }
    }
     public function active($val='')
    {
            $isactive = false;
            $users =  TableRegistry::get('Users');
            $userEntity = $users->find('all');
            foreach($userEntity as $userIterm){
                if(Security::hash($userIterm->username,'sha1', true) == $val ){
                    $query = $users->query();
                    $query->update()
                      ->set(['confirmed' => 1,])
                      ->where(['id' => $userIterm->id])
                      ->execute();
                    $isactive = true;
                    break;
                }
            }
        if($isactive){
             $this->Flash->success(__("updated"));
         }
            else
          {

             $this->Flash->error(__("error"));
         }
        
    }
    public function getusers()
    {
        $this->set('users', $this->paginate());
        $this->set('_serialize', 'users');
    }
}
