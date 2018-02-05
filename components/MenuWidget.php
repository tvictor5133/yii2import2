<?php

namespace app\components;

use app\models\Param;
use yii\base\Widget;
use app\models\Category;
use app\models\Product;
use Yii;

class MenuWidget extends Widget{

    public $data;
    public $model;
    public $tree;
    public $table;
    public $menu_html;

    public function init(){
        parent::init();
        switch($this->table){
            case 'category':
                $this->data = Category::find()->indexBy('id')->asArray()->all();
                break;
            case 'product':
                $this->data = Product::find()->indexBy('id')->asArray()->all();
                break;
            case 'param':
                $this->data = Param::find()->indexBy('id')->asArray()->all();
                break;
        }
    }

    public function run(){
        $this->tree = $this->getTree();
        $this->menu_html = $this->getMenuHtml($this->tree);
        return $this->menu_html;
    }

    protected function getTree(){
        $tree = [];
        if (is_array($this->data))
            foreach($this->data as $id=>&$node){
                if (isset($node['parent_id'])){
                    if (!$node['parent_id'])
                        $tree[$id] = &$node;
                    else
                        $this->data[$node['parent_id']]['childs'][$node['id']] = &$node;
                } else $tree[$id] = &$node;

            }
        return $tree;
    }

    protected function getMenuHtml($tree, $tab = ''){
        $str = '';
        foreach($tree as $category)
            $str .= $this->catToTemplate($category, $tab);
        return $str;
    }

    protected function catToTemplate($category, $tab){
        ob_start();
        include __DIR__ . '/tpl/select.php';
        return ob_get_clean();
    }
}