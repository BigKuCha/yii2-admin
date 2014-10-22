<?php
/**
 * Created by PhpStorm.
 * User: olebar
 * Date: 2014/10/22
 * Time: 16:30:15
 */

namespace backend\controllers;


class SysController extends BackendController
{
    /**
     * 菜单管理
     * @return string
     */
    public function actionMenu()
    {
        return $this->render('menu',[

        ]);
    }
} 