<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m211216_200425_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'city_id' => $this->integer(),
            'location_id' => $this->integer(),
            'name' => $this->string(191),
            'email' => $this->string(191),
            'phone' => $this->string(191),
            'block' => $this->boolean(),
            'email_verified_at' => $this->timestamp()->null(),
            'password' => $this->string(191),
            'remember_token' => $this->string(191),
            'is_admin' => $this->boolean()->defaultValue(false),
        ]);

        $this->createIndex(
            'idx-user-location_id',
            'users',
            'location_id'
        );

        $this->addForeignKey(
            'fk-user-location_id',
            'users',
            'location_id',
            'locations',
            'id',
            'cascade',
            'cascade'
        );

        $this->createIndex(
            'idx-user-city_id',
            'users',
            'city_id'
        );

        $this->addForeignKey(
            'fk-user-city_id',
            'users',
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
            'fk-user-city_id',
            'users'
        );

        $this->dropIndex(
            'idx-user-city_id',
            'users'
        );

        $this->dropForeignKey(
            'fk-user-location_id',
            'users'
        );

        $this->dropIndex(
            'idx-user-location_id',
            'users'
        );

        $this->dropTable('{{%users}}');
    }
}
