<?php

namespace App\Http\Controllers;

use App\Http\Requests\CSVImportRequest;
use App\Services\CSVService;

class FileController extends Controller
{
    /**
     * Handles csv files being uploaded through the api.
     *
     * @param CSVImportRequest  $request The HTTP request with file to be processed.
     * 
     * @author Will Kubenka
     * @return Response
     */ 
    function upload(CSVImportRequest $request) {
        try{
            $CSVService = new CSVService($request->file);
            $processedCSV = $CSVService->processCSV();
            return response()->json($processedCSV);
        } catch (\Exception $e) {
            abort(400);
        }
        
    }
}
