<?php
/**
 * Created by PhpStorm.
 * User: olebar
 * Date: 2014/10/22
 * Time: 16:30:15
 */

namespace backend\controllers;

use kartik\widgets\ActiveForm;
use Yii;
use backend\models\TMenu;
use yii\web\Response;

class SysController extends BackendController
{
    /**
     * 菜单管理
     * @return string
     */
    public function actionMenu()
    {
        $list = TMenu::find()->where('level=1')->all();
        return $this->render('index', [
            'list' => $list,
        ]);
    }

    /**
     * 添加新菜单
     * @return string|Response
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new TMenu;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success');
            return $this->redirect(['sys/menu']);
        } else {
            $model->loadDefaultValues();
            $model->parentid = $request->get('pid', 0);
            $model->level = $request->get('level', 0) + 1;
            return $this->render('create', [
                'model'  => $model,
                'plevel' => $request->get('level', 0)
            ]);
        }
    }

    /**
     * 更新菜单
     * @param $id
     * @return string|Response
     */
    public function actionUpdate($id)
    {
        $model = TMenu::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success');
            return $this->redirect(['sys/menu']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 删除菜单
     * @return Response
     * @throws \Exception
     */
    public function actionMenudel()
    {
        $id = Yii::$app->request->get('id');
        $level = Yii::$app->request->get('level');
        //循环删除是为了在afterDelete删除对应的permission
        //一级菜单先删除孙子节点
        if ($level == 1) {
            $son = TMenu::find()->where(['parentid' => $id, 'level' => 2])->all();
            foreach ($son as $s) {
                $gsons = TMenu::find()->where(['parentid' => $s->id])->all();
                foreach ($gsons as $g) {
                    $g->delete();
                }
            }
        }
        //一二级菜单删除儿子节点
        if ($level <= 2) {
            $son = TMenu::find()->where(['parentid' => $id])->all();
            foreach ($son as $s) {
                $s->delete();
            }
        }
        //删除自身
        TMenu::findOne($id)->delete();
        Yii::$app->session->setFlash('success');
        return $this->redirect(['sys/menu']);
    }

    /**
     * Ajax 验证菜单名称
     * @return array
     */
    public function actionAjaxvalidate()
    {
        if ($id = Yii::$app->request->post('id')) {
            $model = TMenu::findOne($id);
        } else {
            $model = new TMenu();
        }
        if (Yii::$app->request->isAjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model, 'menuname');
        }
    }
}