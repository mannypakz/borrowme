<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications;

class SettingController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		return view('setting.index', ['page_title' => 'Password', 'content_header' => 'layouts/main_menu', 'user' => Auth::user()]);
	}

	public function notification() {
		$notification = Notifications::where('user_id', Auth::user()->id)->first();
		return view('setting.notification', ['page_title' => 'Notification', 'content_header' => 'layouts/main_menu', 'user' => Auth::user(), 'notification' => $notification]);	
	}

	public function update_password(Request $request) {
		$request->validate([
			'current_password' => ['required', new MatchOldPassword],
			'new_password' => ['required', 'min:8'],
			'confirm_password' => ['same:new_password']
		]);

		$user = Auth::user();
		$user->password = Hash::make($request->get('new_password'));
		$user->save();
		return redirect('setting')->with('pass_status', 'success');
	}

	public function save_notification(Request $request) {
		$notification = Notifications::where('user_id', Auth::user()->id)->first();

		// echo "<pre>";
		// echo $request->get('email_inbox_msg');
		// print_r($new_notification);

		if($notification) {
			$notification->email_inbox_messages = $request->get('email_inbox_msg') ? 1 : 0;
			$notification->email_borrowme_promotions = $request->get('email_promotions') ? 1 : 0;
			$notification->email_order_messages = $request->get('email_order_msg') ? 1 : 0;
			$notification->email_borrowme_updates = $request->get('email_updates') ? 1 : 0;
			$notification->mobile_inbox_messages = $request->get('mobile_inbox_msg') ? 1 : 0;
			$notification->mobile_order_messages = $request->get('mobile_order_msg') ? 1 : 0;
			$notification->mobile_borrowme_promotions = $request->get('mobile_promotions') ? 1 : 0;
			$notification->mobile_borrowme_updates = $request->get('mobile_updates') ? 1 : 0;

			$notification->save();
		}
		else {
			$new_notification = new Notifications();
			$new_notification->user_id = Auth::user()->id;

			$new_notification->email_inbox_messages = $request->get('email_inbox_msg') ? 1 : 0;
			$new_notification->email_borrowme_promotions = $request->get('email_promotions') ? 1 : 0;
			$new_notification->email_order_messages = $request->get('email_order_msg') ? 1 : 0;
			$new_notification->email_borrowme_updates = $request->get('email_updates') ? 1 : 0;
			$new_notification->mobile_inbox_messages = $request->get('mobile_inbox_msg') ? 1 : 0;
			$new_notification->mobile_order_messages = $request->get('mobile_order_msg') ? 1 : 0;
			$new_notification->mobile_borrowme_promotions = $request->get('mobile_promotions') ? 1 : 0;
			$new_notification->mobile_borrowme_updates = $request->get('mobile_updates') ? 1 : 0;

			$new_notification->save();
		}

		return redirect('/setting/notification');

	}
}