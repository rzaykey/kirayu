<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function searchUnit()
    {
        return view('units.index');
    }
    public function read()
    {
        return 'Units : ...';
    }
}
