<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%categories}}`.
 */
class m211216_201405_create_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%categories}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'name' => $this->string(191),
            'slug' => $this->string(191),
        ]);

        $this->createIndex(
            'idx-category-parent_id',
            'categories',
            'parent_id'
        );

        $this->addForeignKey(
            'fk-category-parent_id',
            'categories',
            'parent_id',
            'categories',
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
            'fk-category-parent_id',
            'categories'
        );

        $this->dropIndex(
            'idx-category-parent_id',
            'categories'
        );

        $this->dropTable('{{%categories}}');
    }
}
