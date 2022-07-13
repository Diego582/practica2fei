<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Usuario;
use yii\console\Controller;
use yii\helpers\Console;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppController extends Controller
{
    public function actionAddUser($username,$name,$apellido,$email, $password)
    {
        $security = \Yii::$app->security;

        $usuario = new Usuario();
        $usuario->username = $username;
        $usuario->name = $name;
        $usuario->apellido = $apellido;
        $usuario->email = $email;
        $usuario->password_hash = $security->generatePasswordHash($password);
        $usuario->access_token = $security->generateRandomString(255);

        if ($usuario->save()) {
            Console::output("Guardado");
        } else {
            var_dump($usuario->errors);
            Console::output("No guardado");
        }
    }
}
