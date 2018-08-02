<?php

use yii\db\Migration;

/**
 * Handles the creation of table `transaction`.
 */
class m180802_111357_create_transaction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('transaction', [
            'id' => $this->primaryKey()->comment('№ транзакции'),
            'email' => $this->string()->comment('E-mail')->notNull(),
            'phone' => $this->string()->comment('Телефон')->notNull(),
            'amount' => $this->decimal(10, 2)->comment('Сумма')->notNull(),
            'currency' => $this->string(3)->comment('Валюта')->notNull(),
            'created_at' => $this->timestamp()->comment('Дата и время операции')->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('transaction');
    }
}
