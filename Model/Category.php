<?php

App::uses('AppModel', 'Model');

/**
 * Category Model
 *
 * @property Content $Content
 * @property SourcesRss $SourcesRss
 */
class Category extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'name' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Your custom message here',
            ),
        ),
        'alias' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Your custom message here',
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'SourcesRss' => array(
            'className' => 'SourcesRss',
            'foreignKey' => 'category_id',
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

    
    public function getFullCategory()
    {
        return $this->find('all', array(
            'conditions' => array('Category.status' => 1),
        ));
    }
}
