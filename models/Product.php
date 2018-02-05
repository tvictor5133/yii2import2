<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property string $id
 * @property string $category_id
 * @property string $name
 * @property string $description
 * @property double $price
 * @property string $currency
 * @property string $url
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    public function getCategory(){
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getImage(){
        return $this->hasMany(Image::className(), ['product_id' => 'id']);
    }

    public function getParam(){
        return $this->hasMany(Param::className(), ['id' => 'param_id'])->viaTable(ProductsParam::tableName(), ['product_id' => 'id']);
    }

    public function getProductsParam(){
        return $this->hasMany(ProductsParam::className(), ['product_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'name', 'price', 'currency', 'url'], 'required'], //!!!!!!!!
            [['category_id'], 'integer'],
            [['price'], 'number'],
            [['name', 'description', 'url'], 'string', 'max' => 255],
            [['currency'], 'string', 'max' => 3],
            [['url'], 'url']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'category_id' => 'Категория',
            'name' => 'Наименование',
            'description' => 'Описание',
            'price' => 'Цена',
            'image' => 'Картинки',
            'currency' => 'Валюта',
            'url' => 'Ссылка'
        ];
    }
}
