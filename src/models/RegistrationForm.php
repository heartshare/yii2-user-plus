<?php
namespace johnitvn\userplus\models;

use Yii;
use johnitvn\userplus\base\BaseRegistrationForm;

/**
 * @author John Martin <john.itvn@gmail.com>
 */
class RegistrationForm extends BaseRegistrationForm
{


    /**
     * @inheritdoc
     */
    public function rules(){
        $rules = parent::rules();
        $rules['loginPattern'] =  ['login', 'email'];
        return $rules; 
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['login'] =  Yii::t('user', 'Email');
        return $labels;
    }    

    /**
     * @inheritdoc
     */
    protected function loadAttributes(User $user)
    {
       parent::loadAttributes($user);
    }

}
