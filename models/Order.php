<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property string $unid
 * @property string $service_unid
 * @property string $user_unid
 * @property integer $items
 * @property string $date
 * @property string $notes
 * @property integer $sum
 * @property integer $status
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['items', 'sum', 'status'], 'integer'],
            [['date'], 'safe'],
            [['notes'], 'string'],
            [['unid', 'service_unid', 'user_unid'], 'string', 'max' => 255],
            [['service_unid',], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unid' => 'Unid',
            'service_unid' => 'Service Unid',
            'user_unid' => 'User Unid',
            'items' => 'Items',
            'date' => 'Date',
            'notes' => 'Notes',
            'sum' => 'Sum',
            'status' => 'Status',
        ];
    }

    public function fields()
    {
        return [
            'service_id' => 'service_unid',
        ];
    }
}
