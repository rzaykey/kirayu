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

class ArsipController extends Controller
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
            $data = Documents::with('category')->select('documents.*')->where('role_id', '=', '6');
            return Datatables::of($data)
                ->addIndexColumn()
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('categories_id'))) {
                        $instance->where('categories_id', $request->get('categories_id'));
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
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d-M-Y');
                })
                ->addColumn('action', function ($row) {
                    if (auth()->user()->role_id == 6) {
                        $btn = '<a href="/document/arsip/' . $row->id . '" class="btn btn-info btn-sm"> View </a>';
                        $btn  = $btn . ' ' . ' <form action="/document/arsip/' . $row->id . '" method="post" class="d-inline"> ' . csrf_field() . ' ' . method_field("DELETE") . ' <button class="btn-sm btn-danger border-0" onclick="return confirm(\'Apakah yakin ingin menghapus ?\')"> Delete</button></form>';
                        return $btn;
                    } else {
                        $btn = '<a href="/document/arsip/' . $row->id . '" class="btn btn-info btn-sm"> View </a>';
                        return $btn;
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('documents.arsip.index', compact('categories', 'unit', 'author'));
    }

    public function create()
    {

        $this->authorize('is_perpustakaan');
        return view('documents.arsip.create', [
            'documents' => Documents::all(),
            'users' => User::all(),
            'units' => Units::all(),
            'categories' => Category::all(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('is_perpustakaan');
        if ($request->categories_id == 1) {
            $validatedData = $request->validate([
                'keterangan' => 'required|max:255',
                'created_by' => 'required',
                'images' => 'required|file|mimes:pdf|unique:documents|max:20480',
                'location_id' => 'required',
                'categories_id' => 'required',
                'role_id' => 'required',
            ]);
        }
        if ($request->categories_id == 2) {
            $validatedData = $request->validate([
                'keterangan' => 'required|max:255',
                'created_by' => 'required',
                'images' => 'required|file|mimes:xlsx,xlxs,xlx,docx,doc,csv,txt,pptx,ppt,mbd,xml|unique:documents|max:20480',
                'location_id' => 'required',
                'categories_id' => 'required',
                'role_id' => 'required',
            ]);
        }
        if ($request->categories_id == 3) {
            $validatedData = $request->validate([
                'keterangan' => 'required|max:255',
                'created_by' => 'required',
                'images' => 'required|file|mimes:jpg,jpeg,png,mp4|unique:documents|max:20480',
                'location_id' => 'required',
                'categories_id' => 'required',
                'role_id' => 'required',
            ]);
        }
        $file  = $request->file('images');
        $validatedData['role_id'] = $request->role_id;
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
        return redirect('/document/arsip')->with('success', 'Berhasil menambahkan Document.');
    }

    public function show($id)
    {
        $documents = Documents::find($id);
        return view('documents.arsip.show', [
            'documents' => $documents,
            'categories' => Category::all(),
            'units' => Units::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('is_perpustakaan');
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
        return redirect('/document/arsip')->with('success', 'Berhasil mengubah dokumen.');
    }

    public function destroy($id)
    {
        $this->authorize('is_perpustakaan');
        $documents = Documents::findOrFail($id);
        if ($documents->images == null) {
            return redirect('/document/arsip')->with('success', 'Gagal menghapus documents !');
        } else {
            if ($documents->images) {
                Storage::delete($documents->images);
            }
            User::destroy($documents->id);
            return redirect('/document/arsip')->with('success', 'Berhasil menghapus documents !');
        }
    }
}
