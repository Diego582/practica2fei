<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property int $id
 * @property string $username
 * @property string $name
 * @property string $apellido
 * @property string $email
 * @property string|null $password
 * @property string|null $profile_photo_path
 * @property string|null $password_hash
 * @property string|null $access_token
 */
class Usuario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'name', 'apellido', 'email'], 'required'],
            [['username', 'name', 'apellido'], 'string', 'max' => 128],
            [['email', 'password'], 'string', 'max' => 255],
            [['profile_photo_path'], 'string', 'max' => 2048],
            [['password_hash'], 'string', 'max' => 512],
            [['access_token'], 'string', 'max' => 1024],
            [['email'], 'unique'],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'name' => 'Name',
            'apellido' => 'Apellido',
            'email' => 'Email',
            'password' => 'Password',
            'profile_photo_path' => 'Profile Photo Path',
            'password_hash' => 'Password Hash',
            'access_token' => 'Access Token',
        ];
    }

    /**
     * {@inheritdoc}
     * @return UsuarioQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsuarioQuery(get_called_class());
    }
}
