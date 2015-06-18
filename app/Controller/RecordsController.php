<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class RecordsController extends AppController {
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Cookie');
	
/**
 * BeforeFilter method
 *
 * 
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
	}
	
	public function addRecord(){
		if ($this->request->is('post') && isset($this->data['Record']['record'])) {
			
			$check = $this->Record->find('first', array('conditions' => array('AND' => array('record' => $this->data['Record']['record'], 'user_id' => $this->data['Record']['user_id']))));
			
			if(!empty($check)){
				echo json_encode(array('response' => "Existe", 'message' => "El registro ya se encuentra agregado. Intenta nuevamente"));
				die(); 
			}
			
			$this->Record->create();
			if ($this->Record->save($this->request->data)) {
				echo json_encode(array('response' => "Correcto", 'message' => "El registro se realizo correctamente."));
				die();
			} else {				
				echo json_encode(array('response' => "El registro no pudo guardarse correctamente. Intenta nuevamente."));
				die();
			}			
		}else{
			$userId = $this->Session->read('userid');
			
			$this->set(compact('userId'));
			$this->render('/Elements/admin/records/add-record', 'ajax');
		}
	}
	
	public function deleteRecord($id=null){
		$this->Record->id = $id;
		
		if (!$this->Record->exists()) {
			echo json_encode(array('response' => "El registro ya no existe."));
			die();
		}
		
		
		if ($this->Record->delete()) {
			echo json_encode(array('response' => "ok", 'message' => "El registro se elimino correctamente."));
			die();
		} else {
			echo json_encode(array('response' => "Hubo un error al intentar eliminar el registro."));
			die();
		}		
	}


	public function listRecords(){
		if ($this->request->is('post')) {
			$records = $this->Record->find('all',array(
				'order' => array('Record.created')
			));

			$this->set(compact('records'));
		
			$this->render('/Elements/admin/records/list-records', 'ajax');
		}
	}
}