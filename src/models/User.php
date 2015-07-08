<?php

namespace johnitvn\userplus\models;

use Yii;
use johnitvn\userplus\base\BaseUser;


class User extends BaseUser{


	public function init(){
		$this->on(BaseUser::BEFORE_CREATE, [$this, 'beforeCreate']);
		$this->on(BaseUser::BEFORE_REGISTER, [$this, 'beforeRegister']);
		$this->on(BaseUser::BEFORE_CONSOLE_CREATE, [$this, 'beforeConsoleCreate']);
	}

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

    public function beforeConsoleCreate(){
        $this->superuser = self::IS_SUPER_USER;
        $this->creator = self::CREATOR_BY_CONSOLE; 
        $this->creator_ip = Yii::t('user','Local');
        $this->confirmed_at = time();  
    }    

	public function beforeCreate(){		      
        $this->superuser = self::IS_NOT_SUPER_USER;      
        $this->confirmed_at = time();  
        $this->prepareCreatorIp();
	}

	public function beforeRegister(){
        $this->superuser = self::IS_NOT_SUPER_USER;
        $this->creator = self::CREATOR_BY_REGISTER; 
        $this->prepareCreatorIp();
	}

	private function prepareCreatorIp(){
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $this->creator_ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $this->creator_ip = $_SERVER['HTTP_X_FORWARDED_FOR']; 
        } else {
            $this->creator_ip = $_SERVER['REMOTE_ADDR'];
        } 
    }

}
