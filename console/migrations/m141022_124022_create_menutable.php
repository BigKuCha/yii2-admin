<?php

use yii\db\Schema;
use yii\db\Migration;

class m141022_124022_create_menutable extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%t_menu}}', [
            'id' => Schema::TYPE_PK,
            'menuname' => Schema::TYPE_STRING . '(32) NOT NULL',
            'parentid'=> Schema::TYPE_SMALLINT .' NOT NULL DEFAULT 0',
            'route' => Schema::TYPE_STRING . '(32)  NULL',
            'menuicon' => Schema::TYPE_STRING . '(16) NOT  NULL DEFAULT "icon-book"',

            'level' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1',
        ], $tableOptions);
    }

    public function down()
    {
        echo "m141022_124022_create_menutable cannot be reverted.\n";

        return false;
    }
}
