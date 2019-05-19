<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UploadCSVTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpload()
    {
        $uploadedFile = new UploadedFile(resource_path('test_files\Data.csv'), 'Data.csv', null, null, null, true);
        $response = $this->postJson('/api/upload', [
            'file' => $uploadedFile,
        ]);
        $response->assertStatus(200);

        $expectedResponse =
            [["trans_type"=>"sales","cust_num"=>"10012","cust_fname"=>"Bob","cust_email"=>"bob1@gmail.com","cust_phone"=>"123-123-1234","dateTime"=>"2018-03-01 13:00:00","recommend"=>false,"useEmail"=>false,"usePhone"=>true,"message"=>"older record exists"],["trans_type"=>"service","cust_num"=>"10013","cust_fname"=>"Bob","cust_email"=>"bob2@gmail.com","cust_phone"=>"123-234-2345","dateTime"=>"2018-03-01 14:00:00","recommend"=>true,"useEmail"=>false,"usePhone"=>true,"message"=>""],["trans_type"=>"sales","cust_num"=>"10012","cust_fname"=>"Bobby","cust_email"=>"bob@gmail.com","cust_phone"=>"123-122-1223","dateTime"=>"2018-03-01 11:20:00","recommend"=>true,"useEmail"=>false,"usePhone"=>true,"message"=>""],["trans_type"=>"sales","cust_num"=>"10014","cust_fname"=>"Robert","cust_email"=>"","cust_phone"=>"123568556","dateTime"=>"2018-03-01 16:00:00","recommend"=>true,"useEmail"=>false,"usePhone"=>true,"message"=>""],["trans_type"=>"sales","cust_num"=>"10015","cust_fname"=>"Jill","cust_email"=>"jill@gmail,com","cust_phone"=>"","dateTime"=>"2018-03-02 17:30:00","recommend"=>false,"useEmail"=>false,"usePhone"=>false,"message"=>"email is invalid"],["trans_type"=>"service","cust_num"=>"10016","cust_fname"=>"Jillian","cust_email"=>"","cust_phone"=>"224-225-2228","dateTime"=>"2018-03-02 18:00:00","recommend"=>true,"useEmail"=>false,"usePhone"=>true,"message"=>""],["trans_type"=>"service","cust_num"=>"10017","cust_fname"=>"Jane","cust_email"=>"jane@gmail","cust_phone"=>"111-222-3333","dateTime"=>"2018-03-01 19:00:00","recommend"=>true,"useEmail"=>false,"usePhone"=>true,"message"=>""],["trans_type"=>"sales","cust_num"=>"10018","cust_fname"=>"Jacob","cust_email"=>"","cust_phone"=>"","dateTime"=>"2018-02-27 20:00:00","recommend"=>false,"useEmail"=>false,"usePhone"=>false,"message"=>"no email or phone number"],["trans_type"=>"service","cust_num"=>"10019","cust_fname"=>"Jerri Sanders","cust_email"=>"","cust_phone"=>"5526691245","dateTime"=>"2018-01-02 21:00:00","recommend"=>false,"useEmail"=>false,"usePhone"=>true,"message"=>"occurred more than 7 days ago"],["trans_type"=>"service","cust_num"=>"10020","cust_fname"=>"Bobby","cust_email"=>"bob@gmail.com","cust_phone"=>"123-122-1223","dateTime"=>"2018-03-04 14:00:00","recommend"=>true,"useEmail"=>false,"usePhone"=>true,"message"=>""]];
        $response->assertJson($expectedResponse);
    }
}
