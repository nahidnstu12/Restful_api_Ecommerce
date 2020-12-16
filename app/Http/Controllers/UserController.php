<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\ApiController;

class UserController extends ApiController
{
    public function index()
    {
        $users = User::all();
        return $this->showAll($users); //using apiResponce class
    }

    public function store(Request $request)
    {
        $rules = [
            'name'=> 'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:8|confirmed'
        ];
        $this->validate($request,$rules);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = User::REGULAR_USER;

        $user = User::create($data);
        return $this->showOne($user,201);
    }

    public function show(User $user)  //implicit model bindind
    {
        return $this->showOne($user);
    }

    public function update(Request $request, User $user)
    {
        // $user = User::findOrFail($id);
        $rules = [
            'email'=>'email|unique:users|email,'. $user->id,
            'password'=>'min:8|confirmed',
            'admin'=> 'in:'. User::ADMIN_USER . ','. User::REGULAR_USER
        ];
        if($request->has('name')){
            $user->name = $request->name;
        }
        if($request->has('email') && $user->email != $request->email){
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationCode();
            $user->email = $request->email;
        }
        if($request->has('password')){
            $user->password = \bcrypt($request->password);
        }
        if($request->has('admin')){
            if(!$user->isVerified()){
                return $this->errorResponse('Only verified users can modify admin fields',409);
            }
            $user->admin = $request->admin;
        }
        if(!$user->isDirty()){
            return $this->errorResponse('You need to specify a different value update',422);
        }
        $user->save();
        return $this->showOne($user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $this->showOne($user);
    }
}
