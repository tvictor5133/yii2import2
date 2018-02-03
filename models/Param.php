<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "param".
 *
 * @property string $id
 * @property string $name
 */
class Param extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'param';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function getProduct(){
        return $this->hasMany(Product::className(), ['param_id' => 'id'])->viaTable(ProductsParam::tableName(), ['product_id' => 'id']);
    }

    public function getProductsParam(){
        return $this->hasMany(ProductsParam::className(), ['param_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'name' => 'Наименование',
        ];
    }
}
