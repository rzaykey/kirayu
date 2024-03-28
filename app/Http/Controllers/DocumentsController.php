<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class DocumentsController extends Controller
{
    protected $data;

    public function index(Request $request)
    {
        $this->authorize('is_admin');
        $categories = Category::all();
        $author = User::all();
        if ($request->ajax()) {
            $data = Products::with('category')->select('products.*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('categories_id'))) {
                        $instance->where('categories_id', $request->get('categories_id'));
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
                ->addColumn('categories', function (Products $products) {
                    return $products->category->name;
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d-M-Y');
                })

                ->addColumn('action', function ($row) {
                    $btn = '<a href="/products/' . $row->id . '" class="btn btn-info btn-sm"> View </a>';
                    $btn  = $btn . ' ' . ' <form action="/products/' . $row->id . '" method="post" class="d-inline"> ' . csrf_field() . ' ' . method_field("DELETE") . ' <button class="btn-sm btn-danger border-0" onclick="return confirm(\'Apakah yakin ingin menghapus ?\')"> Delete</button></form>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('products.index', compact('categories', 'author'));
    }

    public function create()
    {

        return view('products.create', [
            'products' => Products::all(),
            'users' => User::all(),
            'categories' => Category::all(),
        ]);
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'qty' => 'required',
            'price' => 'required',
            'description' => 'required|max:255',
            'created_by' => 'required',
            'images' => 'file|mimes:jpg,jpeg,png,mp4|max:20480',
            'categories_id' => 'required',
        ]);
        if ($request->file('images')) {
            $validatedData['images'] =  $request->file('images')->store('products');
        }
        Products::create($validatedData);
        Alert::success('Hore!', 'Create File Successfully');
        return redirect('/products');
    }

    public function show($id)
    {
        $products = Products::find($id);
        return view('products.show', [
            'products' => $products,
            'categories' => Category::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $updated_at = \Carbon\Carbon::now()->toDateTimeString();
        $validatedData = $request->validate([
            'name' => 'required',
            'qty' => 'max:255',
            'price' => 'max:255',
            'description' => 'max:255',
            'created_by' => 'max:255',
            'images' => 'file|mimes:jpg,jpeg,png,mp4|max:20480',
            'categories_id' => 'max:255',
        ]);
        if ($request->file('images') == null) {
            Products::where('id', $id)
                ->update($validatedData);
        } else {
            $validatedData['updated_at'] = $updated_at;


            if ($request->file('images')) {
                $validatedData['images'] =  $request->file('images')->store('products');
            }

            Products::where('id', $id)
                ->update($validatedData);
        }

        Alert::success('Hore!', 'Update File Successfully');
        return redirect('/products');
    }

    public function destroy($id)
    {
        $products = Products::find($id);
        if ($products->images == null) {
            Alert::error('Upss!', 'Delete File Failed');
            return redirect('/products');
        } else {
            if ($products->images) {
                Storage::delete($products->images);
            }
            Products::destroy($products->id);
            Alert::success('Hore!', 'Delete File Successfully');
            return redirect('/products');
        }
    }
}
