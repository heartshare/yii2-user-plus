<?php
namespace johnitvn\advanceuser\actions;

use Yii;
use yii\base\Action; 

/**
* @author John Martin <john.itvn@gmail.com>
*/
class LogoutAction extends Action{


	/**
    * @var string callback will be call when login success
    */
    public $successCallback;


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
    	Yii::$app->getUser()->logout();
        return call_user_func($this->successCallback,$this);
    }

}