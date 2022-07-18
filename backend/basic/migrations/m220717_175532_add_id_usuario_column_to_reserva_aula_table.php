<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%reserva_aula}}`.
 */
class m220717_175532_add_id_usuario_column_to_reserva_aula_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%reserva_aula}}', 'id_usuario', $this->integer());
        $this->addForeignKey(
            'fk-reserva_aula-id_usuario',
            'reserva_aula',
            'id_usuario',
            'usuario',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
