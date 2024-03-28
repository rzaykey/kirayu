<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use App\Models\Category;
use App\Models\User;
use App\Models\Units;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class Myfile extends Controller
{
    protected $data;
    public function __construct()
    {
        $this->data = new Units();
    }

    public function index(Request $request)
    {
        $categories = Category::all();
        $unit = Units::all();
        $author = User::all();
        if ($request->ajax()) {
            $data = Documents::where('created_by', auth()->user()->name);
            return Datatables::of($data)
                ->addIndexColumn()
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('categories_id'))) {
                        $instance->where('categories_id', $request->get('categories_id'));
                    }
                    if (!empty($request->get('unit_id'))) {
                        $instance->where('location_id', $request->get('unit_id'));
                    }
                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('name', 'LIKE', "%$search%")
                                ->orWhere('keterangan', 'LIKE', "%$search%")
                                ->orWhere('created_by', 'LIKE', "%$search%")
                                ->orWhere('created_at', 'LIKE', "%$search%");
                        });
                    }
                })
                ->addColumn('categories', function (Documents $documents) {
                    return $documents->category->name;
                })
                ->addColumn('unit', function (Documents $documents) {
                    return $documents->units->name;
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d-M-Y');
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="/document/my/' . $row->id . '" class="btn btn-info btn-sm"> <span data-feather="eye"></span> </a>';
                    $btn  = $btn . ' ' . ' <a href="' . asset("/storage/$row->images") . '" class="btn btn-sm btn-primary" target="_blank"><span data-feather="download">Download</span></a>';
                    $btn  = $btn . ' ' . ' <form action="/document/my/' . $row->id . '" method="post" class="d-inline"> ' . csrf_field() . ' ' . method_field("DELETE") . ' <button class="btn-sm btn-danger border-0" onclick="return confirm(\'Apakah yakin ingin menghapus ?\')"> Delete</button></form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('documents.my.index', compact('categories', 'unit', 'author'));
    }

    public function shared(Request $request)
    {
        $categories = Category::all();
        $unit = Units::all();
        $author = User::all();
        if ($request->ajax()) {
            $data = Documents::whereHas('unit', function ($q) {
                $q->where('units_id', auth()->user()->unit_id)->orderBy('documents.id', 'desc');
            });
            return Datatables::of($data)
                ->addIndexColumn()
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('categories_id'))) {
                        $instance->where('categories_id', $request->get('categories_id'));
                    }
                    if (!empty($request->get('unit_id'))) {
                        $instance->where('location_id', $request->get('unit_id'));
                    }
                    if (!empty($request->get('author'))) {
                        $instance->where('created_by', $request->get('author'));
                    }
                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('name', 'LIKE', "%$search%")
                                ->orWhere('keterangan', 'LIKE', "%$search%")
                                ->orWhere('created_by', 'LIKE', "%$search%")
                                ->orWhere('created_at', 'LIKE', "%$search%");
                        });
                    }
                })
                ->addColumn('categories', function (Documents $documents) {
                    return $documents->category->name;
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d-M-Y');
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="/document/shared/' . $row->id . '" class="btn btn-info btn-sm"> <span data-feather="eye"></span> </a>';
                    $btn  = $btn . ' ' . ' <a href="' . asset("/storage/$row->images") . '" class="btn btn-sm btn-primary" target="_blank"><span data-feather="download">Download</span></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('documents.shared.index', compact('categories', 'unit', 'author'));
    }

    public function Vshared($id)
    {
        $documents = Documents::findOrFail($id);
        return view('documents.shared.show', [
            'documents' => $documents,
            'categories' => Category::all(),
            'units' => Units::all(),
            'title' => 'File'
        ]);
    }

    public function Vmy($id)
    {
        $documents = Documents::findOrFail($id);
        return view('documents.my.show', [
            'documents' => $documents,
            'categories' => Category::all(),
            'units' => Units::all(),
            'title' => 'File'
        ]);
    }

    public function delete($id)
    {
        $documents = Documents::find($id);
        if ($documents->images == null) {
            Alert::error('Ups!', 'Failed Delete File');
            return redirect('/document/my/');
        } else {
            if ($documents->images) {
                Storage::delete($documents->images);
            }
            Documents::destroy($documents->id);
            Alert::success('Hore!', 'Delete File Successfully');
            return redirect('/document/my/');
        }
    }

    public function create()
    {

        return view('documents.my.create', [
            'documents' => Documents::all(),
            'users' => User::all(),
            'units' => Units::all(),
            'categories' => Category::all(),
        ]);
    }

    public function store(Request $request)
    {

        if ($request->categories_id == 1) {
            $validatedData = $request->validate([
                'keterangan' => 'required|max:255',
                'created_by' => 'required',
                'images' => 'required|file|mimes:pdf|unique:documents|max:20480',
                'location_id' => 'required',
                'categories_id' => 'required',
            ]);
        }
        if ($request->categories_id == 2) {
            $validatedData = $request->validate([
                'keterangan' => 'required|max:255',
                'created_by' => 'required',
                'images' => 'required|file|mimes:xlsx,xlxs,xlx,docx,doc,csv,txt,pptx,ppt,mbd,xml|unique:documents|max:20480',
                'location_id' => 'required',
                'categories_id' => 'required',
            ]);
        }
        if ($request->categories_id == 3) {
            $validatedData = $request->validate([
                'keterangan' => 'required|max:255',
                'created_by' => 'required',
                'images' => 'required|file|mimes:jpg,jpeg,png,mp4|unique:documents|max:20480',
                'location_id' => 'required',
                'categories_id' => 'required',
            ]);
        }
        $file  = $request->file('images');
        $validatedData['name'] = $file->getClientOriginalName();
        $validatedData['type'] = $file->getClientOriginalExtension();
        $size = $file->getSize();
        $validatedData['size'] = number_format($size / 1024);
        if ($request->file('images')) {
            if ($request->categories_id == 3) {
                $validatedData['images'] =  $file->storeAs("images", date('y-m-d-h-i-s') . ('_') .  $validatedData['name']);
            } else {
                $validatedData['images'] =  $file->storeAs("documents", date('y-m-d-h-i-s') . ('_') .  $validatedData['name']);
            }
        }
        Documents::create($validatedData);
        Alert::success('Hore!', 'Create File Successfully');
        return redirect('/document/my/');
    }
}
