<?php
namespace App\Controller\Admin;
class ServersController extends AdminController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }
}
