<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile; // Add this line
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
    protected $redirectTo = RouteServiceProvider::HOME;

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
        $rules = [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'status' => ['required', 'string', 'in:admin,user'],
            'phone' => ['required', 'string', 'max:20'],
        ];
    
        // Add the 'nullable' and 'image' rules if 'upload' is provided
        if (isset($data['upload'])) {
            $rules['upload'] = ['nullable', 'image', 'mimes:jpeg,jpg,png'];
        }
    
        return Validator::make($data, $rules);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
       // Handle the file upload
    if (isset($data['upload'])) {
        $uploadedFile = $data['upload'];
        $uploadPath = 'uploads'; // Relative to the 'public' directory

        // Generate a unique filename for the uploaded image
        $fileName = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();

        // Move the uploaded image to the public/uploads directory
        $uploadedFile->move(public_path($uploadPath), $fileName);

        // Build the full path to the uploaded image
        $uploadedFilePath = $uploadPath . '/' . $fileName;
    } else {
        // If no file is uploaded, set the path to null
        $uploadedFilePath = null;
    }

        return User::create([
            'username' => $data['username'], // 'name' field may be replaced with 'username'
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => $data['status'],
            'phone' => $data['phone'],
            'file' => $uploadedFilePath, // Save the uploaded file path

        ]);
    }
}
