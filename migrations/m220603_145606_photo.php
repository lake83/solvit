<?php

use yii\db\Migration;

/**
 * Class m220603_145606_photo
 */
class m220603_145606_photo extends Migration
{
    public function up()
    {
        $this->createTable('photo', [
            'id' => $this->primaryKey(),
            'album_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'url' => $this->string()->notNull()
        ], $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB' : null);
        
        $this->createIndex('idx-photo-album', 'photo', 'album_id');
        $this->addForeignKey('photo_album_ibfk_1', 'photo', 'album_id', 'album', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('photo_catalog_ibfk_1', 'photo');
        $this->dropIndex('idx-photo-catalog', 'photo');
        
        $this->dropTable('photo');
    }
}