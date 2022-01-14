<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%favorites_ads}}`.
 */
class m211216_203322_create_favorites_ads_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%favorites_ads}}', [
            'user_id' => $this->integer()->unsigned(),
            'ad_id' => $this->integer()->unsigned(),
            'PRIMARY KEY(user_id, ad_id)',
        ]);

        $this->createIndex(
            'idx-favorites_ad-user_id',
            'favorites_ads',
            'user_id'
        );

        $this->addForeignKey(
            'fk-favorites_ad-user_id',
            'favorites_ads',
            'user_id',
            'users',
            'id',
            'cascade',
            'cascade'
        );

        $this->createIndex(
            'idx-favorites_ad-ad_id',
            'favorites_ads',
            'ad_id'
        );

        $this->addForeignKey(
            'fk-favorites_ad-ad_id',
            'favorites_ads',
            'ad_id',
            'user_ads',
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
            'fk-favorites_ad-user_id',
            'favorites_ads'
        );

        $this->dropIndex(
            'idx-favorites_ad-user_id',
            'favorites_ads'
        );

        $this->dropForeignKey(
            'fk-favorites_ad-ad_id',
            'favorites_ads'
        );

        $this->dropIndex(
            'idx-favorites_ad-ad_id',
            'favorites_ads'
        );

        $this->dropTable('{{%favorites_ads}}');
    }
}
