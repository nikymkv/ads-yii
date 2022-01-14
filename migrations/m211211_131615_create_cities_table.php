<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cities}}`.
 */
class m211211_131615_create_cities_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cities}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(40),
            'slug' => $this->string(40),
            'location_id' => $this->integer()
        ]);

        $this->createIndex(
            'idx-city-location_id',
            'cities',
            'location_id',
        );

        $this->addForeignKey(
            'fk-city-location_id',
            'cities',
            'location_id',
            'locations',
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
            'fk-city-location_id',
            'cities'
        );

        $this->dropIndex(
            'idx-city-location_id',
            'cities'
        );

        $this->dropTable('{{%cities}}');
    }
}
