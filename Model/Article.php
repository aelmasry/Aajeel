<?php

App::uses('AppModel', 'Model');

/**
 * Article Model
 *
 * @property Category $Category
 * @property Source $Source
 */
class Article extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'title';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'title' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
//                'message' => 'Your custom message here',
            ),
        ),
        'alias' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
//                'message' => 'Your custom message here',
            ),
        ),
        'content' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                //'message' => 'Your custom message here',
            ),
        ),
        'image' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
            //'message' => 'Your custom message here',
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Source' => array(
            'className' => 'Source',
            'foreignKey' => 'source_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Country' => array(
            'className' => 'Country',
            'foreignKey' => 'country_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    
//    public function mostRead‎($catId = NULL)
//    {
//        $this->find('all', array(
//            'conditions' => array('Articel.status' => 1),
//        ));
//    }
}
