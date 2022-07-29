<?php

namespace app\modules\apiv1\controllers;

use app\modules\apiv1\models\CalendarioReserva;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

/**
 * Default controller for the `apiv1` module
 */
class CalendarioreservaController extends BaseController
{
    public $modelClass = CalendarioReserva::class;

    /*  public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['authMethods'] = [HttpBearerAuth::class];
        return $behaviors;
    } */
}
