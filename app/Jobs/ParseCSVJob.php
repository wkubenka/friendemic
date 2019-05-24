<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\UploadedFile;
use App\Transaction;

class ParseCSVJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     *  All the individual transactions in the csv
     *
     * @var array
     */
    private $transactions;

    /**
     *  associative array of keys for $csv
     *  used for comparing records of the same customer number
     *
     * @var array
     */
    private $customerNumbers;

    /**
     * Create a new job instance.
     *
     * @param UploadedFile $file
     * @return void
     */
    public function __construct(UploadedFile $file)
    {
        $csvRows = str_getcsv(file_get_contents($file), "\n");//Parse the csv

        $headers = explode(",", $csvRows[0]);//get the headers and put them in their own array
        array_shift($csvRows);//Remove the headers from the original array

        $customerNumbers = [];
        foreach ($csvRows as $key => $row) {
            //TODO: Follow the 1 indentation rule.
            foreach (str_getcsv($row) as $k => $value) {
                $header = $headers[$k]; //get the header that aligns with this value
                $parsedCSVRow[$header] = $value;
            }
            //if the customerNumbers array already has this customer number in it push this row into it
            //else set it.
            if (isset($customerNumbers[$parsedCSVRow['cust_num']])) {
                $customerNumbers[$parsedCSVRow['cust_num']][] = $key;
            } else {
                $customerNumbers[$parsedCSVRow['cust_num']] = [$key];
            }
            //convert the separated date and time values into a single dateTime object
            //these two values get stripped because they are not fillable.
            $parsedCSVRow['dateTime'] = $parsedCSVRow['trans_date'] . ' ' . $parsedCSVRow['trans_time'];
            $this->transactions[] = new Transaction($parsedCSVRow);
        }
        $this->customerNumbers = $customerNumbers;
    }

    /**
     * Runs when the job is called.
     * Check each transaction:
     * 1. Is the oldest transaction.
     * 2. Is younger than 7 days.
     * 3. Which contact method to use.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->transactions as $key => &$transaction) {
            $this->checkOlderRecord($transaction, $key);
            $transaction->youngerThanDays(7);
            $transaction->checkContactType();
            $this->transactions[$key] = $transaction;
        }
        return;
    }


    /**
     * Determine if an older record exists than the current transaction
     *
     * @param Transaction $transaction
     * @param int $context //The key of the transaction in $this->transactions
     * @return void
     */
    private function checkOlderRecord($transaction, $context)
    {
        //TODO: Follow the 1 indentation rule.
        if (count($this->customerNumbers[$transaction->cust_num]) > 1) {
            foreach ($this->customerNumbers[$transaction->cust_num] as $i) {
                if ($i !== $context) {
                    if ($transaction->dateTime->isAfter($this->transactions[$i]->dateTime)) {
                        $transaction->recommend = false;
                        $transaction->message = 'older record exists';
                    }
                }
            }
        }
    }

    public function getTransactions()
    {
        return $this->transactions;
    }
}
