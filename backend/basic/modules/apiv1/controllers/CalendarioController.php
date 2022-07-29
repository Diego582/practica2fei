<?php

namespace app\modules\apiv1\controllers;

use app\modules\apiv1\models\Calendario;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

/**
 * Default controller for the `apiv1` module
 */
class CalendarioController extends BaseController
{
    public $modelClass = Calendario::class;



    /* public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['authMethods'] = [HttpBearerAuth::class];
        return $behaviors;
    } */
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }
    public function actionIndex()
    {
        $activeData = new ActiveDataProvider([
            'query' => Calendario::find(),
            'pagination' => false,
        ]);
        return $activeData;
    }
}
