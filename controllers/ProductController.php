<?php

namespace app\controllers;

use app\models\Image;
use Yii;
use app\models\Product;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UploadForm;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find()->with('param'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $imgs = new UploadForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $imgs->imageFiles = UploadedFile::getInstances($imgs, 'imageFiles');
            $imgs->upload($model->id);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', compact('model', 'imgs'));
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $imgs = Image::find()->where(['product_id' => $id])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (!$_FILES['UploadForm']['error']['imageFiles'][0]) {
                $imgs = new UploadForm();
                $imgs->imageFiles = UploadedFile::getInstances($imgs, 'imageFiles');
                $imgs->upload($model->id);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'imgs' => $imgs
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        foreach($model->image as $img)
            @unlink(Yii::$app->basePath . '\web\images\\' . $img->name);
        $img = new Image();
        $img->deleteAll(['product_id' => $model->id]);
        $model->delete();
        return $this->redirect(['index']);
    }

    public function actionImgdel(){
        $id = Yii::$app->request->get('id');
        if (Yii::$app->request->isAjax){
            $img = Image::findOne($id);
            unlink(Yii::$app->basePath . '/web/images/' . $img->name);
            $img->delete();
            return true;
        }
        return false;
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
