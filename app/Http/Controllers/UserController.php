<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request){
        $limit = !empty($request->limit) && is_numeric($request->limit) ? $request->limit : '15';
        $cur_page = !empty($request->page) && is_numeric($request->page) ? $request->page : '1';
        return new UserCollection(User::paginate($limit, ['*'], 'page', $cur_page));
    }

    public function index(Request $request){
        if(isset($request->name) && isset($request->email) && isset($request->password)){
            $result = new UserResource(User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]));

        }else{
            $result = response()->json(['data' => 'error']);
        }
        return $result;
    }

    public function show(User $user){
        return !empty($user->id) ? new UserResource($user) : response()->json(['data' => 'not found']);
    }

    public function update(Request $request, User $user){
        if(isset($request->name) || isset($request->email) || isset($request->password)) {
            $updateArray = $request->all();
            if(!empty($updateArray['password'])){
                $updateArray['password'] = Hash::make($updateArray['password']);
            }
            $user->update($updateArray);
        }
        return new UserResource($user);
    }

    public function delete(User $user){
        return $user->delete() ? response()->json(['data'=>'ok']) : response()->json(['data'=>'error']);
    }
}
