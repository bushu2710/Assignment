<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Users = User::all();

            if($request->ajax()){
                return Datatables::of($Users)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row){
                    if($row->created_at){
                        $created_at = $row->created_at;
                    }
                    else{
                        $created_at = '---';
                    }
                    return $created_at;
                })
                ->addColumn('action', function($row){
                    $btn = "<div style='display:flex'>";
                    $btn .= '<a href="'.route('user-edit', $row->id).'" class="btn btn-round btn-success btn-icon btn-sm like"><i class="material-icons text-lg position-relative">edit</i></a>';
                    $btn .= '<button class="btn-round btn btn-icon btn-danger btn-sm btn-data-del" form="resource-delete-'.$row->id.'"><i class="material-icons text-lg position-relative">delete</i></button>';
                    $btn .= '<form id="resource-delete-'.$row->id.'" action="'.route('user-delete', $row->id).'" method="POST">'.csrf_field().''.method_field("DELETE").'</form>';
                    $btn .= "</div>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
            return view('pages.user-management', compact('Users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.create-user');
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required'
        ]);

        $user = User::create($data);

        return redirect()->route('user-index');
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
        $users = User::find($id);


        return view('pages.edit-user', compact('users'));
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
        $user = User::find($id);
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required'
        ]);
        $data = $request->all();
        $user->update($data);

        return redirect()->route('user-index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('user-index');
    }
}
