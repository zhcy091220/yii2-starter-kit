<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;
use backend\modules\campus\models\search\ShareToFileSearch;
use backend\modules\campus\models\search\ShareStreamToGradeSearch;
use backend\modules\campus\models\ShareStreamToGrade;
use backend\modules\campus\models\ShareStream;



    $ShareToGradeSearch = new ShareStreamToGradeSearch;

    $ShareToFileSearch  = new ShareToFileSearch;
    $ShareToFile =   $ShareToFileSearch->search($_GET);
    $ShareToFile->query->andwhere(['share_stream_id'=>$model->share_stream_id]);
    //$ShareToFile->query->orderby(['sort'=>SORT_DESC]);
    \Yii::$app->session['__crudReturnUrl'] = ['/campus/share-stream/view','share_stream_id'=>$model->share_stream_id];
/**
* @var yii\web\View $this
* @var backend\modules\campus\models\ShareStream $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('backend', '分享详情');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '分享详情'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->share_stream_id, 'url' => ['view', 'share_stream_id' => $model->share_stream_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'View');
?>
<div class="giiant-crud share-stream-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('backend', '分享详情') ?>
        <small>
            <?= $model->share_stream_id ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('backend', '修改'),
            [ 'update', 'share_stream_id' => $model->share_stream_id],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('backend', '复制'),
            ['create', 'share_stream_id' => $model->share_stream_id, 'ShareStream'=>$copyParams],
            ['class' => 'btn btn-success']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建'),
            ['create'],
            ['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '
            . Yii::t('backend', '返回列表'), ['index'], ['class'=>'btn btn-default']) ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('backend\modules\campus\models\ShareStream'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            //'author_id',
            [
                'attribute'=>'author_id',
                'label'    => '创建者',
                'value'=>function($model){
                    return Yii::$app->user->identity->getUserName($model->author_id);
                }
            ],
            'body',
            'status',
        ],
    ]); ?>

    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('backend', 'Delete'), ['delete', 'share_stream_id' => $model->share_stream_id],
    [
    'class' => 'btn btn-danger',
    'data-confirm' => '' . Yii::t('backend', 'Are you sure to delete this item?') . '',
    'data-method' => 'post',
    ]); ?>
    <?php $this->endBlock(); ?>

<?php $this->beginBlock('ShareToFiles'); ?>
<div style='position: relative'>
<div style='position:absolute; right: 0px; top: 0px;'>
  
</div>
</div>
<?php Pjax::begin(['id'=>'pjax-ShareToFiles', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-ShareToFiles ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>
<?=
 '<div class="table-responsive">'
 . \yii\grid\GridView::widget([
    'layout' => '{summary}{pager}<br/>{items}{pager}',
    'dataProvider' => $ShareToFile,
    'filterModel'  =>$ShareToFileSearch,
    'pager'        => [
        'class'          => yii\widgets\LinkPager::className(),
        'firstPageLabel' => Yii::t('backend', 'First'),
        'lastPageLabel'  => Yii::t('backend', 'Last')
    ],
    'columns' => [
 [
    'class'      => 'yii\grid\ActionColumn',
    'template'   => '{delete}',
    'contentOptions' => ['nowrap'=>'nowrap'],
    'urlCreator' => function ($action, $model, $key, $index) {
        // using the column name as key, not mapping to 'id' like the standard generator
        $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
        $params[0] = 'share-to-file' . '/' . $action;
        $params['ShareToFile'] = ['share_stream_id' => $model->primaryKey()[0]];
        return $params;
    },
    'buttons'    => [
        
    ],
    'controller' => 'share-to-file'
],
        'share_to_file_id',
// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
    [
       // 'class' => yii\grid\DataColumn::className(),
        'attribute' => 'file_storage_item_id',
        'value' => function ($model) {
            if ($rel = $model->getFileStorageItem()->one()) {
                return Html::a($rel->file_storage_item_id, ['file-storage-item/view', 'file_storage_item_id' => $rel->file_storage_item_id,], ['data-pjax' => 0]);
            } else {
                return '';
            }
        },
        'format' => 'raw',
    ],
    [
        'label'=>'图片',
        'format' => 'raw',
        'value'=>function($model){
            if($model->fileStorageItem){
                $url = $model->fileStorageItem->url.$model->fileStorageItem->file_name;
                return Html::a('<img width="50px" height="50px" class="img-thumbnail" src="'.$url.'?imageView2/1/w/50/h/50" />', $url.'?imageView2/1/w/500/h/500', ['title' => '访问','target' => '_blank']);
            }
        }
    ],
        'updated_at:datetime',
        'created_at:datetime',
]
])
 . '</div>' 
?>
<?php Pjax::end() ?>
<?php $this->endBlock() ?>


<?php $this->beginBlock('ShareToGrades'); ?>
<div style='position: relative'>
<div style='position:absolute; right: 0px; top: 0px;'>
 
</div>
</div>
<?php Pjax::begin(['id'=>'pjax-ShareToGrades', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-ShareToGrades ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>
<?=
 '<div class="table-responsive">'
 . \yii\grid\GridView::widget([
    'layout' => '{summary}{pager}<br/>{items}{pager}',
    'filterModel'  =>$ShareToGradeSearch,
    'dataProvider' => new \yii\data\ActiveDataProvider([
        'query' => $model->getShareToGrade(),
        'pagination' => [
            'pageSize' => 20,
            'pageParam'=>'page-sharetogrades',
        ]
    ]),
    'pager'        => [
        'class'          => yii\widgets\LinkPager::className(),
        'firstPageLabel' => Yii::t('backend', 'First'),
        'lastPageLabel'  => Yii::t('backend', 'Last')
    ],
    'columns' => [
 [
    'class'      => 'yii\grid\ActionColumn',
    'template'   => '{delete}',
    'contentOptions' => ['nowrap'=>'nowrap'],
    'urlCreator' => function ($action, $model, $key, $index) {
        // using the column name as key, not mapping to 'id' like the standard generator
        $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
        $params[0] = 'share-stream-to-grade' . '/' . $action;
        $params['ShareStreamToGrade'] = ['share_stream_id' => $model->primaryKey()[0]];
        return $params;
    },
    'buttons'    => [
        
    ],
    'controller' => 'share-stream-to-grade'
],
        [
            'attribute'=>'school_id',
            'value'    =>function($model){
                return isset($model->school->school_title) ? $model->school->school_title : '';
            }
        ],
        [
            'attribute'=>'grade_id',
            'value'    =>function($model){
                return isset($model->grade->grade_name) ? $model->grade->grade_name : '';
            }
        ],
        'updated_at:datetime',
        'created_at:datetime',
        //'auditor_id',
]
])
 . '</div>' 
?>
<?php Pjax::end() ?>
<?php $this->endBlock() ?>


    <?= Tabs::widget(
                 [
                     'id' => 'relation-tabs',
                     'encodeLabels' => false,
                     'items' => [
 [
    'label'   => '<b class=""># '.$model->share_stream_id.'</b>',
    'content' => $this->blocks['backend\modules\campus\models\ShareStream'],
    'active'  => true,
],
[
    'content' => $this->blocks['ShareToFiles'],
    'label'   => '<small>消息图片 <span class="badge badge-default">'.count($model->getShareToFile()->asArray()->all()).'</span></small>',
    'active'  => false,
],
[
    'content' => $this->blocks['ShareToGrades'],
    'label'   => '<small>授权详情 <span class="badge badge-default">'.count($model->getShareToGrade()->asArray()->all()).'</span></small>',
    'active'  => false,
],
 ]
                 ]
    );
    ?>
</div>
