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
        return $this->render('menu',[
            'list'=>$list,
        ]);
    }
    /*
     * 添加/修改菜单
     */
    public function actionMenumange()
    {
        $params = Yii::$app->request->get();
        if($id = $_REQUEST['id'])
            $model = TMenu::findOne($id);
        else
        {
            $model = new TMenu();
            $model->loadDefaultValues();
            $model->parentid = $params['pid'];
            $model->level = $params['level']+1;
        }
        if(Yii::$app->request->isPost)
        {
            $model->load(Yii::$app->request->post());
            if($model->save())
            {
                Yii::$app->session->setFlash('success');
                return $this->redirect(['sys/menu']);
            }
        }
        return $this->render('menumange',[
            'model'=>$model,
            'plevel'=>$params['level']
        ]);
    }

    public function actionMenudel()
    {
        $id = Yii::$app->request->get('id');
        $level = Yii::$app->request->get('level');
        //循环删除是为了在afterDelete删除对应的permission
        //一级菜单先删除孙子节点
        if($level==1)
        {
            $son = TMenu::find()->where(['parentid'=>$id,'level'=>2])->all();
            foreach($son as $s)
            {
                $gsons = TMenu::find()->where(['parentid'=>$s->id])->all();
                foreach($gsons as $g)
                {
                    $g->delete();
                }
            }
        }
        //一二级菜单删除儿子节点
        if($level<=2)
        {
            $son = TMenu::find()->where(['parentid'=>$id])->all();
            foreach($son as $s)
            {
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
        if($id = Yii::$app->request->post('id'))
            $model = TMenu::findOne($id);
        else
            $model = new TMenu();
        if(Yii::$app->request->isAjax)
        {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model,'menuname');
        }
    }
}