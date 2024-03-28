<?php

namespace App\Http\Controllers;

use App\Models\Documents;

class SuperadminController extends Controller
{
    public function index()
    {
        $rows = Documents::selectRaw('categories.name, COUNT(*) AS total')
            ->where('created_by', auth()->user()->name)
            ->join('categories', 'categories.id', 'documents.categories_id')
            ->groupBy('name')->get();
        $pie = [];
        foreach ($rows as $row) {
            $pie[] = [
                'name' =>  $row->name,
                'y' =>  $row->total,
            ];
        }

        $rows = Documents::selectRaw('COUNT(*) AS total')
            ->where('created_by', 'Perpustakaan')
            ->groupBy(['Y'])
            ->selectRaw('YEAR(created_at) as Y')->get();
        $line = [];
        foreach ($rows as $row) {
            $line['categories'][] = [$row->Y];
            $line['data'][] = $row->total * 1;
        }

        $myfile = Documents::where('created_by', auth()->user()->name)->count();
        $mypdf = Documents::join('categories', 'categories.id', '=', 'documents.categories_id')->where('created_by', auth()->user()->name)->where('categories.id', '=', '1')->count();
        $mydoc = Documents::join('categories', 'categories.id', '=', 'documents.categories_id')->where('created_by', auth()->user()->name)->where('categories.id', '=', '2')->count();
        return view('superadmin.index', compact('myfile', 'mypdf', 'mydoc', 'line', 'pie'));
    }
}
