<?php

use yii\db\Schema;
use yii\db\Migration;

class m141101_015745_createtable_admin_user extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%t_adm_user}}', [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . '(64) NOT NULL',
            'password' => Schema::TYPE_STRING . '(64) NOT NULL',
            'userphoto' => Schema::TYPE_STRING . '(64) NOT NULL',
        ], $tableOptions);
        $pw1 = Yii::$app->security->generatePasswordHash('admin');
        $pw2 = Yii::$app->security->generatePasswordHash('demo');
        $sql = "INSERT INTO `t_adm_user` (`id`, `username`, `password`) VALUES
(1, 'admin', '$pw1'),
(2, 'demo', '$pw2');";
        $this->execute($sql);
    }

    public function down()
    {
        echo "m141101_015745_createtable_admin_user cannot be reverted.\n";

        return false;
    }
}
