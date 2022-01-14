<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_ads}}`.
 */
class m211216_201658_create_user_ads_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_ads}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'category_id' => $this->integer(),
            'subcategory_id' => $this->integer(),
            'currency_id' => $this->integer(),
            'location_id' => $this->integer(),
            'city_id' => $this->integer(),
            'title' => $this->string(191),
            'slug' => $this->string(191),
            'description' => $this->text(),
            'photo_array' => $this->json(),
            'price' => $this->decimal(10, 0)->defaultValue(0),
            'bargain' => $this->tinyInteger(),
            'phone_array' => $this->json(),
            'status' => $this->tinyInteger()->defaultValue(1),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')
        ]);

        $this->createIndex(
            'idx-user_ad-user_id',
            'user_ads',
            'user_id'
        );

        $this->addForeignKey(
            'fk-user_ad-user_id',
            'user_ads',
            'user_id',
            'users',
            'id',
            'cascade',
            'cascade'
        );

        $this->createIndex(
            'idx-user_ad-category_id',
            'user_ads',
            'category_id'
        );

        $this->addForeignKey(
            'fk-user_ad-category_id',
            'user_ads',
            'category_id',
            'categories',
            'id',
            'cascade',
            'cascade'
        );

        $this->createIndex(
            'idx-user_ad-subcategory_id',
            'user_ads',
            'subcategory_id'
        );

        $this->addForeignKey(
            'fk-user_ad-subcategory_id',
            'user_ads',
            'subcategory_id',
            'categories',
            'id',
            'cascade',
            'cascade'
        );

        $this->createIndex(
            'idx-user_ad-currency_id',
            'user_ads',
            'currency_id'
        );

        $this->addForeignKey(
            'fk-user_ad-currency_id',
            'user_ads',
            'currency_id',
            'currencies',
            'id',
            'cascade',
            'cascade'
        );

        $this->createIndex(
            'idx-user_ad-location_id',
            'user_ads',
            'location_id'
        );

        $this->addForeignKey(
            'fk-user_ad-location_id',
            'user_ads',
            'location_id',
            'locations',
            'id',
            'cascade',
            'cascade'
        );

        $this->createIndex(
            'idx-user_ad-city_id',
            'user_ads',
            'city_id'
        );

        $this->addForeignKey(
            'fk-user_ad-city_id',
            'user_ads',
            'city_id',
            'cities',
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
            'fk-user_ad-currency_id',
            'user_ads'
        );

        $this->dropIndex(
            'idx-user_ad-currency_id',
            'user_ads'
        );

        $this->dropForeignKey(
            'fk-user_ad-location_id',
            'user_ads'
        );

        $this->dropIndex(
            'idx-user_ad-location_id',
            'user_ads'
        );

        $this->dropForeignKey(
            'fk-user_ad-city_id',
            'user_ads'
        );

        $this->dropIndex(
            'idx-user_ad-city_id',
            'user_ads'
        );

        $this->dropForeignKey(
            'fk-user_ad-category_id',
            'user_ads'
        );

        $this->dropIndex(
            'idx-user_ad-category_id',
            'user_ads'
        );

        $this->dropForeignKey(
            'fk-user_ad-subcategory_id',
            'user_ads'
        );

        $this->dropIndex(
            'idx-user_ad-subcategory_id',
            'user_ads'
        );
        $this->dropTable('{{%user_ads}}');
    }
}
