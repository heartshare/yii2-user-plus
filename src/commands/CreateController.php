<?php

namespace johnitvn\userplus\commands;

use Yii;
use yii\helpers\Console;
use yii\console\Controller;
use johnitvn\userplus\models\User;


/**
 * ManagerController implements the CRUD actions for User model.
 */
class CreateController extends Controller
{
   /**
     * This command creates new user account. 
     *
     * @param string      $email    Email address
     * @param null|string $password Password
     */
    public function actionIndex($email, $password)
    {
        $user = Yii::createObject([
            'class'    => User::className(),
            'email'    => $email,
            'password' => $password,
            // mock up confirm_password
            'confirm_password' => $password,
        ]);
       
        if ($user->createSuperUser()) {
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

