<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Categories;
use App\Menu;
use App\Product;
use App\Review;
use App\User_groups;


class AdminController extends Controller
{
    //
    function __construct() {
    	$this->middleware('auth');
    }

    function index() {
    	if(Auth::user()->role == 1) {
    		return view('admin.index', ['user' => Auth::user()]);
    	}
    	else {
    		die("You are not allowed here!");
    	}
    }

     public function users() {
        $users = User::all();
        return view('admin.users', ['page_title' => 'Users', 'users' => $users, 'user' => Auth::user()]);
    }

    public function user_delete(Request $request) {
        $user = User::find($request->get('user_id'));
        if($user) {
            $user->delete();
        }
        $products = Product::where("vendor_id", $request->get('user_id'))->get();
        foreach($products as $p) {
            $p->delete();
        }
        $reviews = Review::where("review_type", "user")->where("reference_id", $request->get('user_id'))->get();
        foreach($reviews as $r) {
            $r->delete();
        }
        $user_groups = User_groups::where("user_id", $request->get('user_id'))->orWhere("group_user_id", $request->get('user_id'))->get();
        foreach($user_groups as $ug) {
            $ug->delete();
        }
        return redirect('admin/users');
    }

    public function categories() {
        $categories = Categories::all();
        $menu = Menu::all() ? Menu::all() : null; 
        // echo "<pre>";
        // print_r($menu);
        // exit;
    	return view('admin.categories', ['page_title' => 'Categories', 'user' => Auth::user(), 'categories' => $categories, 'menu' => $menu]);
    }

    public function create_category(Request $request) {
        $category = new Categories([
            'category_name' => $request->get('category_name'),
            'slug' => strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $request->get('category_name')), '-')),
        ]);

        if($category->save()) {
            echo json_encode($category);
        }
        else {
            echo json_encode(false);
        }

    }

    public function delete_category(Request $request) {
        $id_1 = $request->get('delete_id'); //parent
        $rec_1 = Categories::find($id_1);
        $rec_1->delete();
        $child_1 = Categories::where("parent_id", $id_1)->get(); // 1st child
        foreach($child_1 as $c) {
            $child_2 = Categories::where("parent_id", $c->id)->get();
            foreach($child_2 as $c2) {
                $c2->delete();
            }
            $c->delete();
        }

        $html = htmlspecialchars($request->get('menu_html'));
        $json = $request->get('menu_json');

        $menu = Menu::all();
        if(count($menu) != 0) {
            $menu[0]->menu_html = $html;
            $menu[0]->menu_json = $request->get('menu_json');
            $menu[0]->updated_at = date("Y-m-d H:i:s");
            $menu[0]->save();
        }
        else {
            $menu = new Menu([
                'menu_html' => $html,
                'menu_json' => $request->get('menu_json'),
            ]);
            $menu->save(); 
        }
        
        return redirect('admin/categories');
    }

    public function create_menu(Request $request) {
        $html = htmlspecialchars($request->get('menu_html'));
        $json = $request->get('menu_json');
        $json = json_decode($json);

        // echo json_encode($json);
        // exit;
        
        foreach($json[0] as $j) { //parent
            $parent_1 = $j->id;
            if(count($j->children[0])) {
                foreach($j->children[0] as $k) { // 1st child
                    $cat_1 = Categories::find($k->id);
                    $cat_1->parent_id = $parent_1;
                    $cat_1->save();
                    $k->parent_id = $parent_1;
                    $parent_2 = $k->id;
                    if(count($k->children[0])) {
                        foreach($k->children[0] as $l) { // 2nd child
                            $l->parent_id = $parent_2;
                            $cat_2 = Categories::find($l->id);
                            $cat_2->parent_id = $parent_2;
                            $cat_2->save();
                        }
                    }
                }
            }
        }

        $menu = Menu::all();
        if(count($menu) != 0) {
            $menu[0]->menu_html = $html;
            $menu[0]->menu_json = $request->get('menu_json');
            $menu[0]->updated_at = date("Y-m-d H:i:s");
            $menu[0]->save();
        }
        else {
            $menu = new Menu([
                'menu_html' => $html,
                'menu_json' => $request->get('menu_json'),
            ]);
            $menu->save(); 
        }

        if($request->get('json_update') == "false") {
            return redirect('/admin/categories');
        }
        
    }   
}
