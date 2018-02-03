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

        $files = scandir($this->dist);
        unset($files[0], $files[1]);
        if (count($files)) {
            foreach($files as $file) {
                $zip = new \ZipArchive();
                $zip->open($this->dist . $file);
                $zip->extractTo($this->dist . 'unzip');
                $this->parser_category_xml($this->dist . 'unzip');
                $this->parser_product_xml($this->dist . 'unzip');
                $zip->close();
                unlink($this->dist . $file);
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
            $cat = Category::findOne((int) $category[0]['id']);
            if (!$cat)
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

            $prod = Product::find()->where(['name' => $product->name])->limit(1)->one(); // ToDO
            if (!$prod)
                $prod = new Product();
            $prod->name = (string) $product->name;
            $prod->description = (string) $product->description;
            $prod->price = (float) $product->price;
            $prod->category_id = (int) $product->categoryId;
            $prod->save();
            $id = $prod->id ? $prod->id : Yii::$app->db->getLastInsertID();
            $i = 0;
            if (count($product->pictures->picture)){
                $unlink = Image::find()->where('product_id = :id', [':id' => $id])->asArray()->all();
                if (count($unlink)){
                    foreach($unlink as $img)
                        unlink('images/' . $img['name']);
                }
                Image::deleteAll('product_id = :p_id', [':p_id' => $id]);
            }
            foreach($product->pictures->picture as $picture){
                $new_name = time() . $i++ . '.jpg';
                copy($path . '/' . (string) $picture, Yii::$app->basePath . '\web\images\\' . $new_name);
                $image = new Image();
                $image->product_id = $id;
                $image->name = $new_name;
                $image->save();
            }

            $q = count($product->param);
            for($i = 0 ; $i < $q ; $i++){

                $param = Param::find()->where(['name' => (string) $product->param[$i]->attributes()->name])->limit(1)->one();
                if (!$param){
                    $param = new Param();
                    $param->name = (string) $product->param[$i]->attributes()->name;
                    $param->save();
                    $param_id = Yii::$app->db->getLastInsertID();
                } else $param_id = (int) $param->id;
                $sql = "INSERT INTO `products_param` (`product_id`, `param_id`, `value`) VALUES('".$id."', '".$param_id."', '".((string) $product->param[$i])."') ON DUPLICATE KEY UPDATE `product_id`='".$id."', `param_id`='".$param_id."', `value`='".((string) $product->param[$i])."'";
                Yii::$app->db->createCommand($sql)->query();
            }

        }
        return true;
    }

    private function deleteAll($dir){
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file)
            (is_dir("$dir/$file")) ? $this->deleteAll("$dir/$file") : unlink("$dir/$file");
        return rmdir($dir);
    }


}