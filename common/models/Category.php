<?php
/**
 * 文件名：Category.php
 * 文件说明:
 * 时间: 2016/10/24.13:23
 */

namespace common\models;

use common\components\Tree;
use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%category}}';
    }
    
    public static function allCategories()
    {
        return self::find()->asArray()->all();
        
    }
    
    public static function treeComponent()
    {
        $cates=self::allCategories();
        $component=\Yii::createObject([
            'class'=>Tree::className(),
            'list'=>$cates,
            'options'=>[
                '_sk'=>'cate_id',
                '_pk'=>'cate_pid',
            ]
        ]);
        return $component;
    }
    
    public static function sort($pid=0,$level=0,$html='-')
    {
        $component=self::treeComponent();
        return $component->sort($pid,$level,$html);
    }
//找子节点
    public static function sons($id,$type=true,$flag=true)
    {
        $component=self::treeComponent();
        if($flag)//返回不带自身的数组
            return $component->sons($id);
        else//返回带自身的数组
        {
            $cate=self::categoryById($id);
            $arr=$component->sons($id);
            array_unshift($arr,$cate);
            return $arr;
        }
    }
    //返回所有上级节点，包含自身
public static function parents($id,$type=true,$reverse=true)
{
    $component=self::treeComponent();
    return $reverse?array_reverse($component->parents($id)):$component->parents($id);
}
    //根据主键获取分类
    public static function categoryById($id)
    {
        $temp=self::findOne($id);
        $arr['cate_id']=$id;
        $arr['cate_name']=$temp->cate_name;
        $arr['cate_pid']=$temp->cate_pid;
        return $arr;
    }
    
    public static function tree($son='son')
    {
        $component=self::treeComponent();
        return $component->tree($son);
    }
}