<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace backend\modules\campus\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base-model class for table "courseware_to_courseware".
 *
 * @property integer $courseware_to_courseware_id
 * @property integer $courseware_master_id
 * @property integer $courseware_id
 * @property integer $status
 * @property integer $sort
 * @property integer $updated_at
 * @property integer $created_at
 * @property string $aliasModel
 */
abstract class CoursewareToCourseware extends \yii\db\ActiveRecord
{

    const COURSEWARE_STATUS_OPEN = 1;//正常
    const COURSEWARE_STATUS_DELECT = 0;//删除
    // public $sort = 1;

    public static function getDb(){
        //return Yii::$app->modules['campus']->get('campus');
        return Yii::$app->get('campus');
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'courseware_to_courseware';
    }



    public static function optsStatus()
    {
        return [
                self::COURSEWARE_STATUS_OPEN => '正常',
                self::COURSEWARE_STATUS_DELECT => '删除'
            ];
    }

    public static function LabelStatusValue($value){
        $lable = self::optsStatus();
        if(isset($lable[$value])){
            return $lable[$value];
        }
        return $value;
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['courseware_master_id', 'courseware_id'], 'required'],
            [['courseware_master_id', 'courseware_id', 'status', 'sort'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'courseware_to_courseware_id' => Yii::t('backend', '课件关系表自增ID'),
            'courseware_master_id' => Yii::t('backend', '主课件ID'),
            'courseware_id' => Yii::t('backend', '相关课件ID'),
            'status' => Yii::t('backend', '状态'),
            'sort' => Yii::t('backend', '默认与排序'),
            'updated_at' => Yii::t('backend', '更新时间'),
            'created_at' => Yii::t('backend', '创建时间'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return array_merge(parent::attributeHints(), [
            'courseware_to_courseware_id' => Yii::t('backend', '课件关系表自增ID'),
            'courseware_master_id' => Yii::t('backend', '主课件ID'),
            'courseware_id' => Yii::t('backend', '相关课件ID'),
            'status' => Yii::t('backend', '1：正常；0标记删除；2待审核； '),
            'sort' => Yii::t('backend', '默认与排序'),
        ]);
    }

    public function getCoursewareMaster(){
        return $this->hasOne(\backend\modules\campus\models\Courseware::className(),['courseware_id'=>'courseware_master_id']);
    }
    public function getCourseware(){
        return $this->hasOne(\backend\modules\campus\models\Courseware::className(),['courseware_id'=>'courseware_id']);
    }
    /**
     * @inheritdoc
     * @return \backend\modules\campus\models\query\CoursewareToCoursewareQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\modules\campus\models\query\CoursewareToCoursewareQuery(get_called_class());
    }


}
