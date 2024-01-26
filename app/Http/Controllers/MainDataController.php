<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Source;
use App\Models\Sub_source;


class MainDataController extends Controller
{
    public function create()
        {
            $sources = Source::all();
            return view('create', compact('sources'));
        }

    public function getDistricts($sourceId)
        {
            $ss= Source::findOrFail($sourceId)->ss;
            return response()->json($ss);
        }
}
