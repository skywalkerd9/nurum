<?php
class User extends AppModel {
    public $displayField = 'username';
	
	 public $hasOne = array(
        'Record' => array(
            'className' => 'Record',
            'conditions' => array('Record.user_id' => 'Users.id'),
            'dependent' => true
        )
    );
}