<?php

namespace app\modules\apiv1\controllers;

use app\modules\apiv1\models\LoginForm;
use app\modules\apiv1\models\SignupForm;
use yii\rest\Controller;
use Yii;
use yii\filters\Cors;

/**
 * Default controller for the `apiv1` module
 */
class UsuarioController extends Controller
{
    /* public $modelClass = 'app\modules\apiv1\models\Usuario'; */

    public function actionLogin()
    {

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->login()) {
            return $model->getUsuario();
        }

        Yii::$app->response->statusCode = 422;
        return [
            'errors' => $model->errors
        ];
    }

    public function actionSignup()
    {

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->register()) {
            return $model->_usuario;
        }

        Yii::$app->response->statusCode = 422;
        return [
            'errors' => $model->errors
        ];
    }

}
