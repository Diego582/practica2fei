<?php

namespace app\modules\apiv1\models;

use app\modules\apiv1\resources\UsuarioResource;

/**
 * LoginForm is the model behind the login form.
 *
 * @property UsuarioResource|null $user This property is read-only.
 *
 */
class SignupForm extends LoginForm
{

    public $username;
    public $name;
    public $apellido;
    public $email;
    public $password;
    public $password_repeat;

    public $_usuario = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['username', 'unique', 'targetClass' => '\app\modules\apiv1\resources\UsuarioResource', 'message' => 'este nombre de usuario ya ha sido usado '],
            ['email', 'unique', 'targetClass' => '\app\modules\apiv1\resources\UsuarioResource', 'message' => 'esta cuenta de correo ya esta utilizadau'],
            [['username', 'name', 'apellido', 'email', 'password', 'password_repeat'], 'required'],
            ['password', 'compare', 'compareAttribute' => 'password_repeat'],
        ];
    }

    public function register()
    {
        $this->_usuario = new UsuarioResource();
        if ($this->validate()) {
            $security = \Yii::$app->security;
            $this->_usuario->username = $this->username;
            $this->_usuario->name = $this->name;
            $this->_usuario->apellido = $this->apellido;
            $this->_usuario->email = $this->email;
            $this->_usuario->password_hash = $security->generatePasswordHash($this->password);
            $this->_usuario->access_token = $security->generateRandomString(255);
            if ($this->_usuario->save()) {
                return true;
            }
            return false;
        }
        return false;
    }
}
