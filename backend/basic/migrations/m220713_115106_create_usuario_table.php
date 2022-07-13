<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%usuario}}`.
 */
class m220713_115106_create_usuario_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%usuario}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(128)->unique()->notNull(),
            'name' => $this->string(128)->notNull(),
            'apellido' => $this->string(128)->notNull(),
            'email' => $this->string()->unique()->notNull(),
            'password' => $this->string(),
            'profile_photo_path' => $this->string(2048),
            'password_hash' => $this->string(512),
            'access_token' => $this->string(1024),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%usuario}}');
    }
}
