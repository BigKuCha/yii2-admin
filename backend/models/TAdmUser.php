<?php

namespace backend\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "t_adm_user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 */
class TAdmUser extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $password_repeat;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_adm_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username','unique'],
            [['username', 'password','password_repeat'], 'required'],
            [['username', 'password'], 'string', 'max' => 255],
            ['password_repeat','compare','compareAttribute'=>'password']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'password' => '密码',
            'password_repeat'=>'重复密码'
        ];
    }
    public function beforeSave($insert)
    {
        if($this->isNewRecord || $this->password!=$this->oldAttributes['password'])
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
        return true;
    }
    public static function findByusername($username)
    {
        return static::find()->where('username=:u',[':u'=>$username])->one();
    }

    public  function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password,$this->password);
    }
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getAuthKey()
    {
        return md5($this->id);
    }
    public function validateAuthKey($authKey)
    {
        return $authKey===$this->getAuthKey();
    }
}