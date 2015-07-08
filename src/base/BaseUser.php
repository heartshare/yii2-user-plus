<?php

namespace johnitvn\userplus\base;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user_accounts".
 * @author John Martin <john.itvn@gmail.com>
 */
class BaseUser extends ActiveRecord implements IdentityInterface
{
    
    const BEFORE_CREATE           =  'beforeCreate';
    const AFTER_CREATE            =  'afterCreate';
    const BEFORE_CONSOLE_CREATE   =  'beforeConsoleCreate';
    const AFTER_CONSOLE_CREATE    =  'afterConsoleCreate';
    const BEFORE_REGISTER         =  'beforeRegister';
    const AFTER_REGISTER          =  'afterRegister';

    const CREATOR_BY_CONSOLE      = -2;
    const CREATOR_BY_REGISTER     = -1;

    const IS_SUPER_USER = 1;
    const IS_NOT_SUPER_USER = 0;

    const STATUS_BLOCKED = 0;
    const STATUS_ACTIVED = 1;

    public $password;
    public $confirm_password;
    protected $_module;




    /** @inheritdoc */
    public function init()
    {
        $this->_module = Yii::$app->getModule('user');
        parent::init();
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // login rules
            'loginRequired' => ['login', 'required', 'on' => ['register', 'create', 'console-create']],
            'loginLength'   => ['login', 'string', 'max' => 255],
            'loginUnique'   => ['login', 'unique', 'message' => Yii::t('user', 'This account name has already been taken')],
            'loginTrim'     => ['login', 'trim'],

            // password rules
            'passwordRequired' => ['password', 'required', 'on' => ['register','create', 'console-create']],
            'passwordLength'   => ['password', 'string', 'min' => 6],

            //confirm password rules
            'confirmPasswordRequired' => ['password', 'required', 'on' => ['register','create']],
            'confirmPasswordLength'   => ['confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=>Yii::t("user","Comfirm Passwords don't match")],

        ];       
    }

     /**
     * @inheritdoc
     */
    public function scenarios()
    {       
        return [
            'create'=>['login','password','confirm_password'],
            'register'=>['login','password','confirm_password'],
            'console-create'=>['login','password'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('user', 'ID'),
            'login' => Yii::t('user', 'Login'),
            'password' => Yii::t('user', 'Password'),
            'confirm_password' => Yii::t('user', 'Comfirm Password'),
            'status' => Yii::t('user', 'Status'), 
            'superuser'=>  Yii::t('user', 'Supper User'),           
            'creator' => Yii::t('user','Creator'),
            'creator_ip' => Yii::t('user', "IP's Creator IP"),
            'confirmed_at' => Yii::t('user', 'Confirmed At'),
            'created_at' => Yii::t('user', 'Created At'),
            'updated_at' => Yii::t('user', 'Updated At'),
        ];
    }


    public function consoleCreate(){
        $this->scenario = 'console-create';          
        $this->trigger(self::BEFORE_CONSOLE_CREATE);      
        if(!$this->save()){
            return false;
        }
        $this->trigger(self::AFTER_CONSOLE_CREATE);   
        return true;
    }
   

    /**
    * Create user from admin manager 
    */
    public function create($creatorUserId){   
        $this->scenario = 'create';     
        $this->trigger(self::BEFORE_CREATE);                
        if(!$this->save()){
            return false;
        }
        $this->trigger(self::AFTER_CREATE); 
        return true;  
    }

    public function register(){     
        $this->scenario = 'register';
        $this->trigger(self::BEFORE_REGISTER);                
        if(!$this->save()){
            return false;
        }
        $this->trigger(self::AFTER_REGISTER);   
        return true;
    }



    /**
     * This method is called at the beginning of
     * inserting or updating a record.
     */
    public function beforeSave($insert){
        if($insert){    
            $this->status = self::STATUS_ACTIVED;      
            $this->created_at = time();
            $this->updated_at = -1;
        } else {                  
            $this->updated_at = time();
        }

        if($this->password!==null){
            $this->setPassword($this->password); 
        }
        return true;
    }


    /**
     * Find user by email
     *
     * @param string $email email to find
     * @return boolean|\johnitvn\userplus\models\User 
     */
    public function findIdentityByLogin($login){
        $model = BaseUser::findOne(['login'=>$login]);
        return $model;
    }

    /**
     * Check user is actived status
     *
     * @return boolean whether user is actived
     */
    public function isBlocked(){
        return $this->status == self::STATUS_BLOCKED;
    }

    /**
     * Check superuser permistion of user
     *
     * @return boolean whether user is super user
     */
    public function isSuperuser(){
        return $this->superuser == self::IS_SUPER_USER;
    }


    /**
    * Validates password
    *
    * @param string $password password to validate
    * @return boolean if password provided is valid for current user
    */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
    * Generates password hash from password and sets it to the model
    *
    * @param string $password
    */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }





    /**
    *               IdentityInterface functons 
    * =================================================================================
    */


    /**
     * Finds an identity by the given ID.
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id){
        return static::findOne($id);
    }

       /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|integer an ID that uniquely identifies a user identity.
     */
    public function getId(){
         return $this->id;
    }


    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null){
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }


 

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey(){
       return $this->auth_key;         
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return boolean whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey){
        return $this->getAuthKey() === $authKey;
    }

     /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_accounts';
    }


}
