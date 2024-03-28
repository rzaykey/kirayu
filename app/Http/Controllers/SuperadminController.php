<?php

namespace App\Http\Controllers;

use App\Models\Products;

class SuperadminController extends Controller
{
    public function index()
    {
        $rows = Products::selectRaw('categories.name, COUNT(*) AS total')
            ->where('created_by', auth()->user()->name)
            ->join('categories', 'categories.id', 'products.categories_id')
            ->groupBy('name')->get();
        $pie = [];
        foreach ($rows as $row) {
            $pie[] = [
                'name' =>  $row->name,
                'y' =>  $row->total,
            ];
        }

        $rows = Products::selectRaw('COUNT(*) AS total')
            ->where('created_by', 'Perpustakaan')
            ->groupBy(['Y'])
            ->selectRaw('YEAR(created_at) as Y')->get();
        $line = [];
        foreach ($rows as $row) {
            $line['categories'][] = [$row->Y];
            $line['data'][] = $row->total * 1;
        }

        $myfile = Products::where('created_by', auth()->user()->name)->count();
        $mypdf = Products::join('categories', 'categories.id', '=', 'products.categories_id')->where('created_by', auth()->user()->name)->where('categories.id', '=', '1')->count();
        $mydoc = Products::join('categories', 'categories.id', '=', 'products.categories_id')->where('created_by', auth()->user()->name)->where('categories.id', '=', '2')->count();
        return view('superadmin.index', compact('myfile', 'mypdf', 'mydoc', 'line', 'pie'));
    }
}
