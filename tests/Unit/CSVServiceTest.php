<?php

namespace Tests\Unit;

use App\Services\CSVService;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CSVServiceTest extends TestCase
{
    function testParser() {
        $uploadedFile = new UploadedFile(resource_path('test_files\Data.csv'), 'Data.csv', null, null, null, true);
        $CSVService = new CSVService($uploadedFile);
        $transactions = $CSVService->processCSV();
        $this->assertCount(10, $transactions); //Ensure ten rows are successfully read
    }


}
