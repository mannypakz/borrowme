<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use App\User;
use App\User_groups;

class ChatsController extends Controller
{
    //
    public function __construct() {
  		$this->middleware('auth');
	}

	/**
	 * Show chats
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{	
		$single_ug = NULL;
		if(isset($_GET['id']) && !empty($_GET['id'])) {
			$ugid = $request->input('id');
			$single_ug = User_groups::find($ugid);
		}
		

		$user = Auth::user();
		$users = User::where("id", "!=", $user->id)->get();
		$users_arr = [];
		$group_users = User_groups::where("user_id", $user->id)->get();

		foreach($users as $u) {
			$users_arr[] = (object)array(
								"email" => $u->email,
								"id" => $u->id
							);
		}
		sort($users_arr);
		// print_r($users_arr);
		// exit;
		return view('chat.index', [
			'content_header' => 'layouts/main_menu', 
			'user' => $user, 
			'users' => json_encode($users_arr), 
			'group_users' => $group_users,
			'single_ug' => json_encode($single_ug),
		]);
	}

	public function add_user_group(Request $request) {
		// echo $request->get('user_id');
		// echo $request->get('user_name');
		$u = User::find($request->get('user_id'));
		if($u) {
			$image = $u->registration_type == 'individual' ? $u->profile_image : $u->company_logo;
			User_groups::create([
				"user_id" => Auth::user()->id,
				"group_user_id" => $u->id,
				"accepted" => 0,
				"first_name" => $u->first_name,
				"last_name" => $u->last_name,
				"image" => $image
			]);
			return redirect('/chat')->with('chat_success', 'user added');
		}
		else {
			$u2 = User::where("email", "LIKE", '%'.$request->get('user_email').'%')->first();
			if(!$u2) {
				return redirect('/chat')->with('chat_error', 'User not found!');
			}
			if($u2->id == Auth::user()->id) {
				return redirect('/chat')->with('chat_error', 'Cannot add own account to groups.');
			}
			$image = $u2->registration_type == 'individual' ? $u2->profile_image : $u2->company_logo;
			User_groups::create([
				"user_id" => Auth::user()->id,
				"group_user_id" => $u2->id,
				"first_name" => $u2->first_name,
				"last_name" => $u2->last_name,
				"image" => $image
			]);
			return redirect('/chat')->with('chat_success', 'user added');
		}	
	}

	public function message_lender($id) {
		$user = User::find($id);
		$ug = User_groups::where("user_id", Auth::user()->id)->where("group_user_id", $id)->first();

		if($id == Auth::user()->id) {
			return redirect('/chat')->with('chat_error', 'Cannot add own account to groups.');
		}
		if(!$user) {
			return redirect('/chat')->with('chat_error', 'User not found!');
		}
		if($ug) {
			return redirect('chat?id='.$ug->id);
		}

		$image = $user->registration_type == 'individual' ? $user->profile_image : $user->company_logo;
		
		User_groups::create([
			"user_id" => Auth::user()->id,
			"group_user_id" => $user->id,
			"accepted" => 0,
			"first_name" => $user->first_name,
			"last_name" => $user->last_name,
			"image" => $image
		]);
		return redirect('/chat')->with('chat_success', 'user added');
	}

	public function accept_invite(Request $request) {
		$ug = User_groups::find($request->get('ug_id'));
		$ug->accepted = 1;
		$ug->save();

		$user = User::find($ug->user_id);

		$result = User_groups::create([
			"user_id" => $ug->group_user_id,
			"group_user_id" => $ug->user_id,
			"accepted" => 1,
			"first_name" => $user->first_name,
			"last_name" => $user->last_name,
			"image" => $user->registration_type == 'individual' ? $user->profile_image : $user->company_logo,
		]);

		return redirect('chat?id='.$result->id);
	}
	
}
