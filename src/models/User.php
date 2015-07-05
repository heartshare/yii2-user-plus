<?php

namespace johnitvn\advanceuser\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user_accounts".
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property integer $auth_key
 * @property string $confirm_password
 * @property integer $creator
 * @property integer $creator_ip
 * @property integer $confirmed_at
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @author John Martin <john.itvn@gmail.com>
 */
class User extends ActiveRecord implements IdentityInterface
{
    /* Status when user is active */
    const STATUS_ACTIVED = 1;
    /* Status when user is blocked */
    const STATUS_BLOCKED = 0;
    /* This user is register by user not created by admintrator */
    const CREATOR_BY_REGISTER = -1;


    public $password;
    public $confirm_password;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_accounts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password', 'confirm_password'], 'required'],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['password','confirm_password'], 'string', 'max' => 255],
            ['confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=>Yii::t("user","Comfirm Passwords don't match")],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('user', 'ID'),
            'email' => Yii::t('user', 'Email'),
            'password' => Yii::t('user', 'Password'),
            'confirm_password' => Yii::t('user', 'Comfirm Password'),
            'status' => Yii::t('user', 'Status'),           
            'creator' => Yii::t('user','Creator'),
            'creator_ip' => Yii::t('user', "IP's Creator IP"),
            'confirmed_at' => Yii::t('user', 'Confirmed At'),
            'created_at' => Yii::t('user', 'Created At'),
            'updated_at' => Yii::t('user', 'Updated At'),
        ];
    }

    /**
    * Register one user
    */
    public function register(){
        $this->creator = self::CREATOR_BY_REGISTER; 
        return $this->save();
    }

    /**
    * Create user from admin manager 
    */
    public function create(){
        $this->creator = self::CREATOR_BY_REGISTER; 
        return $this->save();
    }


    /**
     * This method is called at the beginning of
     * inserting or updating a record.
     */
    public function beforeSave($insert){
        if($insert){
            $this->status = self::STATUS_ACTIVED;

            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $this->creator_ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $this->creator_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $this->creator_ip = $_SERVER['REMOTE_ADDR'];
            } 
               
            $this->setPassword($this->password); 
            $this->created_at = time();
        } else {
               $this->updated_at = time();
        }
        return true;
    }


    /**
     * Find user by email
     *
     * @param string $email email to find
     * @return boolean|\johnitvn\advanceuser\models\User 
     */
    public function findUsernameByEmail($email){
        $model = User::findOne(['email'=>$email]);
        return $model;
    }

    public function isActived(){
        return $this->status == self::STATUS_ACTIVED;
    }



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



}
