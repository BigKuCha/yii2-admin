<?php
/**
 * Created by PhpStorm.
 * User: olebar
 * Date: 2014/10/22
 * Time: 16:30:15
 */

namespace backend\controllers;

use common\components\MyHelper;
use kartik\widgets\ActiveForm;
use Yii;
use backend\models\TMenu;
use yii\db\Query;
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
        $this->defaultAction;
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

        //需改为循环删除
        if($level==1)
        {
            $son = TMenu::find()->where(['parentid'=>$id])->column();
            TMenu::deleteAll(['parentid'=>$son]);//删除孙子
            TMenu::deleteAll(['parentid'=>$id]);//删除儿子
        }
        if($level==2)
            TMenu::deleteAll(['parentid'=>$id]);//删除儿子
        //删除自身
        TMenu::findOne($id)->delete();
        Yii::$app->session->setFlash('success');
        return $this->redirect(['sys/menu']);
    }

    public function actionTest()
    {
        $sql = "select name from auth_item where name not in (select route from t_menu)";
        $x = Yii::$app->db->createCommand($sql)->queryAll();
        foreach($x as $v )
        {
            Yii::$app->authManager->remove(Yii::$app->authManager->getPermission($v));
        }
        return MyHelper::dump($x);
        $x = TMenu::find()->where(['parentid'=>1,'level'=>2])->column();
        $x = TMenu::find()->where(['parentid'=>$x])->all();
        return MyHelper::dump($x);
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