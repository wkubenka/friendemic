<?php

namespace Tests\Unit;

use App\Jobs\arseCSVJob;
use App\Jobs\ParseCSVJob;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ParseCSVTest extends TestCase
{
    function testParser() {
        $uploadedFile = new UploadedFile(resource_path('test_files\Data.csv'), 'Data.csv', null, null, null, true);
        $parseCSVJob = new ParseCSVJob($uploadedFile);
        $parseCSVJob->handle();
        $this->assertCount(10, $parseCSVJob->getTransactions()); //Ensure ten rows are successfully read
    }


}
