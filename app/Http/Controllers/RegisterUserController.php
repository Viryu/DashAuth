<?php

namespace App\Http\Controllers;

use App\User;
use App\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use function MongoDB\BSON\toJSON;

class RegisterUserController extends Controller
{
    public function registerForm()
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:");
        }
        return view('auth.registerUser');
    }

    public function registerUser(Request $request)
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error"  );
        }
        // validate request where email must unique
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|unique:vdi_user|max:255',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
            'mid' =>'required'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->lastLogin = date('Y-m-d H:i:s');
        $user->mid = $request->mid;
        $user->save();

        // return with success response
        return redirect('/dashboard/register')->with('message','User is registered successfully');
    }

    public function showMidTidForm()
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:");
        }
        //get dummy data hehe
        $totalUser = User::all()->count();

        return view('auth.registerMidTid',compact('totalUser'));
    }

    public function registerMidTid(Request $request)
    {
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration. error:");
        }
        $request->validate([
            'email' => 'required|max:255|exists:vdi_user',
            'MID' => 'required',
            'TID' => 'required|unique:vdi_user_details'
        ]);

        $userDetail = new UserDetail();
        $userDetail->email = $request->email;
        $userDetail->MID = $request->MID;
        $userDetail->TID = $request->TID;
        $userDetail->save();

        //return success response
        return redirect('/dashboard/registerMid')->with('message','User is registered successfully');
    }



}
