<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products_param".
 *
 * @property string $id
 * @property string $product_id
 * @property string $param_id
 * @property string $value
 */
class ProductsParam extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products_param';
    }

    public function getProduct(){
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getParam(){
        return $this->hasOne(Param::className(), ['id' => 'param_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'param_id', 'value'], 'required'],
            [['product_id', 'param_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'product_id' => 'Продукт',
            'param_id' => 'Параметр',
            'value' => 'Значение',
        ];
    }
}
