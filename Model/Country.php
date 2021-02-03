<?php

App::uses('AppModel', 'Model');

/**
 * Category Model
 *
 * @property Content $Content
 * @property SourcesRss $SourcesRss
 */
class Country extends AppModel {

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
                'message' => 'This field is required',
            ),
        ),
        'code' => array(
            'minLength' => array(
                'rule' => array('between', 2, 2),
                'message' => 'Country code must be 2 characters.',
                'allowEmpty' => false
            ),
            'alphaNumeric' => array(
                'rule'     => '/^[a-z]/i',
                'required' => true,
                'message'  => 'Alphabets only'
            )
        )
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'SourcesRss' => array(
            'className' => 'SourcesRss',
            'foreignKey' => 'country_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Article' => array(
            'className' => 'Article',
            'foreignKey' => 'country_id',
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
    
    public function getFullCountry()
    {
        return $this->find('all', array(
            'conditions' => array('Country.status' => 1),
        ));
    }
}
