<?php

use yii\db\Migration;

/**
 * Class m220603_145551_album
 */
class m220603_145551_album extends Migration
{
    public function up()
    {
        $this->createTable('album', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull()
        ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB' : null);
        
        $this->createIndex('idx-album-user', 'album', 'user_id');
        $this->addForeignKey('album_user_ibfk_1', 'album', 'user_id', 'user', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('album_catalog_ibfk_1', 'album');
        $this->dropIndex('idx-album-catalog', 'album');
        
        $this->dropTable('album');
    }
}