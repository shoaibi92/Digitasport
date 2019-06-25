<?php

namespace App\Http\Controllers;

use App\Assign;
use App\User;
use Illuminate\Http\Request;

class AssignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function assign($maneger_id, $user_id)
    {
        $user = User::find($user_id);
        $user->belong_to = $maneger_id;
        $user->save();
        if ($user) {
            return response()->json(array('user'=> $user));
        }
        return response()->json(array('user'=> null));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
