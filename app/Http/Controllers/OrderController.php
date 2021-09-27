<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\Shopify;
use Illuminate\Support\Facades\Auth;
use App\Order;
use App\Product;
use App\Review;
use App\Services\OrderService;
use DateTime;
use App\User;
use App\Saved_items;
use Carbon\Carbon;

class OrderController extends Controller {
    protected $sp;
    protected $orderService;

	public function __construct(OrderService $orderService)
    {
        $this->middleware('auth');
        $creds['shop_name']     = 'borrowbeez';
        $creds['api_key']       = '6eee231cb55ffa2d0db1fa6e3afeeb42';
        $creds['api_password']  = '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';
        $this->sp = new Shopify($creds);
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $reviewStatus = '';
        $filter = isset($_GET['filter']) && !empty($_GET['filter']) ? htmlspecialchars($_GET['filter']) : 'all';
        $sort = isset($_GET['sort']) && !empty($_GET['sort']) ? htmlspecialchars($_GET['sort']) : 'new_to_old';
        $orders = $this->orderService->getAllOrders();

        foreach ($orders as $key => $order) {
            $orders[$key] = $this->appendOrderData($order, 'history');
        }

        if ($request->session()->get('review_status')) {
            $reviewStatus = $request->session()->get('review_status');
        }

        return view('order.index', [
            'page_title' => 'Order History',
            'content_header' => 'layouts/main_menu',
            'filter' => $filter,
            'sort' => $sort,
            'orders' => $orders,
            'user' => Auth::user(),
            'review_status' => $reviewStatus
        ]);
    }

    public function history(Request $request) {
        $orders = Order::where("purchaser", Auth::user()->id)->get();
        $filter = isset($_GET['filter']) && !empty($_GET['filter']) ? $request->input('filter') : 'all';
        $sort = isset($_GET['sort']) && !empty($_GET['sort']) ? $request->input('sort') : 'new_to_old';

        $data = [];
        foreach($orders as $o) {
            $index = 0;
            $sum = 0;
            $result = Review::where("review_type", "order")->where("reference_id", $o->id)->get();
            foreach($result as $r) {
                $index++;
                $sum += $r->stars;
            }

            $stat = 'Active';
            if($o->status == 'Purchased') {
                $stat = 'Completed';
            }

            $rd = new DateTime($o->date_rented);
            $ad = new DateTime($o->date_available);

            $p = Product::find($o->product_id);

            if($filter == 'all') {
                $data[] = (object)array(
                    "id" => $o->id,
                    "primary_img" => $p->primary_img ?? '',
                    "item_type" => $p->item_type ?? '',
                    "daily_aed" => $p->daily_aed ?? '',
                    "date_rented" => $o->date_rented ? $rd->format('d M Y') : '',
                    "date_available" => $o->date_available ? $ad->format('d M Y') : '',
                    "rating" => $index ? $sum/$index : 0,
                    "p_status" => $stat,
                    "status" => $o->status,
                    "created_at" => $o->created_at,
                );
            }
            elseif($stat == ucwords($filter)) {
                $data[] = (object)array(
                    "id" => $o->id,
                    "primary_img" => $p->primary_img,
                    "item_type" => $p->item_type,
                    "daily_aed" => $p->daily_aed,
                    "date_rented" => $o->date_rented ? $rd->format('d M Y') : '',
                    "date_available" => $o->date_available ? $ad->format('d M Y') : '',
                    "rating" => $index ? $sum/$index : 0,
                    "p_status" => $stat,
                    "status" => $o->status,
                    "created_at" => $o->created_at,
                );
            }
        }

        if($sort == 'old_to_new') {
            usort($data, function($a, $b){
                $d1 = new DateTime($a->created_at);
                $d2 = new DateTime($b->created_at);
                return $d1 > $d2;
            });
        }
        if($sort == 'new_to_old') {
            usort($data, function($a, $b){
                $d1 = new DateTime($a->created_at);
                $d2 = new DateTime($b->created_at);
                return $d1 < $d2;
            });
        }


    	return view('order.history', [
            'page_title' => 'Order History',
            'content_header' => 'layouts/main_menu',
            'orders' => $data,
            'user' => Auth::user(),
            'filter' => $filter,
            'sort' => $sort
        ]);

    }
    public function create($id) {
        $product = Product::find($id);
        $other_products = Product::where("vendor_id", $product->vendor_id)->limit(3)->get();
        $oth = [];

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

        $v_data = Review::where("reference_id", $product->vendor_id)->where("review_type", "user")->latest()->get();

        $vendor = User::find($product->vendor_id);
        $avatar = $vendor->registration_type == 'individual' ? $vendor->profile_image : $vendor->company_logo;
        
        
        return view('order.create', [
            'content_header' => 'layouts/order_breadcrumbs',
            'sidebar' => false,
            'product' => $product,
            'avatar' => $avatar,
            'other' => $oth,
            'vendor' => $vendor->name,
            'user' => Auth::user(),
            'vendor_review'=> $v_data,
            'for_rent' => $p->rental_duration_daily || $p->rental_duration_weekly || $p->rental_duration_monthly,
        ]);
    }

    public function checkout(Request $request) {
        $rent = 0;
        $sale = 0;
        $status = "";
        $date_rented = NULL;
        $date_available = NULL;
        $price = 0;

        if($request->get('order_type') == 'rent') {
            $rent = 1;
            $status = "Currently Borrowing";
            $d1 = new DateTime($request->get('start_date'));
            $d2 = new DateTime($request->get('end_date'));
            $date_rented = $d1->format("Y-m-d");
            $date_available = $d2->format("Y-m-d");
            $price = $request->get("price");

            $product = Product::find($request->get("product_id"));
            $product->rent_status = "Currently Rented";
            $product->date_rented = $date_rented;
            $product->date_available = $date_available;
        }
        if($request->get('order_type') == 'sale') {
            $sale = 1;
            $status = "Purchased";
            $price = $request->get('sale_price');

            $product = Product::find($request->get("product_id"));
            $product->sale_status = "Sold";
            $product->available_for_sale = "no";
        }

        // print_r($date_available);
        // exit;

        $order = new Order([
            "vendor_id" => $request->get("vendor_id"),
            "purchaser" => Auth::user()->id,
            "product_id" => $request->get("product_id"),
            "rented" => $rent,
            "bought" => $sale,
            "status" => $status,
            "price" => $price,
            "order_type" => $request->get('order_type'),
            "date_rented" => $date_rented,
            "date_available" => $date_available
        ]);


        if(!$order->save()) {
            return redirect('error');
        }
        else {
            $product->order_id = $order->id;
            $product->save();
            return redirect('orders/history');
        }
    }

    public function save_item(Request $request) {
        $saved = Saved_items::where("product_id", $request->get('wishlist_product_id'))->get();
        
        if(!isset($saved) && empty($saved)) {
            $si = new Saved_items([
                "user_id" => Auth::user()->id,
                "product_id" => $request->get('wishlist_product_id'),
                "name" => $request->get('wishlist_product_name'),
                "description" => $request->get('wishlist_description'),
                "vendor" => $request->get('wishlist_vendor'),
                "image" => $request->get('wishlist_image'),
                "url" => $request->get('wishlist_url')
            ]);

            $si->save();
        }
        return redirect('profile/favorite');        
    }

    public function review(int $orderId)
    {
        $order = $this->appendOrderData($this->orderService->getOrder($orderId), 'review');

        return view('order.review', [
            'page_title' => 'Order History',
            'content_header' => 'layouts/main_menu',
            'user' => Auth::user(),
            'data' => $order
        ]);
    }

    public function rate(Request $request)
    {
        $review = new Review([
            "review_type" => 'order',
            "reference_id" => $request->get('order_id'),
            "feedback" => $request->get('feedback'),
            "user_id" => Auth::user()->id,
            "stars" => $request->get('stars'),
            "created_at" => date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s')
        ]);

        $success = $review->save();

        if (!$success) {
            // return response()->json('Failed to rate this order', 500);
            return redirect('orders')->with('review_status', 'Failed to rate this order');

        }

        // return response()->json('Success! Your review for this order has been saved.', 200);
        return redirect('orders')->with('review_status', 'Success! Your review for this order has been saved');
    }

    protected function appendOrderData(array $order, string $page)
    {
        $format = '';

        if ($page === 'review') {
            $format = 'dS F';
        }

        if ($page === 'history') {
            $format = 'd M Y';
        }

        if (isset($order['date_rented'])) {
            $order['start_date'] = $this->parseDateFormat($order['date_rented'], $format);
            $order['duration'] = $this->calculateDuration($order['date_rented'], $order['date_available']);
        } else {
            $order['start_date'] = '';
            $order['duration'] = '';
        }

        if (isset($order['date_available'])) {
            $order['end_date'] = $this->parseDateFormat($order['date_available'], $format);
        } else {
            $order['end_date'] = '';
        }

        return $order;
    }

    protected function calculateDuration(string $start, string $end)
    {
        return Carbon::parse($start)->diffInDays(Carbon::parse($end));
    }

    public function parseDateFormat(string $date, string $format)
    {
        return Carbon::parse($date)->format($format);
    }

}
