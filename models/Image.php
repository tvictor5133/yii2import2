<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "image".
 *
 * @property string $id
 * @property string $product_id
 * @property string $name
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'name'], 'required'],
            [['product_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function  getProduct(){
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'name' => 'Name',
        ];
    }
}
