<?php
namespace johnitvn\advanceuser;

use Yii;
use yii\base\BootstrapInterface;
use yii\i18n\PhpMessageSource;
use yii\console\Application as ConsoleApplication;
use johnitvn\advanceuser\Module;

/**
* @author John Martin <john.itvn@gmail.com>
* @since 1.0
*/
class Bootstrap implements BootstrapInterface
{
	
    /**
     * Bootstrap method to be called during application bootstrap stage.
     *
     * @param Application $app the application currently running
     */
    public function bootstrap($app){

        /** @var Module $module */
        if($app->hasModule('user') && ($module = $app->getModule('user')) instanceof Module){ 
            if (!isset($app->get('i18n')->translations['user*'])) {
                $app->get('i18n')->translations['user*'] = [
                    'class'    => PhpMessageSource::className(),
                    'basePath' => __DIR__ . '/messages',
                ];
            }
            if ($app instanceof ConsoleApplication) {
                $module->controllerNamespace = 'johnitvn\advanceuser\commands';
            } else {
                $module->controllerNamespace = 'johnitvn\advanceuser\controllers';
            }


        }
    }
}