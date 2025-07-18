<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\Station;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

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
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $regions = Region::all();
        return view('auth.register', compact('regions'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'personal_number' => ['required', 'string', 'max:255', 'unique:users'],
            'region_id' => ['required', 'exists:regions,id'],
            'station_id' => ['required', 'exists:stations,id'],
            'designation' => ['required', 'in:Director General,Chief Meteorologist,Director (Engineering) / Principal Engineer,Director / Principal Meteorologist,Senior Private Secretary,Deputy Director / Senior Meteorologist,Senior Programmer,Deputy Chief Administrative Officer,Sr. Electronic Engineer / Deputy Director (Engineering),Administrative Officer,Meteorologist,Accounts Officer,Librarian,Security Officer,Electronics Engineer,Programmer,Assistant Meteorologist,Superintendent,Assistant Private Secretary,Assistant Programmer,Assistant Mechanical Engineer,Assistant Electronic Engineer,Head Draughtsman,Assistant Ministerial,Data Entry Operator,Meteorological Assistant,Stenotypist,Sub Engineer (Electronics),Sub Engineer (Mechanical),Mechanical Assistant,Draughtsman,Upper Division Clerk,Lower Division Clerk,Senior Observer,Observer'],
            'gender' => ['required', 'in:Male,Female,Other'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'personal_number' => $data['personal_number'],
            'region_id' => $data['region_id'],
            'station_id' => $data['station_id'],
            'designation' => $data['designation'],
            'gender' => $data['gender'],
            'status' => 'inactive', // Default to inactive until admin approval
        ]);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        auth()->logout();
        
        return redirect()->route('login')
            ->with('status', 'Your account has been registered successfully! You will be able to login once an administrator approves your account.');
    }
}