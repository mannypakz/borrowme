<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\ProductService;

class OrderService
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getAllOrders()
    {
        $statement = "SELECT orders.*,
            products.vendor_id,
            products.category,
            products.sub_category,
            products.item_type,
            products.description,
            products.item_condition,
            products.age,
            products.phone_code,
            products.phone,
            products.rental_duration_daily,
            products.rental_duration_weekly,
            products.rental_duration_monthly,
            products.daily_aed,
            products.weekly_aed,
            products.monthly_aed,
            products.cash_deposit,
            products.available_for_sale,
            products.sale_price,
            products.images,
            products.primary_img,
            products.location_1,
            products.location_2,
            products.street,
            products.area,
            products.city,
            products.neighbourhood,
            products.rent_status,
            products.sale_status,
            products.listing_type
        FROM orders INNER JOIN products ON orders.product_id = products.id";

        $orders = (array) DB::select($statement, []);

        foreach ($orders as $key => $order) {
            $orders[$key] = (array) $order;
        }

        return $orders;
    }

    public function getAllOrdersByVendor(int $vendorId)
    {
        $statement = "SELECT orders.*,
            products.vendor_id,
            products.category,
            products.sub_category,
            products.item_type,
            products.description,
            products.item_condition,
            products.age,
            products.phone_code,
            products.phone,
            products.rental_duration_daily,
            products.rental_duration_weekly,
            products.rental_duration_monthly,
            products.daily_aed,
            products.weekly_aed,
            products.monthly_aed,
            products.cash_deposit,
            products.available_for_sale,
            products.sale_price,
            products.images,
            products.primary_img,
            products.location_1,
            products.location_2,
            products.street,
            products.area,
            products.city,
            products.neighbourhood,
            products.rent_status,
            products.sale_status,
            products.listing_type
        FROM orders INNER JOIN products ON orders.product_id = products.id
        WHERE orders.vendor_id = ?";

        return (array) DB::select($statement, [$vendorId]);

    }

    public function getOrder(int $id)
    {
        $statement = "SELECT orders.*,
            products.vendor_id,
            products.category,
            products.sub_category,
            products.item_type,
            products.description,
            products.item_condition,
            products.age,
            products.phone_code,
            products.phone,
            products.rental_duration_daily,
            products.rental_duration_weekly,
            products.rental_duration_monthly,
            products.daily_aed,
            products.weekly_aed,
            products.monthly_aed,
            products.cash_deposit,
            products.available_for_sale,
            products.sale_price,
            products.images,
            products.primary_img,
            products.location_1,
            products.location_2,
            products.street,
            products.area,
            products.city,
            products.neighbourhood,
            products.rent_status,
            products.sale_status,
            products.listing_type
        FROM orders INNER JOIN products ON orders.product_id = products.id
        WHERE orders.id = ?";

        return (array) DB::select($statement, [$id])[0];
    }

}
