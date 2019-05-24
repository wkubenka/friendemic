<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transaction extends Model
{
    /**
     * Attributes that can be mass-assigned
     *
     * @var array
     */
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

    /**
     * Attributes that should be converted to Carbon instances
     *
     * @var array
     */
    protected $dates = ['dateTime'];

    /**
     * Create a new Transaction instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = array())
    {
        $attributes['recommend'] = true;
        $attributes['useEmail'] = false;
        $attributes['usePhone'] = false;
        $attributes['message'] = '';
        parent::__construct($attributes);
    }


    /**
     * Change recommended to false and set the message if the Transaction
     * is not younger than the number of days provided
     * Assumes todays dates is March 5, 2018
     *
     * @param  int  $days number of dates it should be younger than
     * @return void
     */
    public function youngerThanDays($days) {
        $today = Carbon::createFromDate(2018, 3, 5, 0); //March 5, 2018 00:00:00
        if($today->diffInDays($this->dateTime) > $days){
            $this->recommend = false;
            $this->message = 'occurred more than ' . $days . ' days ago';
        }
    }

    /**
     * Determines which contact type to use. Phone has priority if available.
     * Change recommend to false if no valid contact type is available.
     *
     * @return void
     */
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
