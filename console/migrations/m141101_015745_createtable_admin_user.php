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
        ], $tableOptions);
        $sql = "INSERT INTO `t_adm_user` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$13$EHPdK7.j6sAJyxurOQ0IJOR3/.2T1iU8wTbqfRDILY2xZbapuD8zq'),
(2, 'demo', '$2y$13$BLO2fX2gXESpt9THvNNr5eyU2vRMptAIp0tgUA8TkUn254SDfpRKu');";
        $this->execute($sql);
    }

    public function down()
    {
        echo "m141101_015745_createtable_admin_user cannot be reverted.\n";

        return false;
    }
}
