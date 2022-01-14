<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_ad_rate}}`.
 */
class m220109_132404_create_user_ad_rate_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_ad_rate}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'ad_id' => $this->integer(),
            'rate' => $this->float(2),
        ]);

        $this->createIndex(
            'idx-unique-user_ad-ad_id_rate',
            'user_ad_rate',
            ['ad_id', 'user_id'],
            true
        );

        $this->createIndex(
            'idx-user_ad-ad_id_rate',
            'user_ad_rate',
            'ad_id'
        );

        $this->addForeignKey(
            'fk-user_ad-ad_id_rate',
            'user_ad_rate',
            'ad_id',
            'user_ads',
            'id',
            'cascade',
            'cascade'
        );

        $this->createIndex(
            'idx-user_ad-user_id_rate',
            'user_ad_rate',
            'user_id'
        );

        $this->addForeignKey(
            'fk-user_ad-user_id_rate',
            'user_ad_rate',
            'user_id',
            'users',
            'id',
            'cascade',
            'cascade'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-user_ad-ad_id_rate',
            'user_ad_rate'
        );

        $this->dropIndex(
            'idx-user_ad-ad_id_rate',
            'user_ad_rate'
        );

        $this->dropForeignKey(
            'fk-user_ad-user_id_rate',
            'user_ad_rate'
        );

        $this->dropIndex(
            'idx-user_ad-user_id_rate',
            'user_ad_rate'
        );

        $this->dropIndex(
            'idx-unique-user_ad-ad_id_rate',
            'user_ad_rate'
        );

        $this->dropTable('{{%user_ad_rate}}');
    }
}
