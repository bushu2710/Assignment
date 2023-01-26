<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\models\Category;
use DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Category::all();

        if($request->ajax()){
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = "<div style='display:flex'>";
                $btn .= '<a href="'.route('edit-category', $row->id).'" class="btn btn-round btn-success btn-icon btn-sm like"><i class="material-icons text-lg position-relative">edit</i></a>';
                $btn .= '<button class="btn-round btn btn-icon btn-danger btn-sm btn-data-del" form="resource-delete-'.$row->id.'"><i class="material-icons text-lg position-relative">delete</i></button>';
                $btn .= '<form id="resource-delete-'.$row->id.'" action="'.route('category-delete', $row->id).'" method="POST">'.csrf_field().''.method_field("DELETE").'</form>';
                $btn .= "</div>";
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        else{
            return view('categories.index', compact('data'));
        }
        return view('categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
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
            'title' => 'required',
            'status' => 'required'
        ]);

        $data['slug'] = Str::random(30);
        
        Category::create($data);

        return redirect()->route('category-index');
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
        $category = Category::find($id);
        return view('categories.edit', compact('category'));
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
        $category = Category::find($id);
        $data = $request->all();

        $this->validate($request, [
            'title' => 'required',
            'status' => 'required'
        ]);

        $data['slug'] = Str::random(30);
        
        $category->update($data);

        return redirect()->route('category-index');    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('category-index');
    }
}
