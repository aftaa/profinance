<?php
/**
 * Created by PhpStorm.
 * User: Maxim Gabidullin
 * Date: 02.08.2018
 * Time: 15:53
 */

namespace backend\models;


use common\models\Transaction;
use moonland\phpexcel\Excel;
use Swift_SwiftException;
use Yii;

class TransactionService
{
    /**
     * @param string $excelFileName
     * @return Transaction[]
     */
    public static function createTransactionsFromExcel($excelFileName)
    {
        $data = Excel::import($excelFileName, ['setFirstRecordAsKeys' => false]);
        $transactions = [];
        foreach ($data as $list => $rows) {
            foreach ($rows as $row) {
                $transactions[] = Transaction::createTransaction($row['A'], $row['B'], $row['C']);
            }
        }
        return $transactions;
    }

    /**
     * @param Transaction[] $transactions
     * @return int
     */
    public static function sendMails(array $transactions)
    {
        $sent = 0;
        foreach ($transactions as $transaction) {
            if ($transaction->email) {

                try {
                    if (Yii::$app->mailer->compose()
                        ->setFrom('profinance')
                        ->setTo($transaction->email)
                        ->setSubject('Зачислены средства')
                        ->setTextBody($text = "Зачислены средства: $transaction->amout $transaction->currency")
                        ->setHtmlBody($text)
                        ->send()) {
                        $sent++;
                    }
                } catch (Swift_SwiftException $e) {
                    // видимо, неверный адрес
                }
            }
        }
        return $sent;
    }
}