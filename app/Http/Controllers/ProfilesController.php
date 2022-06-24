<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profiles;
class ProfilesController extends Controller
{
    //
    public function submit(Request $request){
        $request->validate([
            "full_name"    => ["required", "regex:/^[a-zA-Z., ]+$/"],
            "email"  => ["required", "email"],
            "phone_number" => ["required", "regex:/^(09|\+639)\d{9}$/"],
            "birth_date" => "required|date",
            "age" => "required|int",
            "gender" => "required|int"
        ]);

        $newProfile = new Profiles();
        $newProfile->full_name = $request->input('full_name');
        $newProfile->email = $request->input('email');
        $newProfile->phone_number =$request->input('phone_number');
        $date = str_replace('/', '-', $request->input('birth_date'));
        $bdate = date('Y-m-d', strtotime($date));
        $newProfile->birth_date = $bdate;
        $newProfile->age = $request->input('age');
        $newProfile->gender = $request->input('gender');
        $newProfile->save();

        return response()->json(['Submitted Successfully']);

    }
}

