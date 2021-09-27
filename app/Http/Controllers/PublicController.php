<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendContactUsMail;
use Mail;
use App\Libraries\Shopify;
use App\Saved_items;
use App\User_sessions;
use App\Product;
use App\Categories;
use App\Menu;
use App\Review;
use App\Order;
use DateTime;

class PublicController extends Controller {

	public $vcode;
    public $s_redirect;
	public function verify_code($token) {
		Auth::logout();
		$result = User::where('token', $token)->first();
		Session::put('vtoken', $token);

		if($result && $result->email_verified_at === NULL) {
			Session::put('vcode', $result->verification_code);
			return view('verify', ['page_title' => 'User verify', 'user_id' => $result->id]);
		}
		else {
			return view('error', ['page_title' => 'Error']);
		}

	}

	public function process(Request $request) {
		$code = $request['code1'] . $request['code2'] . $request['code3'] . $request['code4'] . $request['code5'] . $request['code6'];
		if($code == Session::get('vcode')) {
			$user = User::where('verification_code', $code)->first();
			$user->email_verified_at = date("Y-m-d H:i:s");
			$user->save();
			Session::forget('vcode');
			Session::forget('vtoken');
            Auth::login($user);
			return redirect('/profile');
		}
		else {
			return redirect('/user/verify/'.Session::get('vtoken'))->with('verification_status', 'error');
		}

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

	public function register_company(Request $request) {

		$request->validate([
			'company_name' => ['required', 'string', 'max:255'],
			'company_web_address' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'location_code' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:255'],
            'address_line1' => ['required', 'string', 'max:255'],
            'address_line2' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string'],
            'city' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $comp_add = $request->get('address_line1') . " " . $request->get('address_line2') . " " . $request->get('city');
        $latlng = $this->get_coordinates($comp_add);

        $data = [
        	'name' => $request->get('first_name') . " " . $request->get('last_name'),
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'company_name' => $request->get('company_name'),
            'company_web_address' => $request->get('company_web_address'),
            'location_code' => $request->get('location_code'),
            'phone' => $request->get('phone'),
            'address_line1' => $request->get('address_line1'),
            'address_line2' => $request->get('address_line2'),
            'country' => $request->get('country'),
            'city' => $request->get('city'),
            'email' => $request->get('email'),
            'registration_type' => $request->get('registration_type'),
            'password' => Hash::make($request->get('password')),
            'verification_code' => $this->generatecode(6, 'numeric'),
            'lat' => $latlng[0],
            'lng' => $latlng[1],
            'token' => $this->generatecode(25, 'all'),
        ];

        if($file = $request->file('company_logo')) {
        	$data["company_logo"] = $file->getClientOriginalName();
        }

        $user = new User($data);
        $user->save();
        $user->sendEmailVerificationNotification();
        return redirect('/user/verify/'.$data["token"])->with('register_company_stat', 'success');

	}

    public function ajax_upload(Request $request) {
        $file = $request->file('image');
        $destinationPath = '../public/uploads';
        $file->move($destinationPath,$file->getClientOriginalName());
        echo json_encode($file->getClientOriginalName());
    }

	public function generatecode($length, $mode) {
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

    public function resend(Request $request) {
        $user = User::find($request->get('user_id'));
        if($user) {
            $user->verification_code = $this->generatecode(6, 'numeric');
            $user->save();
            $user->sendEmailVerificationNotification();
            return redirect('/user/verify/'.$user->token)->with('resend_status', 'sent');
        }
        else {
            return redirect('/error');
        }
    }

    public function shopify_login($pid) {
        $creds['shop_name']     = 'borrowbeez';
        $creds['api_key']       = '6eee231cb55ffa2d0db1fa6e3afeeb42';
        $creds['api_password']  = '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';
        $sp = new Shopify($creds);

        $product = $sp->s_get('/products/' . $pid . '.json');
        $redirect = htmlspecialchars($_GET['redirect']);
        $s_component = htmlspecialchars($_GET['component']);
        echo $s_component;
        if($product['httpcode'] != 200) {
            return redirect('/error');
        }
        else {
            if($user = Auth::user()) {
                if($s_component == 'wishlist') {
                    $this->add_to_wishlist($product, $redirect);
                    return redirect('/profile/favorite');
                }
                if($s_component == 'rating') {
                    return redirect('/rate?redirect=' . urlencode($redirect) . "&pid=" . $pid);
                }
            }
            else {
                return view('auth.s_login', ['page_title' => 'Shopify Login', 'component' => $s_component, 'redirect' => $redirect, 'pid' => $pid]);
            }

        }

    }

    public function shopify_login_process(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $creds['shop_name']     = 'borrowbeez';
            $creds['api_key']       = '6eee231cb55ffa2d0db1fa6e3afeeb42';
            $creds['api_password']  = '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';
            $sp = new Shopify($creds);

            if($request->get('component') == 'wishlist') {
                $product = $sp->s_get('/products/' . $request->get('product_id') . '.json');
                $this->add_to_wishlist($product, $request->get('redirect'));
                return redirect()->intended('/profile/favorite');
            }

            if($request->get('component') == 'rating') {
                return redirect()->intended('/rate?redirect=' . urlencode($request->get('redirect')) . "&pid=" . $request->get('product_id'));
            }
            // return redirect()->intended('profile');
        }
        else {
            return view('auth.s_login', ['login_error' => 'Incorrect credentials', 'component' => $request->get('component'), 'redirect' => $request->get('redirect'), 'pid' => $request->get('product_id')]);
        }

    }

    public function add_to_wishlist($product, $redirect) {
        if($product['httpcode'] == 200) {
            if(!$res = Saved_items::where('product_id', $product['result']->product->id)->first()) {
                $saved = new Saved_items([
                    "user_id" => Auth::user()->id,
                    "product_id" => $product['result']->product->id,
                    "name" => $product['result']->product->title,
                    "description" => $product['result']->product->body_html,
                    "vendor" => $product['result']->product->vendor,
                    "image" => $product['result']->product->image->src,
                    "url" => $redirect,
                    "created_at" => date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s')
                ]);
                $saved->save();
            }
        }
    }

    public function welcome() {
        if(Session::has('login_ref')) {
            $id = Session::get('login_ref');
            if(Product::find($id)) {
                Session::forget('login_ref');
                return redirect('/product/view/'.$id);
            }
        }

        $is_logged = Auth::check();
        $prod = Product::all();

        $new_in_area = [];
        $most_borrowed = [];
        $other = [];

        foreach($prod as $p) {
            $index = 0;
            $sum = 0;
            $res = Review::where("review_type", "product")->where("reference_id", $p->id)->get();
            $res2 = Order::where("product_id", $p->id)->where("rented", 1)->get();

            $vendor = User::find($p->vendor_id);
            foreach($res as $r) {
                $index++;
                $sum += $r->stars;
            }

            if($is_logged && $p->city == Auth::user()->city) {
               $new_in_area[] = (object)array(
                    "id" => $p->id,
                    "description" => $p->description,
                    "daily_aed" => $p->daily_aed,
                    "primary_img" => $p->primary_img,
                    "rating" => $index ? $sum/$index : 0,
                    "lat" => $p->lat,
                    "lng" => $p->lng,
                    "vendor_name" => $vendor->name,
                    "vendor_img" => $vendor->registration_type == 'individual' ? $vendor->profile_image : $vendor->company_logo,
                    "created_at" => $p->created_at,
                ); 
            }

            if($res2->count() > 0) {
               $most_borrowed[] = (object)array(
                    "id" => $p->id,
                    "description" => $p->description,
                    "daily_aed" => $p->daily_aed,
                    "primary_img" => $p->primary_img,
                    "rating" => $index ? $sum/$index : 0,
                    "lat" => $p->lat,
                    "lng" => $p->lng,
                    "vendor_name" => $vendor->name,
                    "vendor_img" => $vendor->registration_type == 'individual' ? $vendor->profile_image : $vendor->company_logo,
                    "created_at" => $p->created_at,
                ); 
            }

            $other[] = (object)array(
                "id" => $p->id,
                "description" => $p->description,
                "daily_aed" => $p->daily_aed,
                "primary_img" => $p->primary_img,
                "rating" => $index ? $sum/$index : 0,
                "lat" => $p->lat,
                "lng" => $p->lng,
                "vendor_name" => $vendor->name,
                "vendor_img" => $vendor->registration_type == 'individual' ? $vendor->profile_image : $vendor->company_logo,
                "created_at" => $p->created_at,
            );
        }

        // newest first
        usort($new_in_area, function($a, $b){
            $d1 = new DateTime($a->created_at);
            $d2 = new DateTime($b->created_at);
            return $d1 < $d2;
        });

        // highest rating first
        usort($most_borrowed, function($a, $b){
            return $a->rating < $b->rating;
        });

        // echo "<pre>";print_r($most_borrowed);exit;

        return view('welcome', [
            'logged' => $is_logged, 
            'user' => Auth::user(),
            'new' => $new_in_area,
            'most' => $most_borrowed,
            'other' => $other,
        ]);
    }

    public function category_route($name, Request $request) {
        $category = null;
        $sub_category = null;
        $item_type = null;
        $for_sale = null;
        $listed_business = null;
        $listed_individual = null;
        $f_date = null;
        $f_start = null;
        $f_end = null;
        $neighborhood = null;
        $condition = null;
        $age = null;
        $show_ads = isset($_GET['show_ads_photo']) && !empty($_GET['show_ads_photo']) ? $request->input('show_ads_photo') : null;
        $page_filter = isset($_GET['page_filter']) && !empty($_GET['page_filter']) ? $request->input('page_filter') : null;
        $level = $request->input('level');

        // search by keyword
        if(isset($_GET['keyword']) && !empty($_GET['keyword'])) {
            $q = htmlspecialchars($_GET['keyword']);
            $products = Product::where("item_name", "LIKE", "%".$q."%")->get();
        } // search by dropdowns
        elseif(isset($_GET['m']) && !empty($_GET['m'])) {
            $str = "SELECT * FROM products WHERE 1";
            $params = [];
            if(isset($_GET['category']) && !empty($_GET['category'])) {
                $str .= " AND category = '%s'";
                $params[] = $request->input('category');
                $category = $request->input('category');
            }
            if(isset($_GET['sub_category']) && !empty($_GET['sub_category'])) {
                $str .= " AND sub_category = '%s'";
                $params[] = $request->input('sub_category');
                $sub_category = $request->input('sub_category');
            }
            if(isset($_GET['item_type']) && !empty($_GET['item_type'])) {
                $str .= " AND item_type = '%s'";
                $params[] = $request->input('item_type');
                $item_type = $request->input('item_type');
            }
            if(isset($_GET['for_sale']) && !empty($_GET['for_sale'])) {
                $str .= " AND available_for_sale = '%s'";
                $params[] = $request->input('for_sale');
                $for_sale = $request->input('for_sale');
            }
            if(isset($_GET['listed_by_business']) && !empty($_GET['listed_by_business'])) {
                $str .= " AND listing_type = 'company'";
                $listed_business = 'company';
            }
            if(isset($_GET['listed_by_individual']) && !empty($_GET['listed_by_individual'])) {
                $str .= " AND listing_type = 'individual'";
                $listed_individual = 'individual';
            }
            if(isset($_GET['neigborhood']) && !empty($_GET['neigborhood'])) {
                $str .= " AND neighbourhood LIKE '%s'";
                $params[] = "%".$request->input('neigborhood')."%";
                $neighborhood = $request->input('neigborhood');
            }
            if(isset($_GET['condition']) && !empty($_GET['condition'])) {
                $str .= " AND item_condition = '%s'";
                $params[] = $request->input('condition');
                $condition = $request->input('condition');
            }
            if(isset($_GET['age']) && !empty($_GET['age'])) {
                $str .= " AND age = '%s'";
                $params[] = $request->input('age');
                $age = $request->input('age');
            }
            // last nani kay mayabag tungod sa OR
            if(isset($_GET['dr']) && !empty($_GET['dr'])) {
                $start = new DateTime($request->get('start_date'));
                $end = new DateTime($request->get('end_date'));
                $f_start = $request->get('start_date');
                $f_end = $request->get('end_date');
                $f_date = $request->get('dr');
                $str .= " AND (date_available < '%s' AND date_available < '%s' OR (date_available IS NULL AND sale_status != 'Sold'))";
                $params[] = $start->format('Y-m-d H:i:s');
                $params[] = $end->format('Y-m-d H:i:s');

                // $search_cat = Categories::where("slug", $name)->first();
                // $str .= " AND (category = '".$search_cat->category_name."' OR sub_category = '".$search_cat->category_name."' OR item_type = '".$search_cat->category_name."')";
            }
            
            $products = DB::select(vsprintf($str, $params));
        }
        else {
            $cat = Categories::where("slug", $name)->first();
            if(!$cat) {
                return redirect('error');
            }
            $products = Product::where("category", $cat->category_name)
                        ->orWhere("sub_category", $cat->category_name)
                        ->orWhere("item_type", $cat->category_name)
                        ->get();    
        }
        

        $menu = Menu::all();
        if(count($menu) != 0) {
            $json = json_decode($menu[0]->menu_json);
            $categories = [];
            $level_2 = [];
            foreach($json[0] as $j) { // parent
                $categories[$j->name] = [];
                if(count($j->children[0])) {
                    foreach($j->children[0] as $k) { // 1st child
                        $categories[$j->name][$k->name] = [];
                        if(count($k->children[0])) {
                            foreach($k->children[0] as $l) { //2nd child
                                if($level == $k->name) {
                                    $level_2[] = $l->name;
                                }
                                $categories[$j->name][$k->name][] = $l->name;
                            }
                        }
                    }
                }
            }
            $output = json_encode($categories);
        }
        else {
            $output = json_encode([]);
        }

        sort($level_2);

        $product_data = [];
        foreach($products as $p) {
            $result = Review::where("reference_id", $p->id)->where("review_type", "product")->get();
            $sum = 0;
            $index = 0;
            foreach($result as $r) {
                $index++;
                $sum += $r->stars;
            }

            $stat = "Available for rent!";
            if($p->sale_status == "Sold") {
                $stat = "Sold";
            }
            elseif($p->rent_status == 'Currently Rented') {
                $tmp = new DateTime($p->date_available);
                $stat = "Available from: " . $tmp->format("d M Y");
            }
            elseif(!($p->rental_duration_daily || $p->rental_duration_weekly || $p->rental_duration_monthly)) {
                $stat = "Not avaialble for rent";
            }

            $product_data[] = (object)array(
                "id" => $p->id,
                "description" => $p->description,
                "daily_aed" => $p->daily_aed,
                "weekly_aed" => $p->weekly_aed,
                "monthly_aed" => $p->monthly_aed,
                "primary_img" => $p->primary_img,
                "rating" => $index ? $sum/$index : 0,
                "status" => $stat,
                "lat" => $p->lat,
                "item_name" => $p->item_name,
                "lng" => $p->lng,
                "rental_duration_daily" => $p->rental_duration_daily,
                "rental_duration_weekly" => $p->rental_duration_weekly,
                "rental_duration_monthly" => $p->rental_duration_monthly,
                "rent_status" => $p->rent_status,
                "for_sale_only" => (!$p->rental_duration_daily && !$p->rental_duration_weekly && !$p->rental_duration_monthly) && $p->available_for_sale == 'yes',
                "sale_price" => $p->sale_price,
            );
        }

        // filters
        if(isset($_GET['page_filter']) && !empty($_GET['page_filter'])) {
            if($_GET['page_filter'] == 'nearest') {
               $product_data = $this->sort_nearest($product_data);
            }
            if($_GET['page_filter'] == 'user_rating') {
                usort($product_data, function($a, $b){
                    $d1 = $a->rating;
                    $d2 = $b->rating;
                    return $d1 < $d2;
                });
            }
            if($_GET['page_filter'] == 'price_lowest') {
                usort($product_data, function($a, $b){
                    $d1 = $a->daily_aed;
                    $d2 = $b->daily_aed;
                    return $d1 > $d2;
                });
            }
            if($_GET['page_filter'] == 'price_highest') {
                usort($product_data, function($a, $b){
                    $d1 = $a->daily_aed;
                    $d2 = $b->daily_aed;
                    return $d1 < $d2;
                });
            }
        }



        return view('public.search', [
            'page_title' => 'Search', 
            'content_header' => 'layouts/main_menu', 
            'products' => $product_data, 
            'user' => Auth::user(), 
            'json' => $output,
            'category' => $category,
            'sub_category' => $sub_category,
            'item_type' => $item_type,
            'for_sale' => $for_sale,
            'listed_business' => $listed_business,
            'listed_individual' => $listed_individual,
            'f_date' => $f_date,
            'f_start' => $f_start,
            'f_end' => $f_end,
            'neighborhood' => $neighborhood,
            'condition' => $condition,
            'age' => $age,
            'show_ads' => $show_ads,
            'dist_url' => $name,
            'page_filter' => $page_filter,
            'level' => $level_2,
        ]);        
    }

    // formula from https://stackoverflow.com/questions/10053358/measuring-the-distance-between-two-coordinates-in-php
    public function haversine($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000) {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return $angle * $earthRadius;
    }

    public function sort_nearest($data) {
        $temp = [];
        $geo_data = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
        // echo "<pre>";
        // print_r($geo_data);
        // exit;

        if(Auth::check()) {
            $lat = Auth::user()->lat;
            $lng = Auth::user()->lng;
        }  
        elseif($geo_data['geoplugin_request'] == '127.0.0.1') { // for local host
            $lat = 25.2559671;
            $lng = 55.29583969999999;
        }
        else {
            $lat = $geo_data['geoplugin_latitude'];
            $lng = $geo_data['geoplugin_longitude'];
        }

        foreach($data as $d) {
            $distance = ceil($this->haversine($lat, $lng, $d->lat, $d->lng));
            $temp[] = (object)array(
                "id" => $d->id,
                "description" => $d->description,
                "daily_aed" => $d->daily_aed,
                "primary_img" => $d->primary_img,
                "rating" => $d->rating,
                "status" => $d->status,
                "lat" => $d->lat,
                "lng" => $d->lng,
                "distance" => $distance,
            );
        }

        usort($temp, function($a, $b){
            $d1 = $a->distance;
            $d2 = $b->distance;
            return $d1 > $d2;
        });

        return $temp;
    }

    public function single($id) {
        $product = Product::find($id);
        $vendor = User::find($product->vendor_id);
        return view('product.single', [
            'page_title' => $product->item_name, 
            'content_header' => 'layouts/main_menu',
            'product' =>  $product, 
            'user' => Auth::user(),
            'vendor' => $vendor,
            'images' => json_decode($product->images),
        ]);
    }

    public function send_contact_us_mail(Request $request) {
        $email = $request->get('email');
        $data = array(
            "from" => $request->get('name'),
            "phone" => $request->get('phone'),
            "message" => $request->get('message'),
        );
        Mail::to($email)->send(new SendContactUsMail($data));
        return redirect('pages/contact')->with('contact_sent', '1');
    }

    public function footer_page($name) {
        return view('pages.'.$name, [
            'page_title' => ucwords($name),
            'content_header' => 'layouts/main_menu',
            'user' => Auth::user()
        ]);  
    }

    public function product_view($id) {
        if($product = Product::find($id)) {
            $other_products = Product::where("vendor_id", $product->vendor_id)->limit(3)->get();
            $oth = [];

            $now = new DateTime();
            $avail = new DateTime($product->date_available);
            $available_now = $avail < $now;

            foreach($other_products as $op) {
                $result = Review::where("reference_id", $op->id)->where("review_type", "product")->get();
                $index = 0;
                $sum = 0;

                foreach($result as $res) {
                    $index++;
                    $sum += $res->stars;
                }
                $oth[] = (object)array(
                    "id" => $op->id,
                    "daily_aed" => $op->daily_aed,
                    "description" => $op->description,
                    "primary_img" => $op->primary_img,
                    "rating" => $index ? $sum/$index : 0,
                );
            }

            $p_reviews = Review::where("review_type", "product")->where("reference_id", $id)->get();
            $pr_index = 0;
            $pr_sum = 0;
            foreach($p_reviews as $pr) {
                $pr_index++;
                $pr_sum += $pr->stars;
            }

            $v_data = Review::where("reference_id", $product->vendor_id)->where("review_type", "user")->latest()->get();

            $vendor = User::find($product->vendor_id);
            $avatar = $vendor->registration_type == 'individual' ? $vendor->profile_image : $vendor->company_logo;
            $product->for_rent = ($product->rental_duration_daily || $product->rental_duration_weekly || $product->rental_duration_monthly);

            return view('order.create', [
                'content_header' => 'layouts/order_breadcrumbs',
                'sidebar' => false,
                'product' => $product,
                'avatar' => $avatar,
                'other' => $oth,
                'vendor' => $vendor->name,
                'user' => Auth::user(),
                'vendor_review'=> $v_data,
                'available_now' => $available_now,
                'pr_rating' => $pr_index ? $pr_sum/$pr_index : 0,
            ]);
        }
        else {
            return redirect('error');
        }
    }

    public function mark_as_available(Request $request) {
        $id = $request->get('product_id');
        if($product = Product::find($id)) {
            $product->rent_status = '';
            $product->date_rented = NULL;
            $product->date_available = NULL;
            $product->save();

            if($order = Order::find($product->order_id)) {
                $order->status = 'Done';
                $order->save();

            }
            return redirect($request->get('referrer'))->with('product_update', 'success');
        }
        else {
            return redirect('error');
        }
    }

}
