<?php

namespace Tests\Unit;

use App\Transaction;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    protected $testData = [
            "trans_type" => "sales",
            "trans_date" => "2018-03-01",
            "trans_time" => "13:00:00",
            "cust_num" => "10012",
            "cust_fname" => "Bob",
            "cust_email" => "bob1@gmail.com",
            "cust_phone" => "123-123-1234",
            "dateTime" => "2018-03-01 13:00:00"
        ];

    /**
     * test youngerThanDays method
     *
     * @return void
     */
    public function testYoungerThanDays()
    {
        $transaction = new Transaction($this->testData);
        $this->assertTrue($transaction->recommend);//recommend begins true

        $transaction->youngerThanDays(5);//transaction is younger than 5 days old
        $this->assertTrue($transaction->recommend);//recommend is unchanged

        $transaction->youngerThanDays(4);//transaction is younger than 4 days old
        $this->assertTrue($transaction->recommend);//recommend is unchanged

        $transaction->youngerThanDays(3);//transaction is older than 3 days old
        $this->assertFalse($transaction->recommend);//recommend is now false
    }

    /**
     * test youngerThanDays method
     *
     * @return void
     */
    public function testCheckContactType()
    {
        $transaction = new Transaction($this->testData);
        $this->assertTrue($transaction->recommend);//recommend begins true
        $this->assertFalse($transaction->useEmail);//useEmail begins false
        $this->assertFalse($transaction->usePhone);//usePhone begins false

        //Phone should be used since it's present
        $transaction->checkContactType();
        $this->assertTrue($transaction->recommend);//recommend still true
        $this->assertFalse($transaction->useEmail);//useEmail still false
        $this->assertTrue($transaction->usePhone);//usePhone now true

        //Reset and remove phone
        $transaction->usePhone = false;
        $transaction->cust_phone = "";
        $transaction->checkContactType();
        $this->assertTrue($transaction->recommend);//recommend still true
        $this->assertTrue($transaction->useEmail);//useEmail now true
        $this->assertFalse($transaction->usePhone);//usePhone now false

        //Reset and make email invalid
        $transaction->useEmail = false;
        $transaction->cust_email = "bob@gmail";
        $transaction->checkContactType();
        $this->assertFalse($transaction->recommend);//recommend now false
        $this->assertFalse($transaction->useEmail);//useEmail now false
        $this->assertFalse($transaction->usePhone);//usePhone still false

        //Reset and remove email
        $transaction->recommend = true;
        $transaction->cust_email = "";
        $transaction->checkContactType();
        $this->assertFalse($transaction->recommend);//recommend still false
        $this->assertFalse($transaction->useEmail);//useEmail still false
        $this->assertFalse($transaction->usePhone);//usePhone still false
    }

}
