<?php

use yii\db\Migration;

/**
 * Handles the creation for table `order`.
 */
class m160620_121756_create_order extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'unid' => $this->string()->unique(),
            'service_unid' => $this->string(40),
            'user_unid' => $this->string(),
            'items' => $this->integer(),
            'date' => $this->dateTime(),
            'notes' => $this->text(),
            'sum' => $this->float(),
            'status' => $this->integer(1)->defaultValue(0),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order');
    }
}
