@extends('layouts.template')

@section('content')
{{-- Moment.js --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
{{-- Daterange Picker --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<div class="container" id="searchResults" style="display: none;">
    <form>
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="search-sidebar">
                    <!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>-->
                    <aside>
                        <div class="">
                            <nav class="mt-2 rounded-border">
                                <a class="brand-link"><span class="brand-text text-center mb-4 d-block">Search</span></a>
                                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                    <li>
                                        {{-- Category Select --}}
                                        <select id="searchCategorySelect" class="custom-select" name="category" onchange="selectedCategoryFilter(event, @php $sub_categories @endphp)">
                                            <option selected>Category</option>
                                            @foreach ($categories as $category)
                                                @if($selected_category == $category)
                                                    <option value="@php print($category['name']) @endphp" selected>{{ $category['name'] }}</option>
                                                @else 
                                                    <option value="@php print($category['name']) @endphp">{{ $category['name'] }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </li>
                                    <li>
                                        {{-- Sub Category Select --}}
                                        <select id="searchSubCategorySelect" class="custom-select" name="sub_category" onchange="selectedSubCategoryFilter(event)">
                                            @if($selected_sub_category)
                                                <option selected value="{{$selected_sub_category}}">{{$selected_sub_category}}</option>
                                            @else
                                                <option selected>Sub Category</option>
                                            @endif
                                        </select>
                                    </li>
                                    <li>
                                        {{-- Item Type Select --}}
                                        <select id="searchItemTypeSelect" class="custom-select" name="item_type">
                                            <option selected>Item Type</option>
                                            @if($selected_item_type)
                                                <option selected value="{{$selected_item_type}}">{{$selected_item_type}}</option>
                                            @else
                                                <option selected>Item Type</option>
                                            @endif
                                        </select>
                                    </li>
                                    <li>
                                        {{-- Date Range Select --}}
                                        <input type="text" name="daterange" id="daterange" autocomplete="off" class="form-control datepicker" placeholder="Required Dates">
                                        <input type="hidden" id="startDate" name="start_date" value="">
                                        <input type="hidden" id="endDate" name="end_date" value="">
                                    </li><br>
                                    <li>
                                        <div class="form-check pl-0">
                                            <label class="container form-check-label" for="for_sale">Available for sale
                                                <input class="form-check-input" type="checkbox" value="" id="for_sale" name="for_sale">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-check pl-0">
                                            <label class="container form-check-label" for="listed_by_business">Items listed by business
                                                <input class="form-check-input" type="checkbox" value="" id="listed_by_business" name="listed_by_business">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="form-check pl-0">
                                            <label class="container form-check-label" for="listed_by_individual">Items listed by individuals
                                                <input class="form-check-input" type="checkbox" value="" id="listed_by_individual" name="listed_by_individual">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="text-center mt-4 mb-1">
                                            <button type="button" class="btn btn-primary" onclick="submitSearch()">Search</button>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="/search" class="d-block text-center text-color-black clr-srch" style="color:#000;">Clear search</a>
                                    </li>
                                </ul>
                            </nav>
                            <nav class="mt-4 rounded-border">
                                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                                    <li><button type="button" class="btn btn-outline-primary advanced-search" data-toggle="collapse" data-target="#collapsibleNavbar" aria-expanded="false" aria-controls="collapsibleNavbar">Advance Options 
                                        <!-- <span id="toggle-but">
                                            @if($selected_neighborhood || $selected_condition || $selected_age || $photos)
                                            -
                                            @else
                                            +
                                            @endif
                                        </span>--></button></li>
                                    <div class="collapse @if($selected_neighborhood || $selected_condition || $selected_age || $photos) show @endif navbar-collapse" id="collapsibleNavbar">
                                        <ul class="navbar-nav">
                                            <li class="nav-item">
                                                <select id="searchSelectNeighborhood" class="custom-select mt-4" name="neigborhood">
                                                    @if($selected_neighborhood)
                                                        <option selected value="{{$selected_neighborhood}}">{{$selected_neighborhood}}</option>
                                                    @else
                                                        <option selected disabled>Select Neighborhood</option>
                                                    @endif
                                                </select>
                                            </li>
                                            <li class="nav-item">
                                                <select class="custom-select" name="condition">
                                                    <option @if($selected_condition == null) selected disabled @endif>Select Condition</option>
                                                    <option @if($selected_condition == 'Flawless') selected @endif value="Flawless">Flawless</option>
                                                    <option @if($selected_condition == 'Excellent') selected @endif value="Excellent">Excellent</option>
                                                    <option @if($selected_condition == 'Good') selected @endif value="Good">Good</option>
                                                    <option @if($selected_condition == 'Average') selected @endif value="Average">Average</option>
                                                    <option @if($selected_condition == 'Poor') selected @endif value="Poor">Poor</option>
                                                </select>
                                            </li>
                                            <li class="nav-item">
                                                <select class="custom-select" name="age">
                                                    <option @if($selected_age == null) selected disabled @endif>Select Age</option>
                                                    <option @if($selected_age == 'Less than 1 year') selected @endif value="Less than 1 year">Less than 1 year</option>
                                                    <option @if($selected_age == 'Less than 2 years') selected @endif value="Less than 2 years">Less than 2 years</option>
                                                    <option @if($selected_age == 'Less than 5 years') selected @endif value="Less than 5 years">Less than 5 years</option>
                                                    <option @if($selected_age == 'Less than 10 years') selected @endif value="Less than 10 years">Less than 10 years</option>
                                                    <option @if($selected_age == 'Any age') selected @endif value="Any age">Any age</option>
                                                </select>
                                            </li>
                                            <!-- <li class="nav-item">
                                                <div class="form-check pl-0">
                                                    <label class="container form-check-label" for="show_ads_photo">Show Ads with photos only
                                                        <input class="form-check-input" type="checkbox" @if($photos) checked @endif value="" id="show_ads_photo" name="show_ads_photo">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </li> -->
                                            <li class="nav-item">
                                                <div class="text-center mt-4 mb-3">
                                                    <button type="button" class="btn btn-primary" onclick="submitSearch()">Update Search</button>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </ul>
                            </nav>
                        </div>
                    </aside>
                </div>
            </div>
            <div class="col-md-9">
                <div class="search-content">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group" style="position:relative;">
                                <input type="text" class="form-control search-field" name="keyword" placeholder="Search" value="">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-right">
                                <button type="button" onclick="submitSearch()" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 mb-5">
                        <div class="col-md-7">
                            <h3>Search results:</h3>
                        </div>
                        <div class="col-md-5">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    {{-- ORDER FILTER --}}
                                    <select class="custom-select" name="order_filter" onchange="selectedOrderFilter(event)">
                                        <option value selected disabled>Order By:</option>
                                        <option value="nearest" @php $order === 'nearest' ? print('selected="selected"') : '' @endphp>Nearest First</option>
                                        <option value="user_rating" @php $order === 'user_rating' ? print('selected=selected') : '' @endphp>User rating</option>
                                        <option value="price_lowest" @php $order === 'price_lowest' ? print('selected=selected') : '' @endphp>Price: Lowest to highest</option>
                                        <option value="price_highest" @php $order === 'price_highest' ? print('selected=selected') : '' @endphp>Price: Highest to lowest</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="row no-gutters">
                                        <div class="col-md-6 text-center" onclick="switchLayout('grid')">
                                            <div class="layout-icon grid-icon" id="gridSelect">
                                                <i class="fas fa-th"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-center" onclick="switchLayout('list')">
                                            <div class="layout-icon list-icon" id="listSelect">
                                                <i class="fas fa-list"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    {{-- No Results Message --}}
                    @if (count($products) <= 0)
                    <div class="row mt-3 mb-4">
                        <div class="col-md-12">
                            <br><br><br><br><br>
                            <center><h4>No products found</h4></center>
                        </div>
                    </div>
                    @endif

                    {{-- PRODUCTS GRID LAYOUT --}}
                    <div id="gridLayout">
                        @for($i = 0; $i < count($products); )
                        <div class="row search-results">
                            @for($j = 0; $i < count($products) && $j < 3; $j++)
                            <div class="col-md-4">
                                <div class="product-wrapper">
                                    {{-- IMAGE --}}
                                    <div class="container-fluid">
                                        <div class="row image">
                                            <div class="col-md-12">
                                                <a href="/product/view/{{$products[$i]->id}}">
                                                    <img src="{{asset('uploads')}}{{'/'.$products[$i]->primary_img}}" height="250px" width="270px" style="max-width:100%;">
                                                    {{-- <img src="{{asset('images/can.jpg')}}" height="250px" width="270px" style="max-width:100%;"> --}}
                                                </a>
                                                @if($products[$i]->rent_status == 'Currently Rented')
                                                    <div style="background: #2cb7aa;width: 152px;padding: 4px 14px;position: absolute;margin-top: -17%;color: #fff; margin-left: 3%; border-radius: 5px;">Currently Rented</div>
                                                @elseif($products[$i]->for_sale_only)
                                                <div style="background: #2cb7aa;width: 152px;padding: 4px 14px;position: absolute;margin-top: -17%;color: #fff; margin-left: 3%; border-radius: 5px;">Available for Sale</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @if (!$photos)
                                    <div class="product-details">
                                        <div class="container-fluid">
                                            {{-- DESCRIPTION --}}
                                            <div class="row description">
                                                <div class="col-md-12">
                                                    <div class="">
                                                        <a href="/product/view/{{$products[$i]->id}}" style="color: #000;">
                                                            {{$products[$i]->item_name}}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container-fluid">
                                            {{-- RATING --}}
                                            <div class="row rating">
                                                <div class="col-md-6">
                                                    <span class="price">
                                                        @if($products[$i]->rental_duration_daily)
                                                            AED-{{$products[$i]->daily_aed}}/day
                                                        @elseif($products[$i]->rental_duration_weekly)
                                                            AED-{{$products[$i]->weekly_aed}}/week
                                                        @elseif($products[$i]->rental_duration_monthly)
                                                            AED-{{$products[$i]->monthly_aed}}/month
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="col-md-6 no-padding-row">
                                                    <div class="stars-container">
                                                        <span class="stars">
                                                            <!-- @for ($x = 0; $x < round($products[$i]->rating); $x++)
                                                            @if($x + 1 === (int) round($products[$i]->rating) && round($products[$i]->rating) > $products[$i]->rating)
                                                            <i class="fas fa-star-half-alt"></i>
                                                            @else
                                                            <i class="fas fa-star"></i>
                                                            @endif
                                                            @endfor -->

                                                            @for($x = 0; $x < $products[$i]->rating; $x++)
                                                                <i class="fas fa-star"></i>
                                                            @endfor
                                                        </span>
                                                        @if ($products[$i]->rating > 0)
                                                        <div class="numerical-rating">({{ ceil($products[$i]->rating) }})</div>
                                                        @else
                                                        <div class="numerical-rating">No ratings yet</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container-fluid">
                                            {{-- AVAILABILITY --}}
                                            <div class="row availability">
                                                <div class="col-md-12">
                                                    <div class="dates-container" style="width: 220px;">
                                                        <span class="dates">
                                                            @if((!$products[$i]->rental_duration_daily && !$products[$i]->rental_duration_weekly && !$products[$i]->rental_duration_monthly) && $products[$i]->available_for_sale == 'yes')
                                                                <span><i class="fa fa-bookmark" aria-hidden="true"></i></span>
                                                                <span>
                                                                    Price: AED-{{$products[$i]->sale_price}}    
                                                                </span>
                                                            @else
                                                               <span><i class="fa fa-calendar" aria-hidden="true"></i></span> {{$products[$i]->status}}
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @php $i++ @endphp
                            @endfor
                        </div>
                        @endfor
                    </div>

                    {{-- PRODUCTS LIST LAYOUT --}}
                    <div id="listLayout">
                        @for($i = 0; $i < count($products); $i++)
                        <div class="row list-style">
                            <div class="col-md-4">
                                <div class="product-wrapper">
                                    <a href="/product/view/{{$products[$i]->id}}">
                                        <img src="{{asset('uploads')}}{{'/'.$products[$i]->primary_img}}" height="250px" width="270px" style="max-width:100%;">
                                    </a>
                                    @if($products[$i]->rent_status == 'Currently Rented')
                                        <div style="background: #2cb7aa;width: 152px;padding: 4px 14px;position: absolute;margin-top: -17%;color: #fff; margin-left: 3%; border-radius: 5px;">Currently Rented</div>
                                    @elseif($products[$i]->for_sale_only)
                                        <div style="background: #2cb7aa;width: 152px;padding: 4px 14px;position: absolute;margin-top: -17%;color: #fff; margin-left: 3%; border-radius: 5px;">Available for Sale</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="product-short-desc">
                                    <a href="/product/view/{{$products[$i]->id}}" style="color: #000;">
                                        {{$products[$i]->item_name}}
                                    </a>
                                </div>
                                <div class="product-item-card">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <span class="price">
                                                @if($products[$i]->rental_duration_daily)
                                                    AED-{{$products[$i]->daily_aed}}/day
                                                @elseif($products[$i]->rental_duration_weekly)
                                                    AED-{{$products[$i]->weekly_aed}}/week
                                                @elseif($products[$i]->rental_duration_monthly)
                                                    AED-{{$products[$i]->monthly_aed}}/month
                                                @endif
                                            </span>
                                        </div>
                                        <div class="col-md-6">
                                            <span class="rating">
                                                <span class="stars">
                                                    @for($x = 0; $x < $products[$i]->rating; $x++)
                                                        <i class="fas fa-star"></i>
                                                    @endfor
                                                </span>
                                                @if ($products[$i]->rating > 0)
                                                <div class="numerical-rating">({{ ceil($products[$i]->rating) }})</div>
                                                @else
                                                <div class="numerical-rating">No ratings yet</div>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="item-status">
                                    <span>
                                        @if((!$products[$i]->rental_duration_daily && !$products[$i]->rental_duration_weekly && !$products[$i]->rental_duration_monthly) && $products[$i]->available_for_sale == 'yes')
                                            <span><i class="fa fa-bookmark" aria-hidden="true"></i></span>
                                            <span>
                                                Price: AED-{{$products[$i]->sale_price}}    
                                            </span>
                                        @else
                                        <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                            {{$products[$i]->status}}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- SCRIPTS --}}
<script type="text/javaScript" src="{{ URL::asset('js/neighborhood.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/search.js') }}" defer></script>

{{-- PASS ARRAY TO SCRIPT --}}
<script>
    const categories = @json($categories);
    const subCategories = @json((array) $sub_categories);
    const itemTypes = @json($item_types);

    $(".advanced-search").on("click", function(){
        var txt = $("#toggle-but").text();
        if(txt == '+') {
            $("#toggle-but").text("-");
        }
        else {
            $("#toggle-but").text("+");
        }
    });

    $('#daterange').daterangepicker({
        minDate:new Date(),
    });

    var start_date = '<?php echo $start_date; ?>';
    var end_date = '<?php echo $end_date; ?>';
    if(!!start_date && !!end_date) {
        $("input[name=daterange]").val(start_date + ' - ' + end_date);
    }
    else {
        $("input[name=daterange]").val(''); 
    }

    $("#daterange").on("change", function(){
        var dates = this.value.split("-");
        $("input[name=start_date]").val(dates[0]);
        $("input[name=end_date]").val(dates[1]);
    });

    var selected_location = '<?php echo $selected_location; ?>';
    $("#location").val(selected_location);
</script>
<script>
  $(window).on('load',function() {
        $('button.advanced-search').addClass("collapsed");
  });
</script>
@endsection
