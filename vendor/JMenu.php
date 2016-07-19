<?php
namespace admin\modules\jrbac\vendor;

use \common\models\AdminMenu as Menu;

class JMenu
{
    private static $instance;
    public static function getInstance()
    {
        if(empty(self::$instance)) self::$instance = new self();
        return self::$instance;
    }
    //jrbac模块中的样式前缀
    public $iconPrefix = 'glyphicon glyphicon-'; //bootstrap.css 可修改为font-awesome字体,$icons列表中为公共样式

    public $icons = [
                'record','cog','share','user','plus','dashboard','home','trash','wrench','lock',
                'star','heart','tags','bookmark','book','paperclip','pushpin','filter','edit','refresh',
                'list','tint','play','leaf','fire','bell','wrench','flash','tasks','globe'
            ];
    public $defaultIcon = 'record';
    public function getMenuIconOptionItems()
    {
        $iconArray = [];
        foreach ($this->icons as $icon) {
            $iconArray[$icon] = '<i class="'.$this->iconPrefix.$icon.'">&nbsp;&nbsp;</i>';
        }
        return $iconArray;
    }
    
    
    public function getMenu()
    {
        return $this->getItems(0);
    }

    public function getItems($pid = 0)
    {
        $query = Menu::find()->where('`status`=1 and `pid`=:pid',[
            ':pid'=>$pid
        ])->orderBy('`sortorder` asc');
        $items = $query->asArray()->all();
        $list = [];
        foreach($items as $k=>$item) {
            if($this->checkAllow($item['url'])) {
                $list[$k]['label'] = $item['label'];
                $list[$k]['url'] = [$item['url']];
                $list[$k]['icon'] = $this->iconPrefix.(isset($item['icon']) && $item['icon'] ? $item['icon'] : $this->defaultIcon);
                $sub = $this->getItems($item['id']);
                if($sub) {
                    $list[$k]['items'] = $sub;
                } else if(in_array($item['url'],['/','#'])) {
                    unset($list[$k]);
                }
            }
        }
        return $list;
    }

    public function getOptionList($pid = 0,$level = 0,$depth=0)
    {
        $query = Menu::find()->where('`status`=1 and `pid`=:pid',[
            ':pid'=>$pid
        ])->orderBy('`sortorder` asc');
        $items = $query->asArray()->all();
        $list = [];
        $subPrefix = '';
        for($i = 0; $i<$level; $i++) {
            $subPrefix .= '--';
        }
        foreach($items as $k=>$item) {
            $list[] = [
                'id' => $item['id'],
                'label' => $subPrefix.$item['label']
            ];
            if (!$depth || ($level+1)<$depth) {
                $sub = $this->getOptionList($item['id'],$level+1,$depth);
                foreach($sub as $subItem) {
                    $list[] = $subItem;
                }
            }
        }
        return $list;
    }

    public function getPidFilter($pid = 0,$level = 0)
    {
        $pMenuItems = $this->getOptionList($pid,$level);
        $pMenuList = [];
        foreach($pMenuItems as $item) {
            $pMenuList[$item['id']] = $item['label'];
        }
        return $pMenuList;
    }

    public function checkAllow($url)
    {
        if(\Yii::$app->getAuthManager()->isRoot()) return true;
        $urlArr = explode('/',$url);
        $user = \Yii::$app->getUser();
        if(count($urlArr) == 4) {
            $tm = $urlArr[1];
            $tc = $urlArr[2];
            if($user->can("/$tm/*/*") || $user->can("/$tm/$tc/*")) return true;
        } else if(count($urlArr) == 3) {
            $tc = $urlArr[1];
            if($user->can("/$tc/*")) return true;
        }
        return $user->can($url);
    }

}