<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%locations}}`.
 */
class m211211_131445_create_locations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%locations}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(127),
            'slug' => $this->string(127),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%locations}}');
    }
}
