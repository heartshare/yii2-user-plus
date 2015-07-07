<?php

namespace johnitvn\userplus\commands;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
use johnitvn\userplus\models\User;


/**
* Manager user from command line.
*/
class ManagerController extends Controller
{
   /**
     * Create new superuser account.
     *
     * @param string      $email    Email address
     * @param null|string $password Password
     */
    public function actionCreateSu($email, $password)
    {
        $user = Yii::createObject([
            'class'    => User::className(),
            'email'    => $email,
            'password' => $password,
            // mock up confirm_password
            'confirm_password' => $password,
        ]);
       
        if ($user->cliCreateSuperUser()) {
            $this->stdout(Yii::t('user', 'User has been created') . "!\n", Console::FG_GREEN);
        } else {
            $this->stdout(Yii::t('user', 'Please fix following errors:') . "\n", Console::FG_RED);
            foreach ($user->errors as $errors) {
                foreach ($errors as $error) {
                    $this->stdout(' - ' . $error . "\n", Console::FG_RED);
                }
            }
        }
    }

    /**
     * Create new account.
     *
     * @param string      $email    Email address
     * @param null|string $password Password
     */
    public function actionCreate($email,$password){
         $user = Yii::createObject([
            'class'    => User::className(),
            'email'    => $email,
            'password' => $password,
            // mock up confirm_password
            'confirm_password' => $password,
        ]);
       
        if ($user->cliCreate()) {
            $this->stdout(Yii::t('user', 'User has been created') . "!\n", Console::FG_GREEN);
        } else {
            $this->stdout(Yii::t('user', 'Please fix following errors:') . "\n", Console::FG_RED);
            foreach ($user->errors as $errors) {
                foreach ($errors as $error) {
                    $this->stdout(' - ' . $error . "\n", Console::FG_RED);
                }
            }
        }
    }
}

