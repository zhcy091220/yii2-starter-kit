<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace backend\modules\campus\controllers\base;

use backend\modules\campus\models\ShareToFile;
    use backend\modules\campus\models\search\ShareToFileSearch;
use yii\web\Controller;
use yii\web\HttpException;
use yii\helpers\Url;
use yii\filters\AccessControl;
use dmstr\bootstrap\Tabs;

/**
* ShareToFileController implements the CRUD actions for ShareToFile model.
*/
class ShareToFileController extends Controller
{


/**
* @var boolean whether to enable CSRF validation for the actions in this controller.
* CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
*/
public $enableCsrfValidation = false;

    /**
    * @inheritdoc
    */
    public function behaviors()
    {
    return [
    'access' => [
    'class' => AccessControl::className(),
    'rules' => [
    [
    'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'roles' => ['CampusShareToFileFull'],
                    ],
    [
    'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => ['CampusShareToFileView'],
                    ],
    [
    'allow' => true,
                        'actions' => ['update', 'create', 'delete'],
                        'roles' => ['CampusShareToFileEdit'],
                    ],
    
                ],
            ],
    ];
    }

/**
* Lists all ShareToFile models.
* @return mixed
*/
public function actionIndex()
{
    $searchModel  = new ShareToFileSearch;
    $dataProvider = $searchModel->search($_GET);

Tabs::clearLocalStorage();

Url::remember();
\Yii::$app->session['__crudReturnUrl'] = null;

return $this->render('index', [
'dataProvider' => $dataProvider,
    'searchModel' => $searchModel,
]);
}

/**
* Displays a single ShareToFile model.
* @param integer $share_to_file_id
*
* @return mixed
*/
public function actionView($share_to_file_id)
{
\Yii::$app->session['__crudReturnUrl'] = Url::previous();
Url::remember();
Tabs::rememberActiveState();

return $this->render('view', [
'model' => $this->findModel($share_to_file_id),
]);
}

/**
* Creates a new ShareToFile model.
* If creation is successful, the browser will be redirected to the 'view' page.
* @return mixed
*/
public function actionCreate()
{
$model = new ShareToFile;

try {
if ($model->load($_POST) && $model->save()) {
return $this->redirect(['view', 'share_to_file_id' => $model->share_to_file_id]);
} elseif (!\Yii::$app->request->isPost) {
$model->load($_GET);
}
} catch (\Exception $e) {
$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
$model->addError('_exception', $msg);
}
return $this->render('create', ['model' => $model]);
}

/**
* Updates an existing ShareToFile model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $share_to_file_id
* @return mixed
*/
public function actionUpdate($share_to_file_id)
{
$model = $this->findModel($share_to_file_id);

if ($model->load($_POST) && $model->save()) {
return $this->redirect(Url::previous());
} else {
return $this->render('update', [
'model' => $model,
]);
}
}

/**
* Deletes an existing ShareToFile model.
* If deletion is successful, the browser will be redirected to the 'index' page.
* @param integer $share_to_file_id
* @return mixed
*/
public function actionDelete($share_to_file_id)
{
try {
$this->findModel($share_to_file_id)->delete();
} catch (\Exception $e) {
$msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
\Yii::$app->getSession()->addFlash('error', $msg);
return $this->redirect(Url::previous());
}

// TODO: improve detection
$isPivot = strstr('$share_to_file_id',',');
if ($isPivot == true) {
return $this->redirect(Url::previous());
} elseif (isset(\Yii::$app->session['__crudReturnUrl']) && \Yii::$app->session['__crudReturnUrl'] != '/') {
Url::remember(null);
$url = \Yii::$app->session['__crudReturnUrl'];
\Yii::$app->session['__crudReturnUrl'] = null;

return $this->redirect($url);
} else {
return $this->redirect(['index']);
}
}

/**
* Finds the ShareToFile model based on its primary key value.
* If the model is not found, a 404 HTTP exception will be thrown.
* @param integer $share_to_file_id
* @return ShareToFile the loaded model
* @throws HttpException if the model cannot be found
*/
protected function findModel($share_to_file_id)
{
if (($model = ShareToFile::findOne($share_to_file_id)) !== null) {
return $model;
} else {
throw new HttpException(404, 'The requested page does not exist.');
}
}
}
