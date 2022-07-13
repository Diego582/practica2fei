<?php

namespace app\modules\apiv1\models;


use app\modules\apiv1\resources\UsuarioResource;

/**
 * LoginForm is the model behind the login form.
 *
 * @property UsuarioResource|null $user This property is read-only.
 *
 */
class LoginForm extends \app\models\LoginForm
{

    /**
     * @return \app\modules\apiv1\resources\UsuarioResource|UsuarioResource|bool|null
     */
    public function getUsuario()
    {
        if ($this->_usuario === false) {
            $this->_usuario = UsuarioResource::findByUsername($this->username);
        }

        return $this->_usuario;
    }
}
