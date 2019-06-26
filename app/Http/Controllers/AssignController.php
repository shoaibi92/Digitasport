<?php

namespace App\Http\Controllers;

use App\Assign;
use App\User;
use Illuminate\Http\Request;

class AssignController extends Controller
{

    /**
     * Display a listing of the users.
     *
     */
    public function all_members(){
        $users = User::all();
        return response()->json(array(
            'data'=> $users, 
            'msg'=> 'Get All Members Successfuly.', 
            'status' => 'success',
            'code' => 200)
        );
    }

    /**
     * Assign user_id to be belong to user.
     *
     */
    public function assign($belong_id, $user_id)
    {
        $user = User::find($user_id);
        $manger_user = User::find($belong_id);
        $user->belong_to = $belong_id;

        if (empty($manger_user) || empty($user)) {
            return response()->json(array(
                'msg'=> 'Belong to id or user id is not valid', 
                'status' => 'error',
                'code' => 404)
            );
        }

        $user->save();
        if ($user) {
            return response()->json(array(
                'data'=> $user, 
                'msg'=> 'Assign to user success.', 
                'status' => 'success',
                'code' => 200
            ));
        }
    }

    /**
     * get all users that belong to user id
     *
     */
    public function assign_to($id)
    {
        $users = User::where('belong_to', $id)->get();
        if ($users) {
            return response()->json(array(
                'data'=> $users, 
                'msg'=> 'Get belong_to Successfuly.', 
                'status' => 'success',
                'code' => 200)
            );
        }
        return response()->json(array(
            'msg'=> 'Belong_to User not found.', 
            'status' => 'error',
            'code' => 404)
        );
    }

    /**
     * Create New user
     *
     */
    public function register_user(Request $request)
    {
        $user = User::find($request->belong_to);
        
        if (!$user) {
            return response()->json(array(
                'msg'=> 'Belong_to User not found.', 
                'status' => 'error',
                'code' => 404)
            );
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email; 
        $user->belong_to = $request->belong_to;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(array(
            'data'=> $user, 
            'msg'=> 'User registed.', 
            'status' => 'success',
            'code' => 200)
        );
    }
}
