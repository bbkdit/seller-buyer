<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Auth;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        $uniqueEmail =  Rule::unique('users')->where(function ($query) use ($data){
                return $query->where('email', $data['email']??'')
                ->where('user_type', $data['user_type']??'');
            });
        $uniquePhone =  Rule::unique('users')->where(function ($query) use ($data){
                return $query->where('phone', $data['phone']??'')
                ->where('user_type', $data['user_type']??'');
            });
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required','max:10','min:10','regex:/^[0-9]*$/',Rule::unique('users')->where(function ($query) use ($data){
                return $query->where('phone', $data['phone']??'')
                ->where('user_type', $data['user_type']??'');
            })],
            'user_type' => ['required'],
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->where(function ($query) use ($data){
                return $query->where('email', $data['email']??'')
                ->where('user_type', $data['user_type']??'');})],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        // dd($data
        $request = request();
        $profileImage = $request->file('profile_picture');
        $profileImageSaveAsName = time() . Auth::id() . "-profile." . $profileImage->getClientOriginalExtension();

        $upload_path = 'profile_images/';
        $profile_image_url = $upload_path . $profileImageSaveAsName;
        $success = $profileImage->move($upload_path, $profileImageSaveAsName);

        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'user_type' => $data['user_type'],
            'email' => $data['email'],
            'profile_picture' => $profile_image_url,
            'password' => Hash::make($data['password']),
        ]);
    }
}
