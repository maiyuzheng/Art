<?php
/**
 * 文件名：AddViews.php
 * 文件说明://定义一个增加浏览次数的行为
 * 时间: 2016/10/24.16:16
 */

namespace common\behaviors;

use yii\base\Behavior;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;

class AddViews extends AttributeBehavior
{
    public $field;
    function init()
    {
        parent::init();
        if (empty($this->attributes)) {
            $this->attributes = [
                ActiveRecord::EVENT_AFTER_FIND => $this->field,
            ];
        }
    }
    protected function getValue($event)
    {
        $field=$this->field;
        if ($this->value === null) {
            return $event->sender->$field+1;
        }
        return parent::getValue($event);
    }

}