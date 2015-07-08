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
     * @param string      $login    Login account
     * @param null|string $password Password
     */
    public function actionCreate($login, $password)
    {
        $user = Yii::createObject([
            'class'    => User::className(),
            'login'    => $login,
            'password' => $password,
        ]);
       
        if ($user->consoleCreate()) {
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

