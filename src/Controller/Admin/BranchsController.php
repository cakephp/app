<?php
namespace App\Controller\Admin;
use DebugKit\DebugPanel;
class RoomsController extends AdminController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }
}
