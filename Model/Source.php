<?php

App::uses('AppModel', 'Model');

/**
 * Source Model
 *
 * @property Content $Content
 */
class Source extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'name' => array (
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'This field is required',
            ),
            'isUnique' => array (
                'rule' => 'isUnique',
                'message' => 'This name has already been taken.'
            )
        ),
        'alias' => array (
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Your custom message here',
            ),
            'isUnique' => array (
                'rule' => 'isUnique',
                'message' => 'This alias has already been taken.'
            )
        ),
        'domain' => array (
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Your custom message here',
            ),
            'isUnique' => array (
                'rule' => 'isUnique',
                'message' => 'This alias has already been taken.'
            ),
            'url' => array(
                'rule' => 'url',
                'message' => 'invalid URL.'
            )
        ),
        'logo' => array (
            'rule' => array('extension',array('jpeg','jpg','png','gif')),
            'required' => false,
            'allowEmpty' => false,
            'message' => 'Invalid file'
        ),
        
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Article' => array(
            'className' => 'Article',
            'foreignKey' => 'source_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );
    
    
    
}
