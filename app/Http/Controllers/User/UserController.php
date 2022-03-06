<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();

        return $this->showAll($user);
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
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ];
        $this->validate($request, $rules);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = User::REGULAR_USER;

        $user = User::create($data);

        return $this->showOne($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->showOne($user);
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
    public function update(Request $request, User $user)
    {
        $rules = [
            'email' => 'email|unique:users,user,email,' . $user->id,
            'password' => 'min:6|confirmed',
            'admin' => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER
        ];

        if($request->has('name')){
            $user->name = $request->name;
        }

        if($request->has('email') && $user -> email!= $request->email){
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationCode();
            $user->email = $request->email;
        }

        if($request->has('password')){
            $user->password =  bcrypt($request->name);
        }

        if($request->has('admin')){
            if(!$user->isVerified()){
                return $this->errorResponse('Only verified users can modify the admin field', 409);
            }
            $user->admin = $request->admin;
        }

        if(!$user->isDirty()){
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $user->save();

        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->showOne($user);
    }


    //Homework Khang mentor

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
