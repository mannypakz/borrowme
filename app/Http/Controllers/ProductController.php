<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Libraries\Shopify;
use Illuminate\Support\Facades\Auth;
use App\Menu;
use App\User;

class ProductController extends Controller
{
    protected $sp;
    public $json;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $creds['shop_name']     = 'borrowbeez';
        $creds['api_key']       = '6eee231cb55ffa2d0db1fa6e3afeeb42';
        $creds['api_password']  = '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';
        $this->sp = new Shopify($creds);
        $this->json = $this->fetch_menu();
    }

    public function fetch_menu() {
        $menu = Menu::all();
        if(count($menu) != 0) {
            $json = json_decode($menu[0]->menu_json);
            $categories = [];
            foreach($json[0] as $j) { // parent
                $categories[$j->name] = [];
                if(count($j->children[0])) {
                    foreach($j->children[0] as $k) { // 1st child
                        $categories[$j->name][$k->name] = [];
                        if(count($k->children[0])) {
                            foreach($k->children[0] as $l) {
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

        return $output;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = DB::table('products')->get();
        return view('product.index', ['products' => $products,'page_title'=>'Products']);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create',['page_title'=>'Add Product']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'sku' => ['required'],
            'title' => ['required', 'string', 'max:255'],            
            'product_description' => ['required'],            
            'price' => ['required'],
            'vendor' => ['required'],
            'barcode' => ['required'],
            'product_type' => ['required'],
            'quantity' => ['required'],
        ]);
        
        $file = $request->file('product_image');
        $destinationPath = '../public/uploads';
        $file->move($destinationPath,$file->getClientOriginalName());

        $extra = 0;
        if(null !== $request->get('extra_per_day')) {
            $extra = $request->get('extra_per_day');
        }

        $i = file_get_contents(asset('uploads/'.$file->getClientOriginalName()));
        $product = (object)array(
            "title" => $request->get('title'),
            "body_html" => $request->get('product_description'),
            "vendor" => $request->get('vendor'),
            "product_type" => $request->get('product_type'),
            "published" => false,
            "metafields" => array( 
                (object)array(
                    "key" => "Location",
                    "value" => $request->get('location'),
                    "value_type" => "string",
                    "namespace" => "Location"
                ),
                (object)array(
                    "key" => "Term",
                    "value" => $request->get('term'),
                    "value_type" => "string",
                    "namespace" => "Term"
                ),
                (object)array(
                    "key" => "Extra Per Day",
                    "value" => $extra,
                    "value_type" => "string",
                    "namespace" => "Extra Per Day"
                )
            ),
            "variants" => array(
                (object)array(
                    "option1" => $request->get('title'),
                    "price" => $request->get('price'),
                    "sku" => $request->get('sku'),
                    "barcode" => $request->get('barcode'),
                    "inventory_quantity" => $request->get('quantity')
                )
            ),
            "images" => array(
                (object)array(
                    "attachment" => base64_encode($i)
                )
            )
        );

        $rs = $this->sp->s_post("products.json", ["product" => $product]);

        // $product = new Product([
        //     'sku' => $request->get('sku'),
        //     'title' => $request->get('title'),
        //     'product_description' => $request->get('product_description'),    
        //     'price' => $request->get('price'),        
        //     'vendor' => $request->get('vendor'),
        //     'barcode' => $request->get('barcode'),
        //     'product_type' => $request->get('product_type'),
        //     'quantity' => $request->get('quantity'),
        //     'product_image' => $file->getClientOriginalName(),
        //     'term' => $request->get('term'),
        //     'location' => $request->get('location'),
        //     'extra_per_day' => $extra,
        //     's_product_id' => $rs['result']->product->id
        // ]);
        // $product->save();
        
        return redirect('/products')->with('success', 'Product saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'sku' => ['required'],
            'title' => ['required', 'string', 'max:255'],            
            'product_description' => ['required'],            
            'price' => ['required'],
            'vendor' => ['required'],
            'barcode' => ['required'],
            'product_type' => ['required'],
            'quantity' => ['required'],
        ]);

        $file = $request->file('product_image');
        $extra = 0;
        if(null !== $request->get('extra_per_day')) {
            $extra = $request->get('extra_per_day');
        }

        $product = Product::find($id);
        $product->title = $request->get('title');
        $product->sku = $request->get('sku');
        $product->product_description = $request->get('product_description');
        $product->vendor  = $request->get('vendor');
        $product->barcode  = $request->get('barcode');
        $product->product_type  = $request->get('product_type');
        $product->quantity  = $request->get('quantity');
        $product->price  = $request->get('price');

        if(isset($file) && !empty($file)) {
            $product->product_image = $file->getClientOriginalName();
        }
        
        $product->term = $request->get('term');
        $product->location = $request->get('location');
        $product->extra_per_day = $extra;
        
        $product->save();
        return redirect('/products')->with('success', 'Product saved!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect('/products')->with('success', 'Product deleted!');
    }
    
    public function publish_products(Request $request)
    {
        set_time_limit(0);
        $prods = $request->get('checkid'); // checked products
        
        $args=[];
        $existing_products=[];
        $res = $this->sp->s_get("products/count.json",$args);

        if($res["httpcode"] != 401) {
            
            $total_sp = $res['result']->count;

            $args["limit"]  = "250";
            $page_info = null;
            $total=0;

            while ($total < $total_sp) {
                if($page_info) {
                    $args["page_info"] = $page_info;
                }

                $ress = $this->sp->s_get("products.json",$args);
                foreach($ress['result']->products as $product) {
                    foreach($product->variants as $variant) {
                        $existing_products[]=$variant->sku;                 
                    }
                    $total++;
                }

                if($total_sp < $args["limit"]) {
                    $total = $total_sp;
                } else {
                    if(isset($ress['link'])){
                        $page_info = $ress['link']['page_info'];
                    }
                }
            }            
        }        
        
        
        foreach($prods as $prod) {
            $dbproduct=DB::table('products')->where('id', $prod)->first();     
            
               
            if(!in_array($dbproduct->sku,$existing_products)) {
                $product=[];
                $product = (object)array(
                    "title"             => $dbproduct->tite,
                    "body_html"         => $dbproduct->poduct_description,   
                    "vendor"            => $dbproduct->vendor,
                    "product_type"      => $dbproduct->product_type,
                    "tags"              => '',
                    "images"            => $p_images,
                    "variants" => array(
                        (object)array(                    
                            "price"                 => $dbproduct->price,     
                            "compare_at_price"      => '',                               
                            "sku"                   => $dbproduct->sku               
                        )
                    )            
                ); 
                $prodres=$this->sp->s_post("products.json",["product"=>$product]);      
                print_r($prodres);
            }
        }        
    }
    
    public function get_products() 
    {
        $args=[];

        $res = $this->sp->s_get("products/count.json?",$args);

        if($res["httpcode"] != 401) {
            
            $total_sp = $res['result']->count;

            $args["limit"]  = "250";
            $page_info = null;
            $total=0;

            while ($total < $total_sp) {
                if($page_info) {
                    $args["page_info"] = $page_info;
                }

                $ress = $this->sp->s_get("products.json",$args);
                foreach($ress['result']->products as $product) {
                    foreach($product->variants as $variant) {
                        $pfound = DB::table('products')->where('sku',$variant->sku)->first();
                        if(!$pfound){
                            $my_images=[];
                            foreach($product->images as $img) {
                                $my_images[]=$img->src;
                            }
                            DB::insert('Insert into products (sku,title,product_description,vendor,product_type,price,image,quantity,barcode) values (?,?,?,?,?,?,?,?,?)', 
                                        [$variant->sku,$product->title,$product->body_html,$product->vendor,$product->product_type,$variant->price,implode(",",$my_images),$variant->inventory_quantity,$variant->barcode]);
                        }                        
                    }
                    $total++;
                }

                if($total_sp < $args["limit"]) {
                    $total = $total_sp;
                } else {
                    if(isset($ress['link'])){
                        $page_info = $ress['link']['page_info'];
                    }
                }
            }            
        }        
        return redirect('products');
    }

    public function ajax_upload(Request $request) {
        $file = $request->file('product_image');
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

    public function ajax_delete(Request $request) {
        $name = $request->get('filename');
        $path = '../public/uploads/';
        if(unlink($path . $name)) {
            if($request->get('mode') == 'edit') {
                $product = Product::find($request->get('product_id'));
                $images = json_decode($product->images);
                for($i = 0; $i < count($images); $i++) {
                    if($images[$i] == $name) {
                        unset($images[$i]);
                    }
                }
                $images = array_values($images);
                $product->images = json_encode($images);
                $product->save();
            }
            echo true;
        }
        else {
            echo false;
        }

    }

    public function listing() {
        // echo "test";

        return view('product.listing', ['page_title'=>'Product listing', 'json' => $this->json, 'user' => Auth::user()]);
    }

    public function listing_edit($id) {
        $product = Product::find($id);
        if($product->vendor_id != Auth::user()->id) {
            return redirect('error');
        }
        return view('product.listing_edit', [
            'page_title' => 'Product Edit', 
            'product' => $product, 
            'json' => $this->json, 
            'user' => Auth::user()
        ]);
    }

    public function listing_update(Request $request) {
        $product = Product::find($request->get('product_id'));
        $nb = $request->get('neighbourhood') ? $request->get('neighbourhood') : '';
        echo "<pre>";
        print_r($_POST);
        $product->category = $request->get('category');
        $product->sub_category = $request->get('sub_category');
        $product->item_type = $request->get('item_type');
        $product->item_name = $request->get('item_name');
        $product->description = $request->get('description');
        $product->item_condition = $request->get('item_condition');
        $product->age = $request->get('age');
        $product->phone_code = $request->get('phone_code');
        $product->phone = $request->get('phone') ?? '';
        $product->rental_duration_daily = $request->get('rental_duration_daily') ? 1 : 0;
        $product->rental_duration_weekly = $request->get('rental_duration_weekly') ? 1 : 0;
        $product->rental_duration_monthly = $request->get('rental_duration_monthly') ? 1 : 0;
        $product->daily_aed = $request->get('daily_aed') ?? 0;
        $product->weekly_aed = $request->get('weekly_aed') ?? 0;
        $product->monthly_aed = $request->get('monthly_aed') ?? 0;
        $product->available_for_sale = $request->get('available_for_sale') ?? '';
        $product->sale_price = $request->get('sale_price') ?? 0;
        if(null !== ($request->get('images'))) {
            $product->images = json_encode($request->get('images'));
        }
        if(null !== ($request->get('primary_img'))) {
            $product->primary_img = $request->get('primary_img');
        }
        $product->location_1 = $request->get('location_1');
        $product->location_2 = $request->get('location_2');
        $product->street = $request->get('street');
        $product->area = $request->get('area');
        $product->city = $request->get('city');
        if(null !== ($request->get('neighbourhood'))) {
            $product->neighbourhood = json_encode($request->get('neighbourhood'));
        }
        $product->sale_status = $request->get('available_for_sale') == 'yes' ? 'Available for Sale' : '';
        $address = $request->get('location_1') . " " . $request->get('location_2') . " " . $request->get('street') . " " . $request->get('area') . " " . $request->get('city');
        $latlng = $this->get_coordinates($address);
        $product->lat = $latlng[0];
        $product->lng = $latlng[1];
        if($product->save()) {
            return redirect('item');
        }
        else {
            return redirect('error');
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

    public function listing_save(Request $request) {
        $user = Auth::user();
        
        $address = $request->get('location_1') . " " . $request->get('location_2') . " " . $request->get('street') . " " . $request->get('area') . " " . $request->get('city');
        $latlng = $this->get_coordinates($address);

        $avail = $request->get('available_for_sale') ? $request->get('available_for_sale') : 'no';
        $sale_price = $request->get('sale_price') ? $request->get('sale_price') : 0;

        $product = new Product([
            'vendor_id' => $user->id,
            'category' => $request->get('category') ?? '',
            'sub_category' => $request->get('sub_category') ?? '',
            'item_type' => $request->get('item_type') ?? '',
            'item_name' => $request->get('item_name'),
            'description' => $request->get('description') ?? '',
            'item_condition' => $request->get('item_condition') ?? '',
            'age' => $request->get('age') ?? '',
            'phone_code' => $request->get('phone_code') ?? '',
            'phone' => $request->get('phone') ?? '',
            'rental_duration_daily' => $request->get('rental_duration_daily') ? 1 : 0,
            'rental_duration_weekly' => $request->get('rental_duration_weekly') ? 1 : 0,
            'rental_duration_monthly' => $request->get('rental_duration_monthly') ? 1 : 0,
            'daily_aed' => $request->get('daily_aed') ?? 0,
            'weekly_aed' => $request->get('weekly_aed') ?? 0,
            'monthly_aed' => $request->get('monthly_aed') ?? 0,
            'cash_deposit' => $request->get('cash_deposit') ?? 0,
            'available_for_sale' => $avail,
            'sale_price' => $sale_price,
            'images' => json_encode($request->get('images')),
            'primary_img' => $request->get('primary_img'),
            'location_1' => $request->get('location_1'),
            'location_2' => $request->get('location_2'),
            'street' => $request->get('street'),
            'area' => $request->get('area'),
            'city' => $request->get('city'),
            'neighbourhood' => json_encode($request->get('neighbourhood')),
            'rent_status' => '',
            'sale_status' => $request->get('available_for_sale') == 'yes' ? 'Available for Sale' : '',
            'listing_type' => $user->registration_type,
            'order_id' => 0,
            'lat' => $latlng[0],
            'lng' => $latlng[1],
        ]);
        $product->save();
        return redirect('item');
    }

    public function limit_text($text, $limit) {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos   = array_keys($words);
            $text  = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }

    public function search(Request $request) {
        $requests = $request->all();
        $result = $this->sp->s_get("products/count.json");
        // print_r($result);
        // exit;
        $products = [];
        if($total = $result['result']->count) {
            $args = ["limit" => 250];
            $count = 0;
            while($count < $total) {
                $p = $this->sp->s_get("products.json", $args);
                foreach($p['result']->products as $prod) {
                    $metafields = $this->sp->s_get('/products/' . $prod->id . '/metafields.json');
                    foreach($metafields['result']->metafields as $meta) {
                        if($meta->namespace == 'daily_aed') {
                            $daily = $meta->value;
                        }
                    }
                    $prod->daily = $daily;
                    $prod->body_html = $this->limit_text($prod->body_html, 10);
                    $products[] = $prod;
                    $count++;
                }
                if(isset($p['link']['page_info'])) {
                    $agrs['page_info'] = $p['link']['page_info'];
                }
            }
        }

        for($i = 0; $i < count($products); $i++) {
            if($request['s']) {
                if(isset($requests['keyword']) && strpos(strtolower($products[$i]->title), strtolower($requests['keyword'])) === false) {
                    unset($products[$i]); 
                }
            }
        }
        $products = array_values($products);

        return view('product.search', ['page_title' => 'Search', 'content_header' => 'layouts/main_menu', 'products' => $products, 'user' => Auth::user()]);
    }

    public function search_result(Request $request) {
        
    }

}   
