<?php
namespace App\Controller\Admin;
use Cake\ORM\TableRegistry;
use App\Controller\Component;
class RoomsController extends AdminController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }
    public function index()
    {

        $roomTable = TableRegistry::get('Rooms');
        $rooms = $roomTable->find('all');
        $this->set(compact('rooms'));
    }
    public function add(){
    	$roomEntity = $this->Rooms->newEntity();
        if ($this->request->is('post')) {
            $this->request->data['description'] = htmlEntities($this->request->data['description']); 
            $roomEntity = $this->Rooms->newEntity($this->request->data);
            if ($this->Rooms->save($roomEntity)) {
                 $photoObj = new PhotosController();
               if($photoObj->save($roomEntity->name,'Rooms',$roomEntity->id)){
                $this->Flash->success(__("L'Chamber ou suite a été sauvegardé."));
                return $this->redirect('/admin/rooms');
               };
            }else{
               
            $this->Flash->error(__("Impossible d'ajouter L'Chamber ou suite."));
            }
        }
        $this->set(compact('roomEntity'));
    }
    public function destroy(){
        if ($this->request->data) {
            $aids = explode("|" , $this->request->data['aids']);
            
            for($i = 0 ; $i < count($aids) -1 ; $i++){
                $entity = $this->Rooms->get($aids[$i]);
                $this->Rooms->delete($entity);
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
    public function getrooms()
    {
        $this->set('rooms', $this->paginate());
        $this->set('_serialize', 'rooms');
    }
}
