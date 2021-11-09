<?php

namespace app\modules\PhoneBook\controllers;

use app\modules\PhoneBook\models\User;
use app\modules\PhoneBook\models\UserPhone;
use app\modules\PhoneBook\models\UserSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContactController implements the CRUD actions for User model.
 */
class ContactController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $phones = [];
        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->saveWithPhones()) {
                Yii::$app->session->setFlash('success', "Контакт сохранён");
                return $this->redirect(['index', 'id' => $model->id]);
            }
            $phones = array_values($model->getNewPhones());
            Yii::$app->session->setFlash('error', "Данные введены не верно");
        }

        return $this->render('update', [
            'model' => $model,
            'phones' => $phones,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $phones = $model->getUserPhones()->select('phone')->asArray()->column();

        if ($this->request->isPost) {
            $model->setOldPhones($phones);
            if ($model->load($this->request->post()) && $model->saveWithPhones()) {
                Yii::$app->session->setFlash('success', "Контакт сохранён");
                return $this->redirect(['index', 'id' => $model->id]);
            }
            $phones = array_values($model->getNewPhones());
            Yii::$app->session->setFlash('error', "Данные введены не верно");
        }

        return $this->render('update', [
            'model' => $model,
            'phones' => $phones,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
