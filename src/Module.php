<?php
namespace johnitvn\advanceuser;

use Yii;
use \yii\base\Module as BaseModule;

class Module extends BaseModule
{
    /**
    * Time to rember user session
    * Note: require [[User::enableAutoLogin]] is enabled
    */
    public $rememberFor = 3600*24*2;

  
}