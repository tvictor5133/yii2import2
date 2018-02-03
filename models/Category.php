<?php

namespace app\models;

use Yii;
use app\models\Product;

/**
 * This is the model class for table "category".
 *
 * @property string $id
 * @property string $parent_id
 * @property string $name
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    public function getProduct(){
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }

    public function getCategory(){
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'name'], 'required'],
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'parent_id' => 'Родительская категория',
            'name' => 'Наименование',
        ];
    }
}
