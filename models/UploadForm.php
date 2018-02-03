<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use Yii;

class UploadForm extends Model{
    /**
    * @var UploadedFile[]
    */
    public $imageFiles;

    public function rules(){
        return [
        [['imageFiles'], 'file', 'extensions' => 'jpg', 'maxFiles' => 3],
        ];
    }

    public function upload($product_id){
        if ($this->validate()) {
            $i = 0;
            foreach ($this->imageFiles as $file) {
                $new_name = time() . $i++ . '.' . $file->extension;
                $file->saveAs(Yii::$app->basePath . '/web/images/' . $new_name);
                $image = new Image();
                $image->product_id = $product_id;
                $image->name = $new_name;
                $image->save();
            }
            return true;
        } else return false;
    }

}