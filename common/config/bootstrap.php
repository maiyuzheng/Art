<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

/**
 * [dd 格式化var_dump]
 * @param  [mixed] $var [description]
 * @return [null]       [description]
 */
function dd($var)
{
    $arr=debug_backtrace();
    echo "<div style='border:1px dotted black;'>";
    if($arr)
    {
        echo "文件名：".$arr[0]['file']."<br>";
        echo "文件行号:".$arr[0]['line']."<br>";
    }
    echo "</div>";
    if(is_array($var)||is_object($var))
    {
        echo "<pre><div style='border:1px solid black;color:red'>-----------调试信息开始---------<br>";
        print_r($var);
        echo "-----------调试信息结束---------</div></pre>";
    }
    else
    {
        echo "<pre><div style='border:1px solid black;color:black'>-----------调试信息开始---------<br>";
        var_dump($var);
        echo "-----------调试信息结束---------</div></pre>";
    }
}

