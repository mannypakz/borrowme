@extends('layouts.template')
@section('content')

<div class="container" id="reviewOrder">
    <div class="row">
        <div class="col-md-7">
            <div class="review-order">
                <h1>Review Your Order</h1>
                <p>Please read and check the item details which you are going to borrow before sending a request</p>
            </div>
            <div class="no-fee">
                <h2>1. No fee</h2>
                <p>We do not charge any service or platform fee. BorrowMe is totally free of cost for both the borrower and the lender</p>
            </div>
            <div class="pay-to-lender">
                <h2>2. Pay directly to lender</h2>
                <p>No need to use or put your payment method for paying the lender. Instead, BorrowMe pays the lender directly.</p>
            </div>
        </div>
        <div class="col-md-5">
			<div class="review-order-content">
				<div class="row">
					<div class="col-md-12">
						<div class="text-right">
							<a href="#" style="color:#2cb7aa;">Edit</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div>
							<img src="{{ asset('images/can.jpg') }}" width="100p" height="100px">
						</div>
					</div>
					<div class="col-md-8">
						<div>
							<h4 class="mb-0">Demo tester</h4>
							<p>From Demo</p>
						</div>
					</div>
				</div>
				<div class="date-rental mt-4 mb-4 text-center">
					<div class="row align-items-center">
						<div class="col-md-4">
							<span id="start" class="d-block text-left"></span>
						</div>
						<div class="col-md-4">
							<i class="fas fa-arrow-right"></i>
						</div>
						<div class="col-md-4">
							<span id="end" class="d-block text-right"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="text-left">
							AED-<span id="conf-rental-value"></span> X
							<span id="conf-rental-days"></span> Days
						</div>
					</div>
					<div class="col-md-6">
						<div class="text-right">
							AED-<span class="conf-rental-total"></span>
						</div>
					</div>
				</div>
				<div class="service-fee">
					<div class="row">
						<div class="col-md-6">
							<div class="text-left">
								<p>Service Fee:</p>
							</div>
						</div>
						<div class="col-md-6">
							<div class="text-right">
								<p>--</p>
							</div>
						</div>
					</div>
				</div>
				<div class="total-amount">
					<div class="row">
						<div class="col-md-6">
							<div class="text-left">
								<span>Total:</span>
							</div>
						</div>
						<div class="col-md-6">
							<div class="text-right">
								<span class="conf-rental-total"></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
    <div class="row buttons-container">
        <button type="button" class="btn btn-outline-primary back-btn">Back</button>
        <button type="button" class="btn btn-primary place-btn">Place an Order</button>
    </div>
</div>

@endsection
