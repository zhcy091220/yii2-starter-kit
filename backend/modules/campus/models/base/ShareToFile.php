<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace backend\modules\campus\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the base-model class for table "share_to_file".
 *
 * @property integer $share_to_file_id
 * @property integer $share_stream_id
 * @property integer $file_storage_item_id
 * @property integer $status
 * @property integer $updated_at
 * @property integer $created_at
 * @property string $aliasModel
 */
abstract class ShareToFile extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'share_to_file';
    }

    public static function getDb(){
        return Yii::$app->get('campus');
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
            [['share_stream_id', 'file_storage_item_id', 'status'], 'required'],
            [['share_stream_id', 'file_storage_item_id', 'status'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'share_to_file_id' => Yii::t('backend', 'Share To File ID'),
            'share_stream_id' => Yii::t('backend', 'Share Stream ID'),
            'file_storage_item_id' => Yii::t('backend', '文件id'),
            'status' => Yii::t('backend', '状态'),
            'updated_at' => Yii::t('backend', '更新时间'),
            'created_at' => Yii::t('backend', '创建时间'),
        ];
    }
    public function getFileStorageItem(){
        return $this->hasOne(
            \backend\modules\campus\models\FileStorageItem::className(),
            ['file_storage_item_id'=>'file_storage_item_id']
        );
    }
    
    /**
     * @inheritdoc
     * @return \backend\modules\campus\models\query\ShareStreamQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\modules\campus\models\query\ShareStreamQuery(get_called_class());
    }


}
