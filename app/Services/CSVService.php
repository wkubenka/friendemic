<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use App\Row;

class CSVService
{
    //array of Rows 
    private $csv; 

    //associative array of keys for $csv
    //used for comparing older records
    private $customerNumbers;

    public function __construct(UploadedFile $file){
        $csvRows = str_getcsv(file_get_contents($file), "\n");//Parse the csv

        $headers = explode(",", $csvRows[0]);//get the headers and put them in their own array
        array_shift($csvRows);//Remove the headers

        $customerNumbers = [];
        foreach($csvRows as $key => $row){
            foreach(str_getcsv($row) as $k => $value) {
                $header = $headers[$k];
                $parsedCSVRow[$header] = $value;
            }
            if(isset($customerNumbers[$parsedCSVRow['cust_num']])){
                array_push($customerNumbers[$parsedCSVRow['cust_num']], $key);
            } else {
                $customerNumbers[$parsedCSVRow['cust_num']] = [$key];
            }
            $parsedCSVRow['dateTime'] = $parsedCSVRow['trans_date'] . ' ' . $parsedCSVRow['trans_time'];
            $this->csv[] = new Row($parsedCSVRow);
        }
        $this->customerNumbers = $customerNumbers;
    }

    private function checkOlderRecord($row, $context) {
        // $rowDate = new Carbon($row->trans_date . ' '. $row->trans_time);
        if(count($this->customerNumbers[$row->cust_num]) > 1) {
            foreach($this->customerNumbers[$row->cust_num] as $i) {
                if($i !== $context) {;
                    if($row->dateTime->isAfter($this->csv[$i]->dateTime)) {
                        $row->recommend = false;
                        $row->message = 'older record exists';
                    }
                }
            }
        }
        return $row;
    }

    

    public function processCSV(){
        foreach($this->csv as $key => &$row){
            $this->checkOlderRecord($row, $key);
            $row->youngerThanDays(7);
            $row->checkContactType();           
        }
        return $this->csv;
    }
}
