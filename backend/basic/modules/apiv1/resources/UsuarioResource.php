<?php

namespace app\modules\apiv1\resources;


use app\modules\apiv1\models\Usuario;

/**
 * Class UserResource
 *
 * @package app\modules\apiv1\resources
 */
class UsuarioResource extends Usuario
{
    public function fields()
    {
        return [
            'id', 'username', 'access_token', 'name', 'apellido', 'email'
        ];
    }
}
