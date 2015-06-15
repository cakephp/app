<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Controller\Component\CookieComponent;
use Cake\Controller\Component\RequestHandlerComponent;
class AdminController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie', ['expiry' => '30 day']);
        $this->loadComponent('RequestHandler');
        $this->layout = 'manager';
        $this->loadComponent('Auth',[
                'loginRedirect' => [
                	'controller' => 'Users',
                	'action' => 'login',
                	'admin' => false
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login'
            ], 
            'loginAction' => [
            	'controller' => 'Users',
            	'action' => 'login',
            	'admin'=> false
            ],	
        	'authenticate' => [
        	'Form' => [
                'fields' => ['username' => 'username', 'password' => 'password']
                    ]
                ]
            ]
            );
        $user =  $this->Auth->user();
        $time = Time::parse($user['last_access']);
        $user['last_access_time'] = $time->i18nFormat(\IntlDateFormatter::FULL, 'Europe/London', 'fr-FR');
        $this->set(compact('user'));
        $chambresobject = TableRegistry::get('Branchs');
        $branchs = $chambresobject->find('all');
        $this->set(compact('branchs'));
    }
    public function index(){
    }
}
