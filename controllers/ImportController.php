<?php

namespace app\controllers;

use light\yii2\XmlParser;
use Yii;
use yii\web\Controller;
use app\models\Category;
use app\models\Product;
use app\models\Image;
use app\models\Param;
use app\models\ProductsParam;

class ImportController extends Controller{

    private $dist = 'import/';

    public function actionIndex(){
        Category::deleteAll();
        Product::deleteAll();
        Image::deleteAll();
        Param::deleteAll();
        ProductsParam::deleteAll();
        ImportController::deleteAll('images/', 0);
        $files = glob($this->dist . '/*.zip');
        if (count($files)) {
            foreach($files as $file) {
                $zip = new \ZipArchive();
                $zip->open($file);
                $zip->extractTo($this->dist . 'unzip');
                $this->parser_category_xml($this->dist . 'unzip');
                $this->parser_product_xml($this->dist . 'unzip');
                $zip->close();
                $this->deleteAll($this->dist . 'unzip');
            }
        $error = 0;
        }
        else $error = 1;
        return $this->render('index', compact('error'));
    }

    private function parser_category_xml($path){
        $file = $path . '/category.xml';
        if (!file_exists($file))
            return false;
        $categories = new \SimpleXMLElement(file_get_contents($file));
        foreach($categories as $category){
            $cat = new Category();
            $cat->id = (int) $category[0]['id'];
            $cat->parent_id = (int) $category[0]['parentId'];
            $cat->name = (string) $category[0];
            $cat->save();
        }
        return true;
    }

    private function parser_product_xml($path){
        $files = $path . '/offers_*.xml';
        foreach(glob($files) as $file){
            $product = new \SimpleXMLElement(file_get_contents($file));
            $prod = new Product();
            $prod->name = (string) $product->name;
            $prod->description = (string) $product->description;
            $prod->price = (float) $product->price;
            $prod->category_id = (int) $product->categoryId;
            $prod->currency = (string) $product->currencyId;
            $prod->url = (string) $product->url;
            $prod->save();
            $id = Yii::$app->db->getLastInsertID();
            $i = 0;
            foreach($product->pictures->picture as $picture){
                $new_name = time() . $i++ . '.jpg';
                copy($path . '/' . (string) $picture, Yii::$app->basePath . '\web\images\\' . $new_name);
                $image = new Image();
                $image->product_id = $id;
                $image->name = $new_name;
                $image->save();
            }
            foreach($product->param as $val){
                $param = new Param();
                $param->name = (string) $val->attributes()->name;
                $param->save();
                $param_id = Yii::$app->db->getLastInsertID();
                $products_param = new ProductsParam();
                $products_param->product_id = $id;
                $products_param->param_id = $param_id;
                $products_param->value = (string) $val;
                $products_param->save();
            }
        }
        return true;
    }

    private static function deleteAll($dir, $rmdir = 1){
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file)
            (is_dir("$dir/$file")) ? ImportController::deleteAll("$dir/$file") : unlink("$dir/$file");
        return ($rmdir ? rmdir($dir) : true);
    }


}