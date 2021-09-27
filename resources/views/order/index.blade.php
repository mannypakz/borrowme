@extends('layouts.template')
@section('content')
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>-->
<script type="text/javascript" src="{{ asset('rating.js') }}"></script>

<div class="container" id="ordersContainer">
    <div class="row mt-5">
        <div class="col-md-3">@include('layouts/item_nav')</div>
        <div class="col-md-9">
            <div class="d-flex d-row justify-content-end history-filter">
                <div>
                    <select class="custom-select form-control" name="filter" id="filter">
                        <option @if($filter == 'all') selected @endif value="all">All</option>
                        <option @if($filter == 'active') selected @endif value="active">Active</option>
                        <option @if($filter == 'completed') selected @endif value="completed">Completed</option>
                    </select>
                </div>
                <div>
                    <select class="custom-select form-control" name="sort" id="sort">
                        <option @if($sort == 'new_to_old') selected @endif value="new_to_old">New to Old</option>
                        <option @if($sort == 'old_to_new') selected @endif value="old_to_new">Old to New</option>
                    </select>
                </div>
            </div>
            <div id="orderHistory">
                @for($i = 0; $i < count($orders); $i++)
                <div class="container-fluid">
                    <div class="row">
                        <div class="item-history-content">
                            <div class="row">
                                <div class="col-md-3">
                                    <img src="{{ asset('images/can.jpg') }}" style="max-width:100%;">
                                </div>
                                <div class="col-md-9">
                                    <span class="status">{{ucwords($orders[$i]['status'])}}</span>
                                    <div class="item-history-details">
                                        <h4>Order # {{ $orders[$i]['id'] }}</h4>
                                        <p>Status: {{ $orders[$i]['status'] }} </p>
                                        <p>Item Type: {{ $orders[$i]['item_type'] }}</p>
                                        <p>Borrowed Date: {{ $orders[$i]['start_date'] }}</p>
                                        <p>Return Date: {{ $orders[$i]['end_date'] }}</p>
                                        <p class="mb-0">Borrowed Price: AED-{{ $orders[$i]['sale_price'] }}</p>
                                        <div class="row align-items-center">
                                            <div class="col-md-4">
                                                <p class="mb-0">Recieved Review: </p>
                                            </div>
                                            <div class="col-md-3">
                                                <span class="star-ratings">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </span>
                                            </div>
                                            <div class="col-md-5">
                                                <button type="button" class="btn btn-sm show-review-comments" onclick="showReview(event)" data="{{ $orders[$i]['id'] }}">Show Review Comments</button>
                                            </div>
                                        </div>
                                        <div class="text-center mt-3">
                                            <button type="button" class="btn provide-btn" onclick="provideReview(event)" data="{{ $orders[$i]['id'] }}">Provide Review</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>
</div>

{{-- MODALS --}}
@include('order.modals.review-modal')
@include('order.modals.show-review-modal')
@include('order.modals.review-status')

{{-- MODAL BEHAVIOR --}}
<script type="text/javascript" src="{{ URL::asset('js/orders.js') }}" defer></script>

{{-- Modal display after rating an order --}}
@if (Session::has('review_status'))
<script type="text/javascript">
    $(document).ready(() => {
        $('#review_status_modal').modal('show');
    });
</script>
@endif

@endsection
