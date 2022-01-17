<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();

        return response()->json(['data' => $user], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function viewListUser()
    {
        $users = User::orderBy('id', 'DESC')->get();
        return view('HomeWork.User.list', compact('users'));
    }

    public function viewCreateUser()
    {
        return view('HomeWork.User.create');
    }

    public function viewEditUser($id)
    {
        $user = User::find($id);
        return view('HomeWork.User.edit', compact('user'));
    }

    public function createUser(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $created_at = date("Y-m-d H:s:i");
        DB::insert("insert into users (name, email, password, created_at, updated_at) values ('$name', '$email', 123456, '$created_at', '$created_at')");
        return redirect('/view-list-users');
    }
    public function deleteUser($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect('/view-list-users');
    }
    public function editUser(Request $request, $id)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        DB::table('users')
        ->where('id', $id)
        ->update([
            'name' => $name,
            'email' => $email,
            'updated_at' => date("Y-m-d H:s:i"),
        ]);
        return redirect('/view-list-users');
    }
}
