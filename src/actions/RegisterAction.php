<?php
namespace johnitvn\advanceuser\actions;

use Yii;
use yii\base\Action; 
use yii\base\InvalidConfigException;
use johnitvn\advanceuser\models\RegistrationForm;
use johnitvn\advanceuser\traits\AjaxValidationTrait;

/**
* @author John Martin <john.itvn@gmail.com>
*/
class RegisterAction extends Action{

  use AjaxValidationTrait;

	/**
  * @var string callback will be call when login success
  */
  public $successCallback;
 
		
	/**
    * @var string view will be render when to register
    */
	public $view;

  /**
  * @var johnitvn\advanceuser\models\RegistrationForm form model for validate
  */
  public $form = 'johnitvn\advanceuser\models\RegistrationForm';


  public function init(){
      if($this->successCallback==null){
          $this->successCallback = function($action){
              return $this->controller->goHome();
          };
      }
  }

   /**
   * Runs the action
   *
   * @return string result content
   */
  public function run(){
    // Create form model
	  $model = Yii::createObject($this->form);

    // Ensure form model is instance of Registration Form for Security
    if(!($model instanceof RegistrationForm)){
        throw new InvalidConfigException("RegisterAction::$form must instanceof johnitvn\advanceuser\models\RegistrationForm\n
                                          Leave empty this config if you don't want to customize register field");
    }

  	$this->performAjaxValidation($model);     

  	if ($model->load(Yii::$app->request->post()) && $model->register()) {          
        return call_user_func($this->successCallback,$this,$model);
  	}else{       
  		return $this->controller->render($this->view, [                
            'model'  => $model,
        ]);
  	}
  }

}