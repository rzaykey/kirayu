<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Documents;
use App\Models\Units;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class DocumentsController extends Controller
{
    protected $data;
    public function __construct()
    {
        $this->data = new Units();
    }

    public function index(Request $request)
    {
        $this->authorize('is_admin');
        $categories = Category::all();
        $unit = Units::all();
        $author = User::all();
        if ($request->ajax()) {
            $data = Documents::with('category')->select('documents.*');
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
                    if (!empty($request->get('from_date') && $request->get('to_date'))) {
                        $instance->whereBetween('created_at', [$request->from_date, $request->to_date]);
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
                ->rawColumns(['unitname'])

                ->addColumn('action', function ($row) {
                    $btn = '<a href="/documents/' . $row->id . '" class="btn btn-info btn-sm"> View </a>';
                    $btn  = $btn . ' ' . ' <form action="/documents/' . $row->id . '" method="post" class="d-inline"> ' . csrf_field() . ' ' . method_field("DELETE") . ' <button class="btn-sm btn-danger border-0" onclick="return confirm(\'Apakah yakin ingin menghapus ?\')"> Delete</button></form>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('documents.index', compact('categories', 'unit', 'author'));
    }

    public function create()
    {

        return view('documents.create', [
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
        return redirect('/document');
    }

    public function show($id)
    {
        $documents = Documents::find($id);
        return view('documents.show', [
            'documents' => $documents,
            'categories' => Category::all(),
            'units' => Units::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $updated_at = \Carbon\Carbon::now()->toDateTimeString();
        if ($request->categories_id == 1) {
            $validatedData = $request->validate([
                'keterangan' => 'max:255',
                'images' => 'file|mimes:pdf|unique:documents|max:20480',
                'location_id' => 'max:255',
                'categories_id' => 'max:255',
            ]);
        }
        if ($request->categories_id == 2) {
            $validatedData = $request->validate([
                'keterangan' => 'max:255',
                'images' => 'file|mimes:xlsx,xlxs,xlx,docx,doc,csv,txt,pptx,ppt,mbd,xml|unique:documents|max:20480',
                'location_id' => 'max:255',
                'categories_id' => 'max:255',
            ]);
        }
        if ($request->categories_id == 3) {
            $validatedData = $request->validate([
                'keterangan' => 'max:255',
                'images' => 'file|mimes:jpg,jpeg,png,mp4|unique:documents|max:20480',
                'location_id' => 'max:255',
                'categories_id' => 'max:255',
            ]);
        }
        if ($request->file('images') == null) {
            Documents::where('id', $id)
                ->update($validatedData);
        } else {
            $file  = $request->file('images');
            $validatedData['name'] = $file->getClientOriginalName();
            $validatedData['type'] = $file->getClientOriginalExtension();
            $size = $file->getSize();
            $validatedData['size'] = number_format($size / 1024);
            $validatedData['updated_at'] = $updated_at;

            if ($request->file('images')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                if ($request->categories_id == 3) {
                    $validatedData['images'] =  $file->storeAs("images", date('y-m-d-h-i-s') . ('_') .  $validatedData['name']);
                } else {
                    $validatedData['images'] =  $file->storeAs("documents", date('y-m-d-h-i-s') . ('_') .  $validatedData['name']);
                }
            }

            Documents::where('id', $id)
                ->update($validatedData);
        }

        $data = Documents::find($id);
        $data->unit()->sync($request->unit_id);
        Alert::success('Hore!', 'Update File Successfully');
        return redirect('/document/my');
    }

    public function destroy($id)
    {
        $documents = Documents::find($id);
        if ($documents->images == null) {
            Alert::error('Upss!', 'Delete File Failed');
            return redirect('/documents');
        } else {
            if ($documents->images) {
                Storage::delete($documents->images);
            }
            Documents::destroy($documents->id);
            Alert::success('Hore!', 'Delete File Successfully');
            return redirect('/documents');
        }
    }
}
