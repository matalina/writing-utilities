<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\WordFrequency\StoreRequest;
use App\Utilities\WordUtility;

class WordFrequencyController extends Controller
{
    protected $utility;

    public function __construct(WordUtility $utility) 
    {
        $this->utility = $utility;
    }

    public function store(StoreRequest $request)
    {
        $string = $request->get('string');

        if(empty($string)) {
            $file = $request->file('file');
            $path = \Storage::disk('local')->putFile('',$file);
            $string = \Storage::disk('local')->get($path);
        }

        $result = $this->utility->wordFrequency($string);

        return response()->json(['data' => $result]);
    }
}
