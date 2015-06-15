<?php
namespace App\Controller\Admin;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
use App\Controller\Component\ImageController;
class PhotosController extends AdminController
{
    public function initialize()
    {
        define('PATH_PHOTOS',WWW_ROOT.'img'.DIRECTORY_SEPARATOR.'photos'.DIRECTORY_SEPARATOR);
        define('PATH_PHOTOS_STORAGE',WWW_ROOT.'img'.DIRECTORY_SEPARATOR.'photos-storage'.DIRECTORY_SEPARATOR);
        parent::initialize();
        $this->loadComponent('Flash');
    }
    private function delTree($dir) {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir($dir . "/" . $file)) ? delTree($dir . "/" . $file) : unlink($dir . "/" . $file);
        }
        return rmdir($dir);
    }
    public function temps()
    {
       $session_str	= str_replace('CAKEPHP=','', $_SERVER['HTTP_COOKIE']);
    	if (isset($_FILES['file'])) {
    		mkdir(PATH_PHOTOS.$session_str);
	    	if (move_uploaded_file($_FILES['file']['tmp_name'], PATH_PHOTOS.$session_str.DIRECTORY_SEPARATOR.$_FILES['file']['name'])) {
	    			die(true);
	    	}
    	}
    }
     public function save($slug = '', $branch = 'Rooms', $branch_id = 1)
     {
     	$name_slug = strtolower(Inflector::slug($slug));
     	$imgObj = new ImageController();
     	$session_str = str_replace('CAKEPHP=','', $_SERVER['HTTP_COOKIE']);
     	$files = scandir(PATH_PHOTOS.$session_str.DIRECTORY_SEPARATOR);
     	$photoTable = TableRegistry::get('Photos');
     	$branchTable = TableRegistry::get($branch.'Photos');
     	$lastPhoto = $photoTable->find('all',['order'=>'id DESC'])->first();
     	$aid = 1;
     	if ($lastPhoto) {
     		$aid = ($lastPhoto->id)+1;
     	}
            if (false !== $files) {
            	foreach ($files as $file) {
            		if ('.' != $file && '..' != $file) {
            			$photo = ['name'=> $name_slug.'-'.$aid.'.jpg' ];
        				$photoEntity = $this->Photos->newEntity($photo);
        				$this->Photos->save($photoEntity);
     					$imgObj->load(PATH_PHOTOS.$session_str.DIRECTORY_SEPARATOR.$file)->fit_to_width(800)->save(PATH_PHOTOS_STORAGE.'800'.DIRECTORY_SEPARATOR.$name_slug.'-'.$aid.'.jpg');
           						$h = $imgObj->load(PATH_PHOTOS_STORAGE.'800'.DIRECTORY_SEPARATOR.$name_slug.'-'.$aid.'.jpg')
           									->get_height();
                                $w = $imgObj->load(PATH_PHOTOS_STORAGE.'800'.DIRECTORY_SEPARATOR.$name_slug.'-'.$aid.'.jpg')
                                			->get_width();
                                
                                    if(($h-450) > 0){
                                         $y1 = ($h - 450)/2;
                                         $y2 = ($y1 + 450); 
                                         $imgObj->load(PATH_PHOTOS_STORAGE.'800'.DIRECTORY_SEPARATOR.$name_slug.'-'.$aid.'.jpg')->crop(0,$y1,800,$y2)
                                         		->save(PATH_PHOTOS_STORAGE.$name_slug.'-'.$aid.'.jpg');
                                         unlink(PATH_PHOTOS_STORAGE.'800'.DIRECTORY_SEPARATOR.$name_slug.'-'.$aid.'.jpg');

                                    } 
                                    else{
                                         $imgObj->load(PATH_PHOTOS.$session_str.DIRECTORY_SEPARATOR.$file)
                                         		->fit_to_height(450)
                                         		->save(PATH_PHOTOS_STORAGE.'450'.DIRECTORY_SEPARATOR.$name_slug.'-'.$aid.'.jpg');
                                         $w = $imgObj	->load(PATH_PHOTOS_STORAGE.'450'.DIRECTORY_SEPARATOR.$name_slug.'-'.$aid.'.jpg')
                                         				->get_width();
                                         $x1 = ($w - 800)/2;
                                         $x2 = $x1 + 800;
                                         $imgObj->load(PATH_PHOTOS_STORAGE.'450'.DIRECTORY_SEPARATOR.$name_slug.'-'.$aid.'.jpg')->crop($x1,0,$x2,450)
                                         		->save(PATH_PHOTOS_STORAGE.DIRECTORY_SEPARATOR.$name_slug.'-'.$aid.'.jpg');
                                        unlink(PATH_PHOTOS_STORAGE.'450'.DIRECTORY_SEPARATOR.$name_slug.'-'.$aid.'.jpg');

                                    }
            			$aid = $photoEntity->id;
            			$branchItem = [substr(strtolower($branch),0,-1).'_id' => $branch_id,'photo_id' => $aid] ;
        				$branchEntity = $branchTable->newEntity($branchItem);
        				$branchTable->save($branchEntity);
        				return true;
            		}
            	}
            	$this->clean();
            }
     }
     public function clean()
     {
        $session_str    = str_replace('CAKEPHP=','', $_SERVER['HTTP_COOKIE']);
        if(is_dir(PATH_PHOTOS.$session_str.DIRECTORY_SEPARATOR)){
            $this->delTree(PATH_PHOTOS.$session_str.DIRECTORY_SEPARATOR);
        }

     }


}
