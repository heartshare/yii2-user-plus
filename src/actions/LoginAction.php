<?php
namespace johnitvn\advanceuser\actions;

use Yii;
use yii\base\Action; 
use johnitvn\advanceuser\models\LoginForm;
use yii\web\MethodNotAllowedHttpException; 
use johnitvn\advanceuser\traits\AjaxValidationTrait;

class LoginAction extends Action{

    use AjaxValidationTrait;

	/**
    * @var string url will be redirect to when register success
    */
	public $successUrl;
		
	/**
    * @var string view will be render when to register
    */
	public $view;

	/**
     * Runs the action
     *
     * @return string result content
     */
    public function run(){
    	/** @var LoginForm $model */
        $model = Yii::createObject(LoginForm::className());

        $this->performAjaxValidation($model);

    	if ($model->load(Yii::$app->request->post()) && $model->login()) {          
	        return $this->controller->goBack();
    	}else{       
    		return $this->controller->render($this->view, [                
	            'model'  => $model,
	        ]);
    	}
    	
    }

}