<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\models\Product;
use App\models\Category;
use Yajra\DataTables\DataTables;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::join('categories', 'products.category','=' , 'categories.id')->select('categories.title as c_title', 'products.*','categories.slug as c_slug','categories.status as c_status')->get();
        if($request->ajax()){
            return Datatables::of($products)
            ->addIndexColumn()
            ->editColumn('category', function($row){
                return $row->c_title;
            })
            ->addColumn('featured_image', function($row){
                $image = $row->featured_image;
                $image = `<img src="{{ asset(`.$image.`) }}" />`;
                return $image;
            })
            ->addColumn('action', function($row){
                $btn = "<div style='display:flex'>";
                $btn .= '<a href="'.route('edit-product', $row->id).'" class="btn btn-round btn-success btn-icon btn-sm like"><i class="material-icons text-lg position-relative">edit</i></a>';
                $btn .= '<button class="btn-round btn btn-icon btn-danger btn-sm btn-data-del" form="resource-delete-'.$row->id.'"><i class="material-icons text-lg position-relative">delete</i></button>';
                $btn .= '<form id="resource-delete-'.$row->id.'" action="'.route('product-delete', $row->id).'" method="POST">'.csrf_field().''.method_field("DELETE").'</form>';
                $btn .= "</div>";
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        else{
            return view('products.index', compact('products'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $this->validate($request, [
            'category' => 'required',
            'title' => 'required',
            'featured_image' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
            'product_desc' => 'required',
            'status' => 'required'
        ]);
        
        $data['slug'] = Str::random(16);
        if($request->file('featured_image')){
            $file= $request->file('featured_image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('Image'), $filename);
            $data['featured_image']= $filename;
        }
        Product::create($data);

        return redirect()->route('product-index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $product = Product::find($id);

        return view('products.edit', compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $product = Product::find($id);

        $this->validate($request, [
            'category' => 'required',
            'title' => 'required',
            'featured_image' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
            'product_desc' => 'required',
            'status' => 'required'
        ]);
        $file = $request->file('featured_image');
        if ($file) {
            $destinationPath = 'image/';
            $filename= $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $data['featured_image'] = $filename;
        }else{
            unset($data['featured_image']);
        }
        $product->update($data);
        
        return redirect()->route('product-index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect()->route('product-index');
    }
}
