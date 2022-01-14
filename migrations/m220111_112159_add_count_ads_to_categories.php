<?php

use yii\db\Migration;

/**
 * Class m220111_112159_add_count_ads_to_categories
 */
class m220111_112159_add_count_ads_to_categories extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('categories', 'ads_count', 'integer not null default 0');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('categories', 'ads_count');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220111_112159_add_count_ads_to_categories cannot be reverted.\n";

        return false;
    }
    */
}
