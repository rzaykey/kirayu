<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $rows = Documents::selectRaw('categories.name, COUNT(*) AS total')
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

        // $rows = Documents::selectRaw('categories.name, COUNT(*) AS total')
        //     ->join('categories', 'categories.id', 'documents.categories_id')
        //     ->groupBy('name', 'created_at')
        //     ->selectRaw('categories.name as name, YEAR(documents.created_at) AS created_at')->get();

        // $column = [];
        // foreach ($rows as $row) {
        //     $column['categories'][$row->created_at] = $row->created_at;
        //     $column['series'][$row->name]['name'] = $row->name;
        //     $column['series'][$row->name]['data'][] = $row->total * 1;
        // }
        // foreach ($column['series'] as $key => $val) {
        //     $column['series'][$key]['data'] = array_values($val['data']);
        // }
        // $column['categories'] = array_values($column['categories']);
        // $column['series'] = array_values($column['series']);
        // ddd($column['categories']);

        $rows = User::selectRaw('COUNT(*) AS total')
            ->groupBy(['Y'])
            ->selectRaw('YEAR(created_at) as Y')->get();
        $userData = [];
        foreach ($rows as $row) {
            $userData['categories'][] = [$row->Y];
            $userData['data'][] = $row->total * 1;
        }


        $rows = Documents::selectRaw('COUNT(*) AS total')
            ->groupBy(['Y'])
            ->selectRaw('YEAR(created_at) as Y')->get();
        $fileData = [];
        foreach ($rows as $row) {
            $fileData['categories'][] = [$row->Y];
            $fileData['data'][] = $row->total * 1;
        }

        // ddd($userData);

        $file = Documents::count();
        $pdf = Documents::join('categories', 'categories.id', '=', 'documents.categories_id')->where('categories.id', '=', '1')->count();
        $doc = Documents::join('categories', 'categories.id', '=', 'documents.categories_id')->where('categories.id', '=', '2')->count();
        return view('reports.index', compact('file', 'pdf', 'doc', 'line', 'pie', 'userData', 'fileData'));
    }
}