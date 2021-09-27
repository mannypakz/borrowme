<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User_groups;
use App\User;

class NotificationController extends Controller
{	
	public function __construct() {
  		$this->middleware('auth');
	}

    public function index()
    {
        $user = Auth::user();
        $ug = User_groups::where("group_user_id", $user->id)->where("accepted", 0)->get();
        $data = [];
        foreach($ug as $u) {
        	$r = User::find($u->user_id);
        	$data[] = (object)array(
        		"image" => $r->registration_type == 'individual' ? $r->profile_image : $r->company_logo,
        		"name" => $r->name,
        		"ago" => $this->get_time_ago(strtotime($u->created_at)),
        		"id" => $r->id,
        		"ug_id" => $u->id,
        	);
        }
        return view('notification.index', [ 
        	'content_header' => 'layouts/notifications_header', 
        	'user' => $user,
        	'req' => $data,
        ]);
    }

    // function from: https://www.w3schools.in/php-script/time-ago-function/
	public function get_time_ago( $time ) {
		$time_difference = time() - $time;

		if( $time_difference < 1 ) { return 'less than 1 second ago'; }
		$condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
		            30 * 24 * 60 * 60       =>  'month',
		            24 * 60 * 60            =>  'day',
		            60 * 60                 =>  'hour',
		            60                      =>  'minute',
		            1                       =>  'second'
		);

		foreach( $condition as $secs => $str )
		{
		    $d = $time_difference / $secs;

		    if( $d >= 1 )
		    {
		        $t = round( $d );
		        return $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
		    }
		}
	}

}
