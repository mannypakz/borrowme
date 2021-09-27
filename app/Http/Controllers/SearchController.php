<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Services\MenuService;
use App\Services\ProductService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    protected $request;
    protected $categoryService;
    protected $menuService;
    protected $productService;

    public function __construct(Request $request, CategoryService $categoryService, MenuService $menuService, ProductService $productService)
    {
        $this->request = $request;
        $this->categoryService = $categoryService;
        $this->menuService = $menuService;
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $categories = [];
        $subCategories = [];
        $itemTypes = [];
        $selected_category = $request->input('category') ?? null;
        $selected_sub_category = $request->input('sub_category') ?? null;
        $selected_item_type = $request->input('item_type') ?? null;
        $start_date = $request->input('start_date') ?? null;
        $end_date = $request->input('end_date') ?? null;
        $selected_neighborhood = $request->input('neighbourhood') ?? null;
        $selected_condition = $request->input('item_condition') ?? null;
        $selected_age = $request->input('age') ?? null;
        $photos = $request->input('photos') ?? null;
        $selected_location = $request->input('location_select') ?? null;

        $menus = json_decode($this->menuService->getAllMenus()[0]['menu_json']);

        foreach ($menus[0] as $key => $category) {
            $categories[$key]['name'] = $category->name;
            $categories[$key]['id'] = $category->id;
            $categories[$key]['slug'] = $this->slugify($category->name);

            foreach ($category->children[0] as $subCategory) {

                array_push($subCategories, [
                    'name' => $subCategory->name,
                    'id' => $subCategory->id,
                    'category_id' => $category->id,
                    'slug' => $this->slugify($subCategory->name)
                ]);

                foreach ($subCategory->children[0] as $itemType) {

                    array_push($itemTypes, [
                        'name' => $itemType->name,
                        'id' => $itemType->id,
                        'category_id' => $category->id,
                        'sub_category_id' => $subCategory->id,
                        'slug' => $this->slugify($itemType->name)
                    ]);

                }
            }

        }

        $filters = $this->request->input();
        $products = $this->appendProductsData($this->productService->searchProducts($filters));

        if (array_key_exists('order', $filters)) {

            if ($filters['order'] === 'nearest') {
                $products = $this->sortProductsByNearest($products);
            }

            if ($filters['order'] === 'user_rating') {
                $products = $this->sortByRating($products);
            }
        }

        if (!array_key_exists('order', $filters)) {
            $filters['order'] = '';
        }

        if (!array_key_exists('photos', $filters)) {
            $filters['photos'] = false;
        }
        $itemTypes = mb_convert_encoding($itemTypes, 'UTF-8', 'UTF-8');
        return view('search.index', [
            'products' => $products,
            'categories' => $categories,
            'sub_categories' => $subCategories,
            'item_types' => $itemTypes,
            'user' => Auth::user(),
            'content_header' => 'layouts/main_menu',
            'selected_category' => $selected_category,
            'selected_sub_category' => $selected_sub_category,
            'selected_item_type' => $selected_item_type,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'selected_neighborhood' => $selected_neighborhood,
            'selected_condition' => $selected_condition,
            'selected_age' => $selected_age,
            'photos' => $photos,
            'selected_location' => $selected_location,
        ] + $filters);
    }

    protected function appendProductsData(array $products)
    {
        $updatedProducts = $this->getProductReviews($products);
        $updatedProducts = $this->setProductSaleStatus($products);

        return $updatedProducts;
    }

    protected function getProductReviews(array $products)
    {
        foreach ($products as $key => $product) {
            $stars = [];
            $reviews = $this->productService->getProductReviews($product->id);

            if (!$reviews) {
                $products[$key]->rating = 0;
                continue;
            }

            foreach ($reviews as $review) {
                $stars[] = $review->stars;
            }

            $products[$key]->rating = array_sum($stars) / count($stars);
        }

        return $products;
    }

    protected function setProductSaleStatus(array $products)
    {

        foreach ($products as $key => $product) {
            $status = 'Available for rent';
            if ($product->sale_status == 'Sold') {
                $status = 'Sold';
            } elseif ($product->rent_status == 'Currently Rented') {
                $dateAvailable = Carbon::parse($product->date_available)->format('d M Y');
                $status = "Available from: $dateAvailable";
            } elseif (!($product->rental_duration_daily || $product->rental_duration_weekly || $product->rental_duration_monthly)) {
                $status = "Not avaialble for rent";
            }

            $products[$key]->for_sale_only = (!$product->rental_duration_daily && !$product->rental_duration_weekly && !$product->rental_duration_monthly) && $product->available_for_sale == 'yes';
            $products[$key]->status = $status;
        }

        return $products;
    }

    protected function sortByRating(array $products)
    {
        usort($products, function ($a, $b) {
            return $b->rating > $a->rating;
        });

        return $products;
    }

    protected function sortProductsByNearest(array $products)
    {
        $default = $this->getDefaultCoordinates();
        $latitude = $default['latitude'];
        $longitude = $default['longitude'];

        if (Auth::user()) {
            $latitude = Auth::user()->lat;
            $longitude = Auth::user()->lang;
        }

        foreach ($products as $key => $product) {
            $distance = ceil($this->haversine($latitude, $longitude, $product->lat, $product->lng));
            $products[$key]->distance = $distance;
        }

        usort($products, function($a, $b) {
            return $a->distance > $b->distance;
        });

        return $products;
    }

    protected function haversine($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
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

    protected function getDefaultCoordinates()
    {
        $coordinates = [];
        $response = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));

        if ($response['geoplugin_request'] == '127.0.0.1') { // for local host
            $coordinates['latitude'] = 25.2559671;
            $coordinates['longitude'] = 55.29583969999999;
        } else {
            $coordinates['latitude'] = $response['geoplugin_latitude'];
            $coordinates['longitude'] = $response['geoplugin_longitude'];
        }

        return $coordinates;

    }

    protected function slugify(string $name)
    {
        return strtolower(implode("-", explode(" ", $name)));
    }

}
