<?php

namespace johnitvn\userplus\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;


class SecurityController extends Controller
{

    /**
    * Block all action when user disable security handler
    * and block action register when user disable register
    */
    public function beforeAction($action){
        // echo '
        // <PRE>';
        // var_dump($action);
        // die();

        if(!parent::beforeAction($action)){
            return false;
        }else if(Yii::$app->getModule('user')->enableSecurityHandler){            
            if( $action->id=='register' && !Yii::$app->getModule('user')->enableRegister ){
                throw new NotFoundHttpException('Page not found');
            }else{
                return true;
            }
        }else{
            throw new NotFoundHttpException('Page not found');
        }
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
