<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reserva_aula".
 *
 * @property int $id
 * @property int $id_aula
 * @property string|null $fh_desde
 * @property string|null $fh_hasta
 * @property string|null $observacion
 * @property int|null $id_usuario
 *
 * @property Aula $aula
 * @property HorarioMateria[] $horarioMaterias
 * @property Usuario $usuario
 */
class ReservaAula extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reserva_aula';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_aula'], 'required'],
            [['id_aula', 'id_usuario'], 'default', 'value' => null],
            [['id_aula', 'id_usuario'], 'integer'],
            [['fh_desde', 'fh_hasta'], 'safe'],
            [['observacion'], 'string'],
            [['id_aula'], 'exist', 'skipOnError' => true, 'targetClass' => Aula::class, 'targetAttribute' => ['id_aula' => 'id']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['id_usuario' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_aula' => 'Id Aula',
            'fh_desde' => 'Fh Desde',
            'fh_hasta' => 'Fh Hasta',
            'observacion' => 'Observacion',
            'id_usuario' => 'Id Usuario',
        ];
    }

    /**
     * Gets query for [[Aula]].
     *
     * @return \yii\db\ActiveQuery|AulaQuery
     */
    public function getAula()
    {
        return $this->hasOne(Aula::class, ['id' => 'id_aula']);
    }

    /**
     * Gets query for [[HorarioMaterias]].
     *
     * @return \yii\db\ActiveQuery|HorarioMateriaQuery
     */
    public function getHorarioMaterias()
    {
        return $this->hasMany(HorarioMateria::class, ['id_reserva' => 'id']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery|UsuarioQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'id_usuario']);
    }

    /**
     * {@inheritdoc}
     * @return ReservaAulaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReservaAulaQuery(get_called_class());
    }
}
