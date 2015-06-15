<?php
namespace App\Controller\Admin;
use Cake\ORM\TableRegistry;
class OffersController extends AdminController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }
    public function add()
    {
	    $photoObj = new PhotosController();
		$offersTable = TableRegistry::get('Offers');
		$offerEntity =$offersTable->newEntity();
		 if ($this->request->is('post')) {
            $this->request->data['description'] = htmlEntities($this->request->data['description']); 
            $offerEntity = $offersTable->newEntity($this->request->data);
            if ($offersTable->save($offerEntity)) {
               if($photoObj->save($offerEntity->name,'Offers',$offerEntity->id)){
                $this->Flash->success(__("L'Chamber ou suite a été sauvegardé."));
                return $this->redirect('/admin/offers');
               };
            }else{
               
            $this->Flash->error(__("Impossible d'ajouter L'Chamber ou suite."));
            }
        }	
        else
        {
		    $photoObj->clean();
        }
		$this->set(compact('offerEntity'));
    }
    public function index()
    {
    	
    }
      public function getoffers()
    {
        $this->set('offers', $this->paginate());
        $this->set('_serialize', 'offers');
    }

}
