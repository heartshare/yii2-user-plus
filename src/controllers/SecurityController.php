<?php

namespace johnitvn\userplus\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;


class SecurityController extends Controller
{

    public function beforeAction($action){
        if(!parent::beforeAction($action))
            return false;
        else if(Yii::$app->getModule('user')->enableSecurityHandler)
            return true;
        else
            throw new NotFoundHttpException('Page not found');
    }
    
    public function actions()
    {
        return [         
            'logout' => [
                'class' => 'johnitvn\userplus\actions\LogoutAction',                                
            ],
            'login' => [
                'class' => 'johnitvn\userplus\actions\LoginAction',
            ],
            'register' => [
                'class' => 'johnitvn\userplus\actions\RegisterAction',
            ]         
        ];
    }
   
}
