<?php
namespace johnitvn\userplus\base;

use Yii;
use yii\base\Model;
use johnitvn\userplus\models\User;

/**
 * Registration form collects user input on registration process, validates it and creates new User model.
 *
 * @author John Martin <john.itvn@gmail.com>
 */
class BaseRegistrationForm extends Model
{

    /**
     * @var string User email address
     */
    public $login;

    /**
     * @var string Password
     */
    public $password;

    /**
     * @var string Confirm Password
     */
    public $confirm_password;

    /**
     * @inheritdoc
     */
    public function rules()
    {       
        return [          
            // email rules
            'loginTrim'     => ['login', 'filter', 'filter' => 'trim'],
            'loginRequired' => ['login', 'required'],
            'loginPattern'  => ['login', 'email'],
            'loginUnique'   => [
                'login',
                'unique',
                'targetClass' => 'johnitvn\userplus\models\User',
                'message' => Yii::t('user', 'This account has already been taken')
            ],
            // password rules
            'passwordRequired' => ['password', 'required'],
            'passwordLength'   => ['password', 'string', 'min' => 6],
            
            // confirm password rules
            'confirmPasswordRequired' => ['confirm_password', 'required'],
            'confirmPasswordCompare'   => ['confirm_password', 'compare', 'compareAttribute'=>'password', 'message'=>Yii::t("user","Comfirm Passwords don't match")],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'login'            => Yii::t('user', 'Login'),
            'password'         => Yii::t('user', 'Password'),
            'confirm_password' => Yii::t('user', 'Comfirm Password'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 'register-form';
    }

    /**
     * Registers a new user account. If registration was successful it will set flash message.
     *
     * @return bool
     */
    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        /** @var User $user */
        $user = Yii::createObject([
            'class'    => User::className(),           
            'scenario' => 'register',
        ]);
        $this->loadAttributes($user);

        if (!$user->register()) {            
            return false;
        }

        return true;
    }

    /**
     * Loads attributes to the user model. You should override this method if you are going to add new fields to the
     * registration form. You can read more in special guide.
     *
     * By default this method set all attributes of this model to the attributes of User model, so you should properly
     * configure safe attributes of your User model.
     *
     * @param User $user
     */
    protected function loadAttributes(User $user)
    {
        $user->setAttributes($this->attributes);
    }

}
