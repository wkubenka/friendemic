<?php

namespace App\Http\Controllers;

use App\Http\Requests\CSVImportRequest;
use App\Services\CSVService;
use App\Jobs\ParseCSVJob;

class FileController extends Controller
{
    /**
     * Handles csv files being uploaded through the api.
     *
     * @param CSVImportRequest  $request The HTTP request with file to be processed.
     * 
     * @author Will Kubenka <wkubenka@gmail.com>
     * @return Response
     */ 
    function upload(CSVImportRequest $request) {
        try{
            $parseCSVJob = new ParseCSVJob($request->file);
            $this->dispatchNow($parseCSVJob);
            return response()->json($parseCSVJob->getTransactions());
        } catch (\Exception $e) {
            abort(400);
        }
        
    }
}
