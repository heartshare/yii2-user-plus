<?php

namespace johnitvn\userplus\models;

use Yii;
use johnitvn\userplus\base\BaseLoginForm;

/**
 *
 * @author John Martin <john.itvn@gmail.com>
 */
class LoginForm extends BaseLoginForm
{
           
 
    /**
     * @inheritdoc
     */
    public function rules(){
        $rules = parent::rules();
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
    
   
}