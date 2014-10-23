<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "t_menu".
 *
 * @property integer $id
 * @property string $menuname
 * @property integer $parentid
 * @property string $route
 * @property string $menuicon
 * @property integer $level
 */
class TMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menuname','route'], 'required'],
            ['route','unique'],
            [['parentid', 'level'], 'integer'],
            [['menuname', 'route'], 'string', 'max' => 32],
            [['menuicon'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menuname' => '菜单名称',
            'parentid' => '父类ID',
            'route' => '路由',
            'menuicon' => '图标',
            'level' => '级别',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $auth = Yii::$app->authManager;
        if($insert)
        {
            $permission = $auth->createPermission($this->route);
            $permission->description = $this->menuname;
            $auth->add($permission);
        }else
        {
            $permission = $auth->getPermission($changedAttributes['route']);
            $permission->name = $this->route;
            $permission->description = $this->menuname;
            $auth->update($changedAttributes['route'],$permission);
        }

    }

    public function afterDelete()
    {
        parent::afterDelete();
        //删除所有权限
        $sql = 'select name from auth_item where name not in (select route from t_menu)';
        $p = Yii::$app->db->createCommand($sql)->query();
        $auth = Yii::$app->authManager;
        foreach($p as $name)
        {
            $auth->remove($auth->getPermission($name));
        }
    }
    /**
     * 获取子菜单
     * @return static
     */
    public function getSon()
    {
        return $this->hasMany(TMenu::className(),['parentid'=>'id'])->orderBy('level desc');
    }
}
