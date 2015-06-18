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
class UsersController extends AppController {
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');
	
/**
 * BeforeFilter method
 *
 * 
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('login','register');
	}
	
	
	public function login(){
		if ($this->request->is('post')) {			
			$user = $this->User->find('first', array(
				'conditions' => array('User.username' => $this->data['User']['email'])
			));
			
			if (!empty($user)) {
				if ($this->Auth->login($user)) {
				   echo json_encode(array('response' => "ok", 'redirect' => $this->Auth->redirectUrl()));
				   die();
				}else{
					echo json_encode(array('response' => "Error al inicar sesión. Verífica tus datos."));
					die();
				}			
			}else{
				echo json_encode(array('response' => "Aun no estas registrado en nuestra aplicación. Registrate Ahora!"));
				die();	
			}			
		}
	}
	
	public function logout(){
		 $this->Session->destroy();
		 return $this->redirect($this->Auth->logout());
	}

	public function register(){
		 if ($this->User->save($this->request->data)) {
			$id = $this->User->id;
			$this->request->data['User'] = array_merge(
				$this->request->data['User'],
				array('id' => $id)
			);
			
			unset($this->request->data['User']['password']);
			$this->Auth->login($this->request->data['User']);
			
			echo json_encode(array('response' => "ok", 'redirect' => $this->Auth->redirectUrl()));
		}
	}
}