<?php

use yii\db\Schema;
use yii\db\Migration;
use johnitvn\userplus\migrations\BaseMigration;

class m150703_191015_init extends BaseMigration {


    public function up()
    {
    	$this->createTable('user_accounts', [
            'id' 				   => Schema::TYPE_PK,           
            'email'                => Schema::TYPE_STRING . '(255) NOT NULL',
            'password_hash'	       => Schema::TYPE_STRING . '(255) NOT NULL',  
            'auth_key'             => Schema::TYPE_STRING . '(255) NOT NULL',  
            'status'               => Schema::TYPE_INTEGER,     
            'superuser'            => Schema::TYPE_INTEGER,      
            'creator'              => Schema::TYPE_INTEGER,
            'creator_ip'           => Schema::TYPE_STRING . '(40)',
            'confirm_token'        => Schema::TYPE_STRING,
            'resetpaswd_token'     => Schema::TYPE_STRING,
            'confirmed_at'         => Schema::TYPE_INTEGER,
            'created_at'           => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at'           => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $this->tableOptions);
        $this->createIndex('user_unique_email', 'user_accounts', 'email', true);
    }   

    public function down()
    {
        $this->dropTable('user_accounts');
        return true;
    }
    
 
}
