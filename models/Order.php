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
 * @property float $sum
 * @property integer $status
 */
class Order extends \yii\db\ActiveRecord
{

    /**
     *
     */
    const DEFAULT_PRICE = 23.15;
    /**
     *
     */
    const DEFAULT_USER_UNID = 0;

    /**
     * @return int
     */
    private function _getPrice()
    {
        //Get price from?
        return self::DEFAULT_PRICE;
    }

    /**
     * @return int
     */
    private function _getUserUnid()
    {
        return self::DEFAULT_USER_UNID;
    }

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
            [['items'], 'integer'],
            [['date'], 'date', 'format' => Yii::$app->params['dateFormat']],
            [['notes'], 'string'],
            [['notes'], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            [['unid', 'service_unid', 'user_unid'], 'string', 'max' => 255],
            [['service_unid', 'notes', 'date', 'items'], 'required'],
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



    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $aliases = [
            'service_id' => 'service_unid',
            'order_items' => 'items',
            'order_notes' => 'notes',
        ];

        $request = Yii::$app->request;

        foreach ($aliases as $k => $v) {
            if ($request->post($k)) {
                $this->$v = $request->post($k);
            }
        }

        $this->date = "{$request->post('order_date')} {$request->post('order_time')}";
        return parent::beforeValidate();
    }


    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        $this->unid = sha1(implode($this->getAttributes()) . time());
        $this->sum = $this->_getPrice() * $this->items;
        $this->user_unid = $this->_getUserUnid();

        return parent::beforeSave($insert);
    }
}
