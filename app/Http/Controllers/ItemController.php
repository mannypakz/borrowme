<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Product;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Libraries\Shopify;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Saved_items;
use DateTime;
use Illuminate\Support\Facades\Storage; 
use App\Order;

class ItemController extends Controller {
	protected $sp;

	public function __construct()
    {
        $this->middleware('auth');
        $creds['shop_name']     = 'borrowbeez';
        $creds['api_key']       = '6eee231cb55ffa2d0db1fa6e3afeeb42';
        $creds['api_password']  = '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';
        $this->sp = new Shopify($creds);
    }

    public function limit_text($text, $limit) {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos   = array_keys($words);
            $text  = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }

    public function index() {
    	$results = Product::where("vendor_id", Auth::user()->id)->where("sale_status", "<>", "Sold")->get();
        $products = [];
        foreach($results as $result) {
            $d = new DateTime($result->date_available);
            $products[] = (object)array(
                'id' => $result->id,
                'item_name' => $result->item_name,
                'description' => $result->description,
                'primary_image' => $result->primary_img,
                'date_available' => $result->date_available ? $d->format('d M Y') : '',
                'description' => $result->description,
                'rental_duration_daily' => $result->rental_duration_daily,
                'rental_duration_weekly' => $result->rental_duration_weekly,
                'rental_duration_monthly' => $result->rental_duration_monthly,
                'daily_aed' => $result->daily_aed,
                'weekly_aed' => $result->weekly_aed,
                'monthly_aed' => $result->monthly_aed,
                'rent_status' => $result->rent_status,
                'sale_status' => $result->sale_status,
            );
        }
        // echo "<pre>";
        // print_r($products);
    	return view('item.index', ['page_title' => 'Item Management', 'content_header' => 'layouts/main_menu', 'products' => $products, 'user' => Auth::user()]);
    }

    public function delete_product(Request $request) {
        $product = Product::find($request->get('product_id'));
        echo "<pre>";
        echo file_exists('../public/uploads/'.$product->primary_img);
        $images = json_decode($product->images);
        foreach($images as $image) {
            if(file_exists('../public/uploads/'.$image)) {
                unlink('../public/uploads/'.$image);
            }
        }
        $product->delete();
        return redirect('item');
    }

    public function history(Request $request) {
        $orders = Order::where("vendor_id", Auth::user()->id)->get();
        $products = [];
        foreach($orders as $order) {
            $products[] = Product::find($order->product_id);
        }
        // $products = Product::where("vendor_id", Auth::user()->id)->get();
        $sort = isset($_GET['sort']) && !empty($_GET['sort']) ? $request->input('sort') : 'new_to_old';
        $filter = isset($_GET['filter']) && !empty($_GET['filter']) ? $request->input('filter') : 'all';

        $product_data = [];
        
        foreach($products as $p) {
            $index = 0;
            $sum = 0;

            if(!isset($p) || empty($p)) {
                continue;
            }
            
            if(isset($p) && !empty($p)) {
                $result = Review::where("review_type", "product")->where("reference_id", $p->id)->get();
                foreach($result as $res) {
                    $index++;
                    $sum += $res->stars;
                }
            }
            if(isset($p) && !empty($p)) {
                $provided_review = Review::where("review_type", "product")->where("reference_id", $p->id)->where("user_id", Auth::user()->id)->get();
            }

            $stat = 'Active';
            if($p->sale_status == 'Sold') {
                $stat = 'Completed';
            }
            $rd = new DateTime($p->date_rented);
            $ad = new DateTime($p->date_available);

            if($filter == 'all') {
                $product_data[] = (object)array(
                    "id" => $p->id,
                    "primary_img" => $p->primary_img,
                    "sale_status"=> $p->sale_status,
                    "rent_status" => $p->rent_status,
                    "item_type" => $p->item_type,
                    "daily_aed" => $p->daily_aed,
                    "date_rented" => $p->date_rented ? $rd->format('d M Y') : '',
                    "date_available" => $p->date_available ? $ad->format('d M Y') : '',
                    "rating" => $index ? $sum/$index : 0,
                    "status" => $stat,
                    "created_at" => $p->created_at,
                    "provided_review" => $provided_review ?? null,
                );
            }
            elseif($stat == ucwords($filter)) {
                $product_data[] = (object)array(
                    "id" => $p->id,
                    "primary_img" => $p->primary_img,
                    "sale_status"=> $p->sale_status,
                    "rent_status" => $p->rent_status,
                    "item_type" => $p->item_type,
                    "daily_aed" => $p->daily_aed,
                    "date_rented" => $p->date_rented ? $rd->format('d M Y') : '',
                    "date_available" => $p->date_available ? $ad->format('d M Y') : '',
                    "rating" => $index ? $sum/$index : 0,
                    "status" => $stat,
                    "created_at" => $p->created_at,
                    "provided_review" => $provided_review ?? null,
                );
            }
        }

        if($sort == 'old_to_new') {
            usort($product_data, function($a, $b){
                $d1 = new DateTime($a->created_at);
                $d2 = new DateTime($b->created_at);
                return $d1 > $d2;
            });
        }
        if($sort == 'new_to_old') {
            usort($product_data, function($a, $b){
                $d1 = new DateTime($a->created_at);
                $d2 = new DateTime($b->created_at);
                return $d1 < $d2;
            });
        }
        // echo "<pre>";print_r($product_data);exit;
        return view('item.history', [
            'page_title' => 'Item History', 
            'content_header' => 'layouts/main_menu', 
            'products' => $product_data, 
            'user' => Auth::user(), 
            'filter' => $filter, 
            'sort' => $sort
        ]);
    }

    public function date_sort($a, $b) {
        $d1 = new DateTime($a->created_at);
        $d2 = new DateTime($b->created_at);
        return $d1 < $d2;
    }

    public function store_review(Request $request) {
        
        if(null !== $request->get('product_id')) {
            $type = "product";
            $id = $request->get('product_id');
            $stars = $request->get('stars');
        }
        elseif($request->get('type') == 'user') {
            $type = "user";
            $id = Auth::user()->id;
            $stars = $request->get('user_stars');
        }
        else {
            $type = "order";
            $id = $request->get('order_id');
            $stars = $request->get('stars');
        }
        
        $review = new Review([
            "review_type" => $type,
            "reference_id" => $id,
            "feedback" => $request->get('feedback'),
            "user_id" => Auth::user()->id,
            "stars" => $stars,
            "created_at" => date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s')
        ]);
        $review->save();
        if($request->get('ref')) {
            return redirect($request->get('ref'));
        }
        return redirect('item')->with('review_status', 'success');
    }

    public function ajax_get_reviews(Request $request) {
        if(null !== $request->get('product_id')) {
            $id = $request->get('product_id');
        }
        else {
            $id = $request->get('order_id');
        }
        $results = Review::where('reference_id', $id)->get();
        echo json_encode($results);
    }

    public function wishlist() {
        $saved_items = Saved_items::where("user_id", Auth::user()->id)->get();
        return view('wishlist', ['saved_items' => $saved_items]);
    }

    public function user_review($id) {
        $reviews = Review::where("reference_id", $id)->where('review_type', 'user')->get();
        $data = [];
        foreach($reviews as $review) {
            $user = User::find($review->reference_id);
            $data[] = (object)array(
                'feedback' => $review->feedback,
                'stars' => $review->stars,
                'reviewer' => $user->name,
                'image' => $user->registration_type == 'individual' ? $user->profile_image : $user->company_logo,
                'created_at' => $review->created_at,
            );
        }
        return view('item.view_review', ['user' => Auth::user(), 'content_header' => 'layouts/main_menu', 'data' => $data]);
    }
}