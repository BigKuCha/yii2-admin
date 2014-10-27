<?php
/**
 *	  ┏┓　　　┏┓
 *	┏┛┻━━━┛┻┓
 *	┃　　　　　　　┃
 *	┃　　　━　　　┃
 *	┃　┳┛　┗┳　┃
 *	┃　　　　　　　┃
 *	┃　　　┻　　　┃
 *	┃　　　　　　　┃
 *	┗━┓　　　┏━┛
 *	    ┃　　　┃   神兽保佑
 *	    ┃　　　┃   代码无BUG！
 *	 	 ┃　　　┗━━━┓
 *	    ┃　　　　　　　┣┓
 *	    ┃　　　　　　　┏┛
 *	    ┗┓┓┏━┳┓┏┛
 *	      ┃┫┫　┃┫┫
 *	      ┗┻┛　┗┻┛
 */ 

namespace common\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
class MyHelper
{
    /**
     * 打印数组
     * @param type $vars 要打印的数组
     * @param type $label 标注
     * @param type $return 是否断点
     * @return string|null
     */
    public static function dump($vars, $label = '', $return = false)
    {
        if (ini_get('html_errors'))
        {
            $content = "<pre>\n";
            if ($label != '')
                $content .= "<strong>{$label} :</strong>\n";
            $content .= htmlspecialchars(print_r($vars, true));
            $content .= "\n</pre>\n";
        } else
            $content = $label . " :\n" . print_r($vars, true);
        if ($return)
            return $content;
        echo $content;
        return null;
    }
    /**
     * /获取utf8单个字符字节数
     * @param type $str
     * @param type $startpos
     * @return int
     */
    public static function utf8strcount($str,$startpos=0)
    {
        $c = substr($str,$startpos,1);
        if(ord($c)<0x80)
            return 1;
        else
        {
            if((ord($c)|0x1f)==0xdf)
                return 2;
            else
            {
                if((ord($c)|0xf)==0xef)
                    return 3;
                else
                {
                    if((ord($c)|0x7)==0xf7)
                        return 4;
                    else
                        return 0;
                }
            }
        }
    }
    /**
     * 按字符宽度截取utf8字符串，返回 "字符.."
     * @param type $in
     * @param type $num
     * @param type $endstr
     * @return string
     */
    public static function SubstrUTF8($in,$num,$endstr="...")
    {
        $pos = 0;
        $strnum = 0;
        $parity = 0;
        $out = "";
        while($pos<strlen($in))
        {
            $count = static::utf8strcount($in,$pos);
            if($count >0 )
            {
                if($count == 1)
                    $parity++;
                else
                    $parity+=2;
                if($parity/2 >= $num)
                {
                    $out .= $endstr;
                    break;
                }
                $c=substr($in,$pos,$count);
                //遇到回车符跳出
                if($c=="\n" or $c=="\r")
                    $c = " ";
                $out.=$c;
                $pos += $count;
            }
            else
                break;
        }
        return $out;
    }
    /**
     * 导出csv
     * @param $recordset 要导出的数据
     * @param string $reportname 生成的csv名称
     * @param $titlelist 标题
     * @return string
     */
    public static function  csvput(array $recordset, $reportname="",array $titlelist)
    {
        $keylist = array_keys($titlelist);
        $tmpfield = array();
        foreach($keylist as $k=>$val){
            $tmpfield[] = iconv("UTF-8", "GB18030", $titlelist[$val]);
        }
        $cpfield = $tmpfield;
        $path = \Yii::getAlias('@backend/web').'/tmp/'.Date('Ymd').'/';
        if(!file_exists($path))
            mkdir($path, 0777, true);
        $uploadfile = $path."report_".$reportname."_".Date('YmdHis').".csv";
        $fp = fopen($uploadfile, 'w');
        fputcsv($fp, $cpfield);
        foreach ($recordset as $k=>$v)
        {
            $tmpfield = array();
            for($ki=0;$ki<count($keylist);$ki++)
            {
                $key = $keylist[$ki];
                $tmpfield[] = iconv("UTF-8", "GB18030", $recordset[$k][$key]);
            }
            $cpfield = $tmpfield;
            fputcsv($fp, $cpfield);
        }
        fclose($fp);
        return $uploadfile;
    }

    public static function actionbutton($url,$type='update',$options=[])
    {
        if ($type=='view') {
            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ArrayHelper::merge([
                'title' => Yii::t('yii', 'View'),
                'data-pjax' => '0',
            ],$options));
        }
        if ($type=='update') {
            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ArrayHelper::merge([
                'title' => Yii::t('yii', 'Update'),
                'data-pjax' => '0',
            ],$options));
        }
        if ($type=='delete') {
            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ArrayHelper::merge([
                'title' => Yii::t('yii', 'Delete'),
                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'data-method' => 'post',
                'data-pjax' => '0',
            ],$options));
        }
    }
}