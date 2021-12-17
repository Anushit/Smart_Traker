<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use \App\Rules\MatchOldPassword;
use App\Models\User;
use Image;
use Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile()
    {
        $data = User::find(Auth::id());
        return view('profile.profile',compact('data'));
    }
    public function profileUpdate(Request $request)
    {

        $validatedData = $request->validate([
            'name'         => 'required',
            'email'         => 'required',
            'phone'         => 'required|max:12',
            'profileimage'       => 'mimes:jpeg,jpg,png|max:10000',
        ],[
            "name.required" => "Name is required",
            "email.required" => "Email is required",
            "phone.required" => "Phone is required",
        ]);


        $data = User::find(Auth::id());
        //dd($data);
        if ($files = $request->file('profileimage')) {
            //dd($files);
            $files = $request->file('profileimage');
            if(\File::exists(public_path('upload/images/profileimage/'.$data->image))) {
                \File::delete(public_path('upload/images/profileimage/'.$data->image));
                \File::delete(public_path('upload/images/profileimage/thumbnail/'.$data->image));
            }
            $image = ImageResize('upload/images/profileimage/',array("height"=>50,"width"=>100),$files);
            
            $data->image = $image;
            //dd( $data->image);
        }
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->save();
        toastr()->success('Profile Updated Successfully.');
        return redirect(url(\Config::get('constants.admin_url.admin').'/profile#1'));
    }
    public function profileChangePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'old_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'confirm_password' => 'required|same:new_password',
        ]);
        if ($validator->fails()) {
            return redirect(url(\Config::get('constants.admin_url.admin').'/profile#2'))
                        ->withErrors($validator)
                        ->withInput();
        }


        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
        toastr()->success('Password Changed Successfully');
        return redirect(url(\Config::get('constants.admin_url.admin').'/profile#2'));
    }



}
