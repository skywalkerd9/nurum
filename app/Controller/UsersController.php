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
	public $components = array('Paginator', 'Session', 'Cookie');
	
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
				if(isset($this->data['login'])){
					$try = $this->Cookie->read('try'); //número de intentos que ha realizado el usuario
					$block = $this->Cookie->read('block_time'); //el tiempo que lleva bloqueado el usuario
					
					$check_user = $this->User->find('first', array('conditions' => array('AND' => array('username' => $this->data['User']['email'], 'password' => AuthComponent::password($this->data['User']['password']), 'active' => 1))));	
					
					if(empty($check_user)){																		
						echo json_encode(array('response' => "Error al inicar sesión. Verífica tus datos."));
						die();
					}
				}
				
				
				
				if ($this->Auth->login($user)) {
				   $this->Session->write('userid',$user['User']['id']);
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
		if ($this->request->is('post')) {
			$user = $this->User->find('first', array(
					'conditions' => array('User.username' => $this->data['User']['email'])
			));

			if (!empty($user)) {
				echo json_encode(array('response' => "Ya te encuentras registrado con nosotros. Inicia sesión con tu cuenta ".$this->data['User']['email']));
				die();
			} 

			$this->request->data['User']['username'] = $this->request->data['User']['email'];
			$this->request->data['User']['first_name'] = $this->request->data['User']['name'];;
			$this->request->data['User']['user_group_id'] = 2;
			$this->request->data['User']['remember'] = 1;
			$this->request->data['User']['email_verified'] = 1;
			$this->request->data['User']['active'] = 1;
			$this->request->data['User']['salt'] = $this->makeSalt();;
			$this->request->data['User']['password'] = AuthComponent::password($this->request->data['User']['password']);		

			 if ($this->User->save($this->request->data)) {
				$id = $this->User->id;
				$this->request->data['User'] = array_merge(
					$this->request->data['User'],
					array('id' => $id)
				);

				unset($this->request->data['User']['password']);
				$this->Auth->login($this->request->data['User']);

				echo json_encode(array('response' => "ok", 'message' => "Gracias por registrarte con NURUM-ADMIN!",  'redirect' => $this->Auth->redirectUrl()));
				die();
			}
		}
	}
	
	public function profile($id=null){
		if ($this->request->is('post')) {			
			$user = $this->User->find('first',array(
				'conditions' => array('User.id' => $this->Session->read('userid'))
			));
			
			$this->set(compact('user'));
			$this->render('/Elements/admin/users/profile', 'ajax');
		}
	}
	
	public function makeSalt() {
		$rand = mt_rand(0, 32);
		$salt = md5($rand . time());
		return $salt;
	}
}