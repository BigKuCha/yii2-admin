Yii2开发的后台管理系统
===================================

用Yii2.0.0开发的后台管理系统.通过RBAC控制不同用户的菜单显示以及权限。


安装
------------

1.  直接运行`git clone https://github.com/BigKuCha/yga.git`克隆到工作目录，或者直接下载zip包
2.  运行`composer update --prefer-dist` 安装yii2核心文件
3.  创建数据库 `nevermore` 编码 `utf8-unicode-ci`
4.  在项目根目录下运行`init` 初始化项目(生成入口脚本、创建runtime目录等)
5.  删除`common/config/main-local.php`里的db配置(采用`common/config/db.php`里的就可以)
5.  运行`yii migrate`导入菜单表`t_menu`和用户表`t_admin_user`
6.  运行`yii migrate --migrationPath=@yii/rbac/migrations/`导入Yii官方提供的权限控制表

配置
-------------

###  Apache
开启apache的rewite模块，网站根目录指向`web/`  
**NOTE:** 如果不开启rewite，需要重新配置路由

图示
------------
![image](https://github.com/BigKuCha/yga/blob/master/tests/img/demo1.jpg)
![image](https://github.com/BigKuCha/yga/blob/master/tests/img/demo2.png)
![image](https://github.com/BigKuCha/yga/blob/master/tests/img/demo3.png)

------------

### 关于Yii2
Yii官方网站 [yiiframework.com](http://www.yiiframework.com)  
Yii2仓库地址[yiisoft/yii2](https://github.com/yiisoft/yii2)
