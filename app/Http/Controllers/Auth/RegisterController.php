<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected $token;
    protected $redirectTo = '/user/verify/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->token = $this->generatecode(25, 'all');
        $this->redirectTo .= $this->token;
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'location_code' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:255'],
            'address_line1' => ['required', 'string', 'max:255'],
            'address_line2' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string'],
            'city' => ['required', 'string'],
            // 'neighbourhood' => ['required', 'array'],
            // 'neighbourhood.*' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
        // echo "<pre>";
        // print_r($data);
        // exit;
        $nb = implode(",", $data['neighbourhood']);
        
        $address = $data['address_line1'] . " " . $data['address_line2'] . " " . $data['city'];
        $latlng = $this->get_coordinates($address);

        return User::create([
            'name' => $data['first_name'] . " " . $data['last_name'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'location_code' => $data['location_code'],
            'phone' => $data['phone'],
            'address_line1' => $data['address_line1'],
            'address_line2' => $data['address_line2'],
            'country' => $data['country'],
            'city' => $data['city'],
            'neighbourhood' => $nb,
            'email' => $data['email'],
            'registration_type' => $data['registration_type'],
            'password' => Hash::make($data['password']),
            'verification_code' => $this->generatecode(6, 'numeric'),
            'token' => $this->token,
            'lat' => $latlng[0],
            'lng' => $latlng[1],
            'profile_image' => 'default6738888.jpg',
            ]);
    }

    protected function generatecode($length, $mode) {
        $numeric = "1234567890";
        $all = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";

        if($mode == 'numeric') {
            $str = $numeric;    
        }
        else {
            $str = $all;
        }

        $len = strlen($str) - 1;
        $val = '';
        for($i = 0; $i < $length; $i++) {
            $val .= $str[rand(0, $len)];
        }

        return $val;
    }

    public function get_coordinates($address) {
        $lat = '';
        $long = '';

        $apikey = 'AIzaSyAIISsYkS-hwalG7P-iknMoisUzRCyBbz0';

        $add = str_replace(" ", "+", $address);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://maps.googleapis.com/maps/api/geocode/json?address=" . $add . "&key=" . $apikey);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        $geocode = json_decode($result);
        if(count($geocode->results)) {
            $lat = $geocode->results[0]->geometry->location->lat;
            $long = $geocode->results[0]->geometry->location->lng;
        }
        return array($lat, $long);
    }
}
