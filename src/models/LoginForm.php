<?php

namespace johnitvn\advanceuser\models;

use Yii;
use yii\base\Model;
use johnitvn\advanceuser\models\User;

/**
 * LoginForm get user's login and password, validates them and logs the user in. If user has been blocked, it adds
 * an error to login form.
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class LoginForm extends Model
{
    /** @var string User's email or username */
    public $email;

    /** @var string User's plain password */
    public $password;

    /** @var \johnitvn\advanceuser\models\User */
    protected $user;

       
    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'email'            => Yii::t('user', 'Email'),
            'password'         => Yii::t('user', 'Password'),
        ];
    }

     /** @inheritdoc */
    public function formName()
    {
        return 'login-form';
    }


    /** @inheritdoc */
    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->user = User::findUsernameByEmail($this->email);
            return true;
        } else {
            return false;
        }
    }


    /** @inheritdoc */
    public function rules()
    {
        return [
            'requiredFields' => [['email', 'password'], 'required'],
            'loginTrim' => ['email', 'trim'],
            'loginInfoValidate' => [
                'password',
                function ($attribute) {
                    if ($this->user === null || !$this->user->validatePassword($this->password) ) {
                        $this->addError($attribute, Yii::t('user', 'Invalid login or password'));
                    }          
                }
            ],           
            'accountAvaiable' => [
                'password',
                function ($attribute) {                   
                    if (!$this->user->isActived()) {
                        $this->addError($attribute, Yii::t('user', 'Your account has been blocked'));
                    }                    
                }
            ]           
        ];
    }
    /**
     * Validates form and logs the user in.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->getUser()->login($this->user,0);
        } else {
            return false;
        }
    }
   
}