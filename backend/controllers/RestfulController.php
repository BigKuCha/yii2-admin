<?php
/**
 * Created by PhpStorm.
 * User: olebar
 * Date: 2014/11/5
 * Time: 17:22:45
 */

namespace backend\controllers;

use Yii;
use yii\rest\ActiveController;


class RestfulController extends ActiveController
{
    public $modelClass = 'backend\models\TAdmUser';
}