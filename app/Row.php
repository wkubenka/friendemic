<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Row extends Model
{
    public function __construct(array $attributes = array())
    {
        $attributes['recommend'] = true;
        $attributes['useEmail'] = false;
        $attributes['usePhone'] = false;
        $attributes['message'] = '';
        parent::__construct($attributes);
    }
    protected $fillable = [
            'cust_email', 
            'cust_fname',
            'cust_num',
            'cust_phone',
            'message',
            'recommend',
            'dateTime',
            'trans_type',
            'useEmail',
            'usePhone'
        ];

    protected $dates = ['dateTime'];

    public function youngerThanDays($days) {
        $today = Carbon::createFromDate(2018, 3, 5, 0 , 0 , 0); //March 5, 2018 00:00:00
        if($today->diffInDays($this->dateTime) > $days){
            $this->recommend = false;
            $this->message = 'occurred more than ' . $days . ' days ago';
        }
    }

    public function checkContactType() {
        if ($this->cust_phone != ""){
            //First use phone number
            $this->usePhone = true;
            //I'm not validating the phone number due to time constraints.
            //That should probably be done  
        } else if($this->cust_email != "" && filter_var($this->cust_email, FILTER_VALIDATE_EMAIL)){
            //Then use email if valid
            $this->useEmail = true;
        } else if($this->cust_email != "" && !filter_var($this->cust_email, FILTER_VALIDATE_EMAIL)) {
            $this->recommend = false;
            $this->message = 'email is invalid';
        } else {
            $this->recommend = false;
            $this->message = 'no email or phone number';
        }
    }
}
