<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%currencies}}`.
 */
class m211216_201043_create_currencies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%currencies}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(191),
            'icon' => $this->string(191),
            'code' => $this->string(191),
            'code_int' => $this->string(191),
            'symbol' => $this->string(191),
            'format' => $this->string(191),
            'exchange_rate' => $this->string(191),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%currencies}}');
    }
}
