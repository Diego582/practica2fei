<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "usuario".
 *
 * @property int $id
 * @property string $username
 * @property string $name
 * @property string $apellido
 * @property string $email
 * @property string|null $profile_photo_path
 * @property string|null $password_hash
 * @property string|null $access_token
 */
class Usuario extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%usuario}}';
    }

   
   /*  public function rules()
    {
        return [
            [['username', 'name', 'apellido', 'email'], 'required'],
            [['username', 'name', 'apellido'], 'string', 'max' => 128],
            [['email'], 'string', 'max' => 255],
            [['profile_photo_path'], 'string', 'max' => 2048],
            [['password_hash'], 'string', 'max' => 512],
            [['access_token'], 'string', 'max' => 1024],
            [['email'], 'unique'],
            [['username'], 'unique'],
        ];
    }
 */
  
   /*  public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'name' => 'Name',
            'apellido' => 'Apellido',
            'email' => 'Email',
            'profile_photo_path' => 'Profile Photo Path',
            'password_hash' => 'Password Hash',
            'access_token' => 'Access Token',
        ];
    } */

    /**
     * {@inheritdoc}
     * @return UsuarioQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsuarioQuery(get_called_class());
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::find()->andWhere(['access_token' => $token])->one();
    }

    public static function findByUsername($username)
    {
        return self::find()->andWhere(['username' => $username])->one();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authkey)
    {
        return false;
    }

    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }
}
