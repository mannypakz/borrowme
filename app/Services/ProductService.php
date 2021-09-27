<?php
namespace App\Services;
use App\Product;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function getAllProducts()
    {
        return Product::all();
    }

    /**
     * Searches for products based on a keyword
     *
     * @param string $keyword
     * @return array
     */
    public function searchProducts(array $filters)
    {
        $orderFilter = '';
        $additionalWhereFilters = $this->setAdditionalWhereFilters($filters);

        if (isset($filters['order'])) {
            $orderFilter = $this->setOrderFilter($filters['order']);
        }
        $statement = "SELECT * FROM products WHERE products.ID IS NOT NULL $additionalWhereFilters $orderFilter";
        // dd($statement);
        return DB::select($statement);
    }

    public function getProductReviews(int $productId)
    {
        $statement = "SELECT reviews.stars FROM reviews WHERE reviews.reference_id = :id AND reviews.review_type = 'product'";
        return DB::select($statement, [ 'id' => $productId ]);
    }

    protected function setAdditionalWhereFilters(array $filters)
    {
        $keywordFilter = '';
        $categoryFilter = '';
        $subCategoryFilter = '';
        $itemTypeFilter = '';
        $dateFilter = '';
        $saleStatusFilter = '';
        $listingTypeFilter = '';
        $neighborhoodFilter = '';
        $itemConditionFilter = '';
        $ageFilter = '';

        if (isset($filters['q'])) {
            $keywordFilter = " AND CONCAT(
                products.item_name, ' ',
                products.description, ' ',
                products.category, ' ',
                products.sub_category, ' ',
                products.item_type, ' ',
                products.listing_type, ' '
            ) LIKE '%{$filters['q']}%' ";
        }

        if (isset($filters['category'])) {
            $categoryFilter = " AND products.category LIKE '{$filters['category']}%' ";
        }

        if (isset($filters['sub_category'])) {
            $subCategoryFilter = " AND products.sub_category LIKE '{$filters['sub_category']}%' ";
        }

        if (isset($filters['item_type'])) {
            $itemTypeFilter = " AND products.item_type LIKE '{$filters['item_type']}%' ";
        }

        if (isset($filters['start_date']) && isset($filters['end_date'])) {
            $dateFilter = " AND (products.date_available < '{$filters['start_date']}' AND products.date_available < '{$filters['end_date']}' OR (products.date_available IS NULL AND products.sale_status != 'Sold'))";
        }

        if (isset($filters['sale_status'])) {
            $saleStatusFilter = " AND products.available_for_sale LIKE '%yes%' ";
        }

        if (isset($filters['listing_type'])) {

            if ($filters['listing_type'] !== 'all') {
                $listingTypeFilter = " AND products.listing_type LIKE '%{$filters['listing_type']}%' ";
            }

        }

        if (isset($filters['neighbourhood'])) {
            $neighborhoodFilter = " AND products.neighbourhood LIKE '%{$filters['neighbourhood']}%' ";
        }

        if (isset($filters['item_condition'])) {
            $itemConditionFilter = " AND products.item_condition LIKE '%{$filters['item_condition']}%' ";
        }

        if (isset($filters['age'])) {
            $ageFilter = " AND products.age LIKE '%{$filters['age']}%'  ";
        }

        return $keywordFilter . $categoryFilter . $subCategoryFilter . $itemTypeFilter . $dateFilter . $saleStatusFilter . $listingTypeFilter
            . $neighborhoodFilter . $itemConditionFilter . $ageFilter;
    }

    protected function setOrderFilter(string $order)
    {
        $result = '';

        switch ($order) {
            case 'nearest':
                $result = "";
                break;
            case 'user_rating':
                $result = "";
                break;
            case 'price_highest':
                $result = "ORDER BY daily_aed DESC";
                break;
            default:
                $result = "ORDER BY daily_aed ASC";
        }

        return $result;
    }
}
