<?php
namespace johnitvn\advanceuser;

use yii\base\BootstrapInterface;
use yii\i18n\PhpMessageSource;

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
         if (!isset($app->get('i18n')->translations['user*'])) {
            $app->get('i18n')->translations['user*'] = [
                'class'    => PhpMessageSource::className(),
                'basePath' => __DIR__ . '/messages',
            ];
        }
        \Yii::$app->language = 'vi';
    }
}