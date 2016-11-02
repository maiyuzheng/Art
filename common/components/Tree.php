<?php
/**
 * 文件名：Tree.php
 * 文件说明:
 * 时间: 2016/10/24.13:06
 */

namespace common\components;

use yii\base\Component;
use yii\helpers\ArrayHelper;

class Tree extends Component
{
    public $_sk;
    public $_pk;
    //id => pid 数组
    public  $_sp_list = [];
    public $list=[];
    protected $_options=[];
    public $options=[];
    public function init()
    {
       parent::init();
        $this->_options=[
            '_sk'=>'id',
            '_pk'=>'pid',
        ];
        $this->options=ArrayHelper::merge($this->_options,$this->options);
        $this->_sk=$this->options['_sk'];
        $this->_pk=$this->options['_pk'];

        $cat_list=$this->list;
        if (empty($cat_list))
        {
            return false;
        }
        $this->list=[];
        //对数组进行预处理
        foreach ($cat_list as $key => $val)
        {
            //生成sid => pid 数组
            $this->_sp_list[$val[$this->_sk]] = $val[$this->_pk];
            //以数组的子分类值作为索引
            $this->list[$val[$this->_sk]] = $val;
        }
         unset($cat_list);
    }


    /**
     * 获取格式化的树形数据
     * @param $pid int $list中顶级分类id
     * @param $level int $list中顶级分类的层级
     * @param $html string 上下层级之间的标示符号
     * @return mixed
     **/
//       public  function sort($pid = 0, $level = 0, $html = '-')
//    {
//        if (empty($this->list))
//        {
//            return false;
//        }
//        static $tree = array();
//        foreach ($this->list as $v)
//        {
//            if ($v[$this->_pk] == $pid)
//            {
//                $v['sort'] = $level + 1;
//                $v['html'] = str_repeat($html, $level);
//                $tree[$v[$this->_sk]] = $v;
//                self::sort($v[$this->_sk], $level + 1);
//            }
//        }
//        return $tree;
//    }

    /**
     * 获取分类的无限极子分类，以树型结构显示
     * @param $son string 子节点节点名
     * @return mixed
     **/
    public  function tree($son = 'son')
    {
        if (empty($this->list))
        {
            return false;
        }
        $list = $this->list;
        foreach ($list as $item)
        {
            $list[$item[$this->_pk]][$son][$item[$this->_sk]] = &$list[$item[$this->_sk]];
        }
        return isset($list[0][$son]) ? $list[0][$son] : array();
    }

    /**
     * 获取分类的祖先分类
     * @param $id int 分类id
     * @param $type bool true-返回祖先分类数组 false-返回祖先分类id
     * @return mixed
     **/
    public  function ancestor($id, $type = true)
    {
        if (empty($this->list) || empty($this->_sp_list))
        {
            return false;
        }
        while ($this->_sp_list[$id])
        {
            $id = $this->_sp_list[$id];
        }
        return $type && isset($this->list[$id]) ? $this->list[$id] : $id;
    }

    /**
     * 获取所有父级分类对应层级关系
     * @param $id int 分类id
     * @param $type bool true-返回分类数组 false-返回分类id
     * @return mixed
     **/
    public  function parents($id, $type = true)
    {
        if (empty($this->list))
        {
            return false;
        }
        $info = [];
        while (isset($this->_sp_list[$id]))
        {
            $info[] = $type ? $this->list[$id] : $id;
            $id = $this->_sp_list[$id];
        }
        return $info;
    }

    /**
     * 获取所有子级分类对应层级关系
     * @param $id int 子分类id
     * @param $type bool true-返回分类数组 false-返回分类id
     * @return mixed
     **/
    public  function sons($id, $level=0, $html='-')
    {
        if (empty($this->list))
        {
            return false;
        }
        $info = [];
        if(!isset($this->list[$id])){
            return $info;
        }
        $temp = $this->list[$id];
        $temp['sort'] = $level;
        $temp['html'] = str_repeat($html, $level);
        $info[$id] = $temp;
        $info = ArrayHelper::merge($info,self::sort($id,$level+1,$html))  ;
        return $info;
    }


    /**
     * 获取格式化的树形数据
     * @param $pid int $list中顶级分类id
     * @param $level int $list中顶级分类的层级
     * @param $html string 上下层级之间的标示符号
     * @return mixed
     **/
    public  function sort($pid = 0, $level = 0, $html = '-')
    {
        $tree = array();
        if (empty($this->list))
        {
            return $tree;
        }

        foreach ($this->list as $v)
        {
            if ($v[$this->_pk] == $pid)
            {
                $v['sort'] = $level ;
                $v['html'] = str_repeat($html, $level);
                $tree[$v[$this->_sk]] = $v;
                $tree = ArrayHelper::merge($tree,self::sort($v[$this->_sk], $level + 1, $html))  ;
            }
        }
        return $tree;
    }



    /**
     * 获取所有子级分类对应层级关系
     * @param $id int 子分类id
     * @param $type bool true-返回分类数组 false-返回分类id
     * @return mixed
     **/
//    public  function sons($id, $type = true)
//    {
//        if (empty($this->list))
//        {
//            return false;
//        }
////    static $info = [];
//        $info = [];
//        foreach ($this->list as $val)
//        {
//            if ($val[$this->_pk] == $id)
//            {
//                $info[$val[$this->_sk]] = $type ? $val : $val[$this->_sk];
//                if (self::has_son($val[$this->_sk]))
//                {
//                    self::sons($val[$this->_sk], $type);
//                }
//            }
//        }
//        return $info;
//    }

    /**
     * 获取所有儿子分类
     * @param $p_id int 父id
     * @param $type bool true-返回分类数组 false-返回分类id
     * @return mixed
     **/
    public  function son($p_id = 0, $type = true)
    {
        if (empty($this->list))
        {
            return false;
        }
        $_arr = [];
        foreach ($this->list as $val)
        {
            if ($val[$this->_pk] == $p_id)
            {
                $_arr[$val[$this->_sk]] = $type ? $val : $val[$this->_sk];
            }
        }
        return $_arr;
    }

    /**
     * 是否含有子分类，是否是叶子节点
     * @param $pid int 父分类id
     * @return mixed
     **/
    public function has_son($pid)
    {
        if (empty($this->list) || empty($this->_sp_list))
        {
            return false;
        }
        return in_array($pid, array_values($this->_sp_list));
    }

}