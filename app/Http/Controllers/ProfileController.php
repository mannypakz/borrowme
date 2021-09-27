<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Libraries\Shopify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\User;
use App\User_sessions;
use App\Saved_items;
use App\Review;

class ProfileController extends Controller {
	protected $sp;

	public function __construct() {
		$this->middleware('auth');
		$creds['shop_name']     = 'borrowbeez';
        $creds['api_key']       = '6eee231cb55ffa2d0db1fa6e3afeeb42';
        $creds['api_password']  = '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';
        $this->sp = new Shopify($creds);
	}

	public function index() {
		$user = Auth::user();
		return view('profile.index', ['page_title' => 'Profile Details', 'content_header' => 'layouts/main_menu', 'user' => $user]);
	}

	public function favorite() {
		$saved_items = Saved_items::where("user_id", Auth::user()->id)->get();
		
		return view('profile.favorite', ['page_title' => 'Profile Favorite', 'content_header' => 'layouts/main_menu', 'saved' => $saved_items, 'user' => Auth::user()]);	
	}

	public function update(Request $request) {
		$type = $request->get('registration_type');
		$user = User::find($request->get('user_id'));
		echo "<pre>";
		
		if($type == 'individual') {
			$request->validate([
            	'first_name' => ['required', 'string', 'max:255'],
            	'last_name' => ['required', 'string', 'max:255'],
            	'phone' => ['required', 'string', 'max:255'],
            	'address_line1' => ['required', 'string', 'max:255'],
            	'address_line2' => ['required', 'string', 'max:255'],
            	// 'country' => ['required', 'string'],
            	'city' => ['required', 'string'],
            	'email' => ['required', 'string', 'email', 'max:255'],
			]);

			$user->first_name = $request->get('first_name');
			$user->last_name = $request->get('last_name');
			$user->phone = $request->get('phone');
			$user->address_line1 = $request->get('address_line1');
			$user->address_line2 = $request->get('address_line2');
			$user->country = $request->get('country');
			$user->city = $request->get('city');
			$user->email = $request->get('email');
			
			if($file = $request->file('image')) {
        		$user->profile_image = $request->get('filename');
        	}
		}
		else {
			$request->validate([
				'company_name' => ['required', 'string', 'max:255'],
				'company_web_address' => ['required', 'string', 'max:255'],
            	'first_name' => ['required', 'string', 'max:255'],
            	'last_name' => ['required', 'string', 'max:255'],
            	'phone' => ['required', 'string', 'max:255'],
            	'address_line1' => ['required', 'string', 'max:255'],
            	'address_line2' => ['required', 'string', 'max:255'],
            	// 'country' => ['required', 'string'],
            	'city' => ['required', 'string'],
            	'email' => ['required', 'string', 'email', 'max:255'],
			]);

			
			$user->company_name = $request->get('company_name');
			$user->company_web_address = $request->get('company_web_address');
			$user->first_name = $request->get('first_name');
			$user->last_name = $request->get('last_name');
			$user->phone = $request->get('phone');
			$user->address_line1 = $request->get('address_line1');
			$user->address_line2 = $request->get('address_line2');
			$user->country = $request->get('country');
			$user->city = $request->get('city');
			$user->email = $request->get('email');
			
			if($file = $request->file('image')) {
        		$user->company_logo = $request->get('filename');
        	}
		}
		$user->save();
		// exit;
		return redirect('/profile');
	}

	public function ajax_upload(Request $request) {
        $file = $request->file('image');
        $destinationPath = '../public/uploads';
        $name = $file->getClientOriginalName();
        if(file_exists($destinationPath."/".$file->getClientOriginalName())) {
        	$ext = $file->extension($name);
        	$date = time();
        	$name = $date . "." . $ext;
        }
        $file->move($destinationPath,$name);
        echo json_encode($name);
    }

    public function rate() {
    	$redirect = htmlspecialchars($_GET['redirect']);
    	$pid = htmlspecialchars($_GET['pid']);
    	return view('/rate', ['redirect' => $redirect, 'product_id' => $pid]);
    }

    public function rate_store(Request $request) {
    	echo "<pre>";
    	$request->validate([
    		"feedback" => "required"
    	]);

    	$review = new Review([
            "review_type" => "product",
            "reference_id" => $request->get('product_id'),
            "user_id" => Auth::user()->id,
            "feedback" => $request->get('feedback'),
            "stars" => $request->get('stars'),
            "created_at" => date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s')
        ]);

        $reviews = Review::where("reference_id", $request->get('product_id'))->get();
        $total = 0;
        for($i = 0; $i < count($reviews); $i++) {
        	$total += $reviews[$i]->stars;
        }
        $m = $this->sp->s_get('/products/' . $request->get('product_id') . '/metafields.json');
        
        $average = $request->get('stars');
        if($i > 0) {
        	$average = floor($total/$i);
        }

        foreach($m['result']->metafields as $meta) {
        	if($meta->namespace == 'rating') {
        		$metafield = (object)array(
                	"metafield" => (object)array(
                    	"id" => $meta->id,
                    	"value" => $average
                	)
            	);
            	$r = $this->sp->s_put("metafields/".$meta->id.".json", $metafield);
        	}

            if($meta->namespace == 'review') {
                $metafield = (object)array(
                    "metafield" => (object)array(
                        "id" => $meta->id,
                        "value" => $request->get('feedback')
                    )
                );
                $r = $this->sp->s_put("metafields/".$meta->id.".json", $metafield);
            }

        }
        
        // echo $total/$i;
        $review->save();
        return redirect($request->get('redirect'));
    }

}