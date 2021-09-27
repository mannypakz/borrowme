<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Redirect;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        if(isset($_GET['ref']) && !empty($_GET['ref'])) {
            Session::put('login_ref', htmlspecialchars($_GET['ref']));
        }
    }

    public function facebookRedictToProvider() {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookProviderCallback() {
        try {
            $user = Socialite::driver('facebook')->user(); 
            $this->authUser($user, 'facebook');
            return redirect('/profile');   
        }
        catch(Exception $e) {
            return redirect('/error');
        }
        
    }

    public function googleRedictToProvider() {
        return Socialite::driver('google')->redirect();
    }

    public function googleProviderCallback() {
        try {
            $user = Socialite::driver('google')->user();
            echo "<pre>";
            // echo $user->avatar;
            $extension = pathinfo(parse_url($user->avatar, PHP_URL_PATH), PATHINFO_EXTENSION);
            // echo $extension;
            // print_r($user->user);
            $filename = $user->user['given_name'].time().".".$extension;
            file_put_contents("../public/uploads/".$filename, file_get_contents($user->avatar));
            // exit;
            $this->authUser($user, 'google', $filename);
            return redirect('/profile');
        }
        catch(Exception $e) {
            return redirect('/error');
        }
    }

    public function authUser($user, $source, $filename = NULL) {
        $result = User::where('provider_id', $user->getId())->first();
        if($result) {
            Auth::login($result);
        }
        else {
            switch($source) {
                case 'google':
                    $newUser = User::create([
                        'name' => $user->name,
                        'role' => 0,
                        'first_name' => $user->user['given_name'],
                        'last_name' => $user->user['family_name'],
                        'registration_type' => 'individual',
                        'email' => $user->email,
                        'provider_id' => $user->getId(),
                        'login_source' => $source,
                        'profile_image' => $filename,
                        'password' => Hash::make('tempPassword!23'),
                        'email_verified_at' => date("Y-m-d H:i:s"),
                    ]);
                    break;
                default:
                    break;

            }
            
            Auth::login($newUser);
        }
    }
    
}
