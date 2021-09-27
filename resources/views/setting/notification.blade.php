@extends('layouts.template')

@section('content')
<div class="container">
	<div class="row mt-5 notification">
		<div class="col-md-3">
			@include('layouts/item_nav')
		</div>
		<div class="col-md-9">
			<div class="content-section">
				<div class="row">
					<div class="col-md-4">
						<table class="table table-borderless settings-notification">
					<thead>
						<tr>
							<th>Notification</th>
					</thead>
					<tbody>
						<tr>
							<td>
								For important updates regarding your BorrowMe activity, certain notifications cannot be disabled
							</td>
						</tr>
					</tbody>
				</table>
					</div>
					<div class="col-md-8">
						<table class="table table-borderless settings-notification">
					<thead>
						<tr>
							<th width="400" style="text-align:center;">Type</th>
							<th>Email</th>
							<th>Mobile</th>
						</tr>
					</thead>
					<form method="post" action="{{route('save_notification')}}">
						@csrf
						<tbody>
							<tr>
								<td width="400" align="center">Inbox Messages</td>
								<td>
									<div class="checkbox">
				                      <label class="container">
				                        <input type="checkbox" name="email_inbox_msg" @if(null != $notification && $notification->email_inbox_messages == 1) checked @endif style="position:relative">
				                        <span class="checkmark"></span>
				                      </label>
				                    </div>
								</td>
								<td>
									<div class="checkbox">
				                      <label class="container">
				                      	<input type="checkbox" name="mobile_inbox_msg" @if(null != $notification && $notification->mobile_inbox_messages == 1) checked @endif style="position:relative">
				                        <span class="checkmark"></span>
				                      </label>
				                    </div>
								</td>
							</tr>
							<tr>
								
								<td width="400" align="center">Order Messages</td>
								<td>
									<div class="checkbox">
				                      <label class="container">
				                        <input type="checkbox" name="email_order_msg" @if(null != $notification && $notification->email_order_messages == 1) checked @endif style="position:relative">
				                        <span class="checkmark"></span>
				                      </label>
				                    </div>
								</td>
								<td>
									<div class="checkbox">
				                      <label class="container">
				                      	<input type="checkbox" name="mobile_order_msg" @if(null != $notification && $notification->mobile_order_messages == 1) checked @endif style="position:relative">
				                        <span class="checkmark"></span>
				                      </label>
				                    </div>
								</td>
							</tr>
							<tr>
								
								<td width="400" align="center">BorrowMe Promotions</td>
								<td>
									<div class="checkbox">
				                      <label class="container">
				                      	<input type="checkbox" name="email_promotions" @if(null != $notification && $notification->email_borrowme_promotions ==1) checked @endif style="position:relative">
				                        <span class="checkmark"></span>
				                      </label>
				                    </div>
								</td>
								<td>
									
									<div class="checkbox">
				                      <label class="container">
				                      	<input type="checkbox" name="mobile_promotions" @if(null != $notification && $notification->mobile_borrowme_promotions == 1) checked @endif style="position:relative">
				                        <span class="checkmark"></span>
				                      </label>
				                    </div>
								</td>
							</tr>
							<tr>
								
								<td width="400" align="center">BorrowMe Updates</td>
								<td>
									<div class="checkbox">
				                      <label class="container">
				                      	<input type="checkbox" name="email_updates" @if(null != $notification && $notification->email_borrowme_updates == 1) checked @endif style="position:relative">
				                        <span class="checkmark"></span>
				                      </label>
				                    </div>
								</td>
								<td>
									<div class="checkbox">
				                      <label class="container">
				                      	<input type="checkbox" name="mobile_updates" @if(null != $notification && $notification->mobile_borrowme_updates == 1) checked @endif style="position:relative">
				                        <span class="checkmark"></span>
				                      </label>
				                    </div>
								</td>
							</tr>
						</tbody>
					
				</table>
					</div>
				</div>
				
				<div class="text-right mt-5">
	    			<button type="submit" class="btn btn-primary">Save Changes</button>
	    		</div>
	    		</form>
			</div>
		</div>
	</div>	
</div>
@endsection