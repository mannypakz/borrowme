@extends('layouts.template')

@section('content')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@if(count($level) > 0)
<div class="container">
  <div class="product-tags mt-4">
    <ul>
      @foreach($level as $l)
        <li><a href="/category/{{strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $l), '-'))}}">{{$l}}</a></li>
      @endforeach
    </ul>
  </div>
</div>
@endif

<div class="container">
	<div class="row mt-4">
		<div class="col-md-3">
			<div class="search-sidebar">
				<!-- Main Sidebar Container -->

				  <aside>
				    <!-- Sidebar -->
				    <div class="">
				      <!-- Sidebar Menu -->
				      <nav class="mt-2 rounded-border">
				      	<!-- Brand Logo -->
				      	<form method="GET">
					    <a href="javascript:void(0);" class="brand-link">
					      <span class="brand-text text-center mb-4 d-block">Search</span>
					    </a>
				        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				          <!-- Add icons to the links using the .nav-icon class
				               with font-awesome or any other icon font library -->
				          <li>
				            <select class="custom-select" name="category" id="category">
                              @if($category)
                                <option value="{{$category}}" selected>{{$category}}</option>
                              @else
                                <option selected disabled>Category</option>
                              @endif
				            </select>
				          </li>
				          <li>
				            <select class="custom-select" name="sub_category" id="sub-category">
				              @if($sub_category)
                                <option value="{{$sub_category}}" selected>{{$sub_category}}</option>
                              @else
                                <option selected disabled>Sub Category</option>
                              @endif
				            </select>
				          </li>
				          <li>
				            <select class="custom-select" name="item_type" id="item-type">
				              @if($item_type)
                                <option value="{{$item_type}}" selected>{{$item_type}}</option>
                              @else
                                <option selected disabled>Item Type</option>
                              @endif
				            </select>
				          </li>
				          <li>
				            <input type="text" id="daterange" name="dr" class="form-control datepicker text-left dr" autocomplete="off" placeholder="Required Dates">
				            <input type="hidden" name="start_date">
				            <input type="hidden" name="end_date">
				          </li>
				          <li>
				            <div class="form-check pl-0">
				              <label class="container form-check-label" for="for_sale">Available for sale
								  <input class="form-check-input" type="checkbox" value="yes" id="for_sale" name="for_sale" @if($for_sale) checked @endif>
								  <span class="checkmark"></span>
							  </label>
				            </div>
				          </li>
				          <li>
				            <div class="form-check pl-0">
				              <label class="container form-check-label" for="listed_by_business">Items listed by business
								   <input class="form-check-input" type="checkbox" value="company" id="listed_by_business" name="listed_by_business" @if($listed_business) checked @endif>
								  <span class="checkmark"></span>
							  </label>
				            </div>
				          </li>
				          <li>
				            <div class="form-check pl-0">
				              <label class="container form-check-label" for="listed_by_individual">Items listed by individuals
								   <input class="form-check-input" type="checkbox" value="individual" id="listed_by_individual" name="listed_by_individual" @if($listed_individual) checked @endif>
								  <span class="checkmark"></span>
							  </label>
				            </div>
				          </li>
				          <li>
				          	<div class="text-center mt-4 mb-1">
				          		<input type="hidden" name="m" value="1">
				          		<button type="submit" class="btn btn-primary">Search</button>
				          	</div>
				          </li>
				          <li>
				            <a href="#" class="d-block text-center text-color-black clear-srch" style="color:#000;">Clear search</a>
				          </li>
				        </ul>
				      </nav>
				      <nav class="mt-4 rounded-border">
				      	<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				          <li>
				           <button type="button" class="btn btn-outline-primary advanced-search" data-toggle="collapse" data-target="#collapsibleNavbar" aria-expanded="false" aria-controls="collapsibleNavbar">Advance Options 
				            <!--	<span id="toggle-but">
				            		@if($neighborhood || $condition || $age || $show_ads)  
				            		-
				            		@else
				            		+
				            		@endif
                      </span> -->
                    </button>
				          </li>
				          <div class="collapse @if($neighborhood || $condition || $age || $show_ads) show @endif navbar-collapse" id="collapsibleNavbar">
				            <ul class="navbar-nav">
				              <li class="nav-item">
				                <select class="custom-select mt-4" name="neigborhood" id="neigborhood">
                                  @if($neighborhood)
                                    <option value="{{$neighborhood}}" selected>{{$neighborhood}}</option>
                                  @else
                                    <option selected disabled>Select Neighborhood</option>
                                  @endif
				                </select>
				              </li>
				              <li class="nav-item">
				                <select class="custom-select" name="condition">
				                  <option @if($condition == null) selected disabled @endif>Select Condition</option>
				                  <option @if($condition == 'Flawless') selected @endif value="Flawless">Flawless</option>
				                  <option @if($condition == 'Excellent') selected @endif value="Excellent">Excellent</option>
				                  <option @if($condition == 'Good') selected @endif value="Good">Good</option>
				                  <option @if($condition == 'Average') selected @endif value="Average">Average</option>
				                  <option @if($condition == 'Poor') selected @endif value="Poor">Poor</option>
				                </select>
				              </li>
				              <li class="nav-item">
				                <select class="custom-select" name="age">
				                  <option @if($age == null) selected disabled @endif>Select Age</option>
				                  <option @if($age == 'Less than 1 year') selected @endif value="Less than 1 year">Less than 1 year</option>
				                  <option @if($age == 'Less than 2 years') selected @endif value="Less than 2 years">Less than 2 years</option>
				                  <option @if($age == 'Less than 5 years') selected @endif value="Less than 5 years">Less than 5 years</option>
				                  <option @if($age == 'Less than 10 years') selected @endif value="Less than 10 years">Less than 10 years</option>
				                  <option @if($age == 'Any age') selected @endif value="Any age">Any age</option>
				                </select>
				              </li>
				              <!-- <li class="nav-item">
				                 <div class="form-check pl-0">
				                  <label class="container form-check-label" for="show_ads_photo">Show Ads with photos only
									  <input class="form-check-input" type="checkbox" @if($show_ads) checked @endif id="show_ads_photo" name="show_ads_photo" value="1">
									  <span class="checkmark"></span>
								  </label>
				                </div>
				              </li> -->
				              <li class="nav-item">
				              	<div class="text-center mt-4 mb-3">
				              		<button type="submit" class="btn btn-primary">Update Search</button>
				              	</div>
				              </li>
				            </ul>
				        	</form>
				          </div>
				        </ul>
				      </nav>
				      <!-- /.sidebar-menu -->
				    </div>
				    <!-- /.sidebar -->
				  </aside>
			</div>
		</div>
        <input type="hidden" name="dist_url" value="{{$dist_url}}">
		<div class="col-md-9">
			<div class="search-content">
				<div class="row">
					<div class="col-md-9">
						<form method="GET">
						<div class="form-group" style="position:relative;">
                <input type="text" class="form-control search-field" name="keyword" placeholder="Search">
                <i class="fas fa-search"></i>
			  			</div>
					</div>
					<div class="col-md-3">
						<div class="text-right">
							<button type="submit" class="btn btn-primary">Search</button>
						</div>
						</form>
					</div>
				</div>
				<div class="row mt-3 mb-5">
					<div class="col-md-7">
						<h3>Search results:</h3>
					</div>
					<div class="col-md-5">
						<div class="row align-items-center">
							<div class="col-md-6">
								<select class="custom-select" name="filter" id="page-filter">
                                    <option @if($page_filter == null) selected @endif disabled>Select filter</option>
					                <option @if($page_filter == 'nearest') selected @endif value="nearest">Nearest First</option>
					                <option @if($page_filter == 'user_rating') selected @endif value="user_rating">User rating</option>
					                <option @if($page_filter == 'price_lowest') selected @endif value="price_lowest">Price: Lowest to highest</option>
					                <option @if($page_filter == 'price_highest') selected @endif value="price_highest">Price: Highest to lowest</option>
					            </select>
              </div>
              <div class="col-md-6">
                  <div class="row no-gutters">
                    <div class="col-md-6 text-center">
                      <div class="grid-icon">
                        <i class="fas fa-th"></i>
                      </div>
                    </div>
                    <div class="col-md-6 text-center">
                      <div class="list-icon">
                        <i class="fas fa-list"></i>
                      </div>
                    </div>
                  </div>
              </div>
							
						</div>
					</div>
				</div>
				<!-- GRID -->
                @if($show_ads)
                    @for($i = 0; $i < count($products); )
                        <div class="row grid-style">
                        @for($j = 0; $i < count($products) && $j < 3; $j++)
                            <div class="col-md-4">
                                <div class="product-wrapper">
                                    <a href="/product/view/{{$products[$i]->id}}">
                                        <img src="{{asset('uploads')}}{{'/'.$products[$i]->primary_img}}" height="250px" width="270px" style="max-width:100%;">
                                    </a>
                                </div>
                            </div>
                            @php
                                $i++
                            @endphp
                        @endfor
                        </div>
                    @endfor
                @else
                    @for($i = 0; $i < count($products); )
                        <div class="row grid-style">
                        @for($j = 0; $i < count($products) && $j < 3; $j++)
                            <div class="col-md-4">
                                <div class="product-wrapper">
                                    <a href="/product/view/{{$products[$i]->id}}">
                                        <img src="{{asset('uploads')}}{{'/'.$products[$i]->primary_img}}" height="250px" width="270px" style="max-width:100%;">
                                    </a>
                                    @if($products[$i]->rent_status == 'Currently Rented')
                                    	<div style="background: #2cb7aa;width: 152px;padding: 4px 14px;position: absolute;margin-top: -16%;color: #fff; margin-left: 2%;">Currently Rented</div>
                                    @elseif($products[$i]->for_sale_only)
                                    	<div style="background: #2cb7aa;width: 152px;padding: 4px 14px;position: absolute;margin-top: -16%;color: #fff; margin-left: 2%;">Available for Sale</div>
                                    @endif
                                    <div class="product-short-desc">
                                    	<a href="/product/view/{{$products[$i]->id}}" style="color:#000">
                                    		{{$products[$i]->item_name}}
                                    	</a>
                                    </div>
                                    <div class="product-item-card">
                                        <div class="row align-items-center">
                                          <div class="col-md-6">
                                            <span class="price">
                                            	@if($products[$i]->rental_duration_daily)
	                                        		AED-{{$products[$i]->daily_aed}}/day
	                                        	@else
	                                        		AED-0/day
	                                        	@endif
                                            </span>
                                          </div>
                                          <div class="col-md-6">
                                            <span class="rating">
                                              @for($n = 0; $n < $products[$i]->rating; $n++)
                                                <i class="fas fa-star"></i>
                                              @endfor

                                              ({{ceil($products[$i]->rating)}})
                                            </span>
                                          </div>
                                        </div>
                                    </div>
                                    @if($products[$i]->for_sale_only)
                                        <div class="item-status">
	                                        <span><i class="fa fa-bookmark" aria-hidden="true"></i></span>
	                                        <span>
	                                        	Price: AED-{{$products[$i]->sale_price}}	
	                                        </span>
	                                    </div>		
                                	@else
	                                	<div class="item-status">
	                                        <span><i class="fa fa-calendar" aria-hidden="true"></i></span>
	                                        <span>
	                                        	{{$products[$i]->status}}	
	                                        </span>
	                                    </div>
                                	@endif
                                </div>
                            </div>
                            @php
                                $i++
                            @endphp
                        @endfor
                        </div>
                    @endfor
                @endif
                <!-- END OF GRID -->

                <!-- LIST -->
                @if($show_ads)
                    @for($i = 0; $i < count($products); $i++)
                        <div class="row list-style">
                            <div class="col-md-4">
                                <div class="product-wrapper">
                                    <a href="/product/view/{{$products[$i]->id}}">
                                        <img src="{{asset('uploads')}}{{'/'.$products[$i]->primary_img}}" height="250px" width="270px" style="max-width:100%;">
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endfor
                @else
                    @for($i = 0; $i < count($products); $i++)
                        <div class="row list-style">
                            <div class="col-md-4">
                                <div class="product-wrapper">
                                    <a href="/product/view/{{$products[$i]->id}}">
                                        <img src="{{asset('uploads')}}{{'/'.$products[$i]->primary_img}}" height="250px" width="270px" style="max-width:100%;">
                                    </a>
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
	                                        	@else
	                                        		AED-0/day
	                                        	@endif
	                                        </span>
	                                      </div>
	                                      <div class="col-md-6">
	                                        <span class="rating">
	                                          @for($n = 0; $n < $products[$i]->rating; $n++)
	                                            <i class="fas fa-star"></i>
	                                          @endfor

	                                          ({{ceil($products[$i]->rating)}})
	                                        </span>
	                                      </div>
	                                    </div>
	                                </div>
                                	<div class="item-status">
                                    	<span><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                    	<span>{{$products[$i]->status}}</span>
                                	</div>
                            </div>
                        </div>
                    @endfor
                @endif
                <!-- END OF LIST -->
			</div>
		</div>
	</div>
</div>
<form method="GET" id="page-filter-form">
	<input type="hidden" name="geo_lat">
	<input type="hidden" name="geo_lng">
    <input type="hidden" name="page_filter" value="{{$page_filter}}">
</form>
<script type="text/javascript">
	$('#daterange').daterangepicker({
		minDate:new Date(),
	});

    // default value of date base on params
    var f_date = '<?php echo $f_date; ?>';
    if(!!f_date) {
        $(".dr").val(f_date);
    }
    else {
        $(".dr").val('');
    }

    // parse date from daterangepicker
	$('.dr').on("change", function() {
		var dates = this.value.split("-");
		$("input[name=start_date]").val(dates[0]);
		$("input[name=end_date]").val(dates[1]);
	});

	var json = '<?php echo $json; ?>';
    json = JSON.parse(json);
    var category = '<?php echo $category; ?>';
    var sub_category = '<?php echo $sub_category; ?>';
    var item_type = '<?php echo $item_type; ?>';

    // for category
    for(var j of Object.keys(json)) {
        if(j != category) {
            var opt = document.createElement("OPTION");
            opt.value = j;
            opt.innerHTML = j;
            document.getElementById("category").appendChild(opt);
        }
    }
    //for sub-category pre-fill
    if(!!category) {
        for(var j of Object.keys(json[category])) {
            if(j != sub_category) {
                var opt = document.createElement("OPTION");
                opt.value = j;
                opt.innerHTML = j;
                document.getElementById("sub-category").appendChild(opt);
            }
        }
    }

    //for item-type pre-fill
    if(!!sub_category) {
        for(var j of Object.keys(json[category][sub_category])) {
            if(json[category][sub_category][j] != item_type) {
                var opt = document.createElement("OPTION");
                opt.value = json[category][sub_category][j];
                opt.innerHTML = json[category][sub_category][j];
                document.getElementById("item-type").appendChild(opt);
                }
        }
    }


    // for sub-category
    $("#category").on("change", function(){
      var val = this.value;
      $("#sub-category").html('');
      $("#item-type").html('');
      $("#sub-category").append("<option selected disabled>Select Sub-category</option>");
      for(var j of Object.keys(json[val])) {
        var opt = document.createElement("OPTION");
        opt.value = j;
        opt.innerHTML = j;
        document.getElementById("sub-category").appendChild(opt);
      }
    });

    // for item-type
    $("#sub-category").on("change", function(){
      var cat = $("#category").val();
      var sub = this.value;
      $("#item-type").append("<option selected disabled>Item type</option>");
      for(var j of Object.keys(json[cat][sub])) {
        var opt = document.createElement("OPTION");
        opt.value = json[cat][sub][j];
        opt.innerHTML = json[cat][sub][j];
        document.getElementById("item-type").appendChild(opt);
      }
    });

    // clear search
    $(".clear-srch").on("click", function(){
        var dist_uri = $("input[name=dist_url]").val();
        window.location.href = "/category/" + dist_uri;
    });

    // filters
    $("#page-filter").on("change", function(){
        $("input[name=page_filter]").val(this.value);
        $("#page-filter-form").submit();
    });

    // page display
    $(".list-icon").on("click", function(){
    	$(".list-style").show();
    	$(".list-style").css("display", "flex");
    	$(".grid-style").hide();
    });
    $(".grid-icon").on("click", function(){
    	$(".list-style").hide();
    	$(".grid-style").show();
    });

    //toggle text
    $(".advanced-search").on("click", function(){
    	var txt = $("#toggle-but").text();
    	if(txt == '+') {
    		$("#toggle-but").text('-');
    	}
    	else {
    		$("#toggle-but").text('+');
    	}
    });

    // Neighborhood
    var city = [];
      city["Abu Dhabi"] = [
        "ADAFZA",
        " AUH Int'l Airport Terminal 1",
        "Abu Dhabi Airport Freezone",
        "Abu Dhabi City Centre",
        " Abu Dhabi Falcon Hospital",
        " Abu Dhabi Formula 1",
        "Abu Dhabi Gate City",
        " Abu Dhabi Golf &amp; Equestrian Club",
        " Abu Dhabi Golf Club &amp; Spa",
        "Abu Dhabi Industrial City",
        "Abu Dhabi International Airport",
        "Abu Dhabi Island",
        " Abu Dhabi Mall",
        " Abu Dhabi National Exhibition Centre",
        " Abu Dhabi University",
        "Airport Road",
        "Al  Ghadeer Village",
        "Al Aman",
        "Al Bahia",
        " Al Bahia Park",
        "Al Bandar",
        "Al Bateen",
        "Al Bateen",
        "Al Bateen Airport",
        " Al Bateen Mall",
        "Al Bateen Villas",
        "Al Dana",
        "Al Dhafrah",
        "Al Fahid",
        "Al Falah City",
        "Al Faqa",
        "Al Ghadeer",
        " Al Ghaf Park",
        "Al Ghazal Golf Club",
        "Al Gurm Mangroves",
        "Al Hisn",
        "Al Ittihad",
        "Al Jurf",
        "Al Karamah",
        "Al Khaleej Al Arabi Street",
        "Al Khalidiyah",
        "Al Khubeirah",
        "Al Lissaily",
        "Al Madina Al Riyadiya",
        "Al Mafraq",
        " Al Mafraq Hospital",
        "Al Manaseer",
        "Al Manhal",
        "Al Maqtaa",
        "Al Maqtaa Village ",
        "Al Markaz",
        "Al Markaziyah",
        "Al Marsa Residences",
        "Al Marsa Villas",
        "Al Maryah Island",
        "Al Matar",
        "Al Mina",
        "Al Mirfa",
        "Al Muneera",
        "Al Muroor",
        "Al Musalla",
        "Al Mushrif",
        "Al Muzoon",
        "Al Nahda (Abu Dhabi)",
        "Al Nahyan",
        "Al Nahyan military Camp",
        "Al Najda",
        "Al Qubesat",
        "Al Qurayyah Island",
        "Al Qurm",
        "Al Qurm Gardens",
        "Al Raha Beach",
        "Al Raha Gardens",
        "Al Raha Lofts",
        " Al Raha Shopping Mall",
        "Al Rahba",
        "Al Ras Al Akhdar",
        "Al Razeem",
        "Al Reef",
        "Al Reef 2",
        "Al Reef Downtown",
        "Al Reef Villas",
        "Al Reem Island",
        "Al Rehhan",
        "Al Rowdah",
        "Al Rumaila",
        "Al Safarat",
        " Al Safeer Mall",
        "Al Salam street",
        "Al Samha",
        "Al Seef",
        "Al Shaleela",
        "Al Shamkha",
        "Al Shamkha South",
        "Al Shatie",
        "Al Shawamekh",
        "Al Thurayya",
        " Al Wahda Mall",
        "Al Wahdah",
        "Al Wathba",
        "Al Zaab",
        "Al Zahiya",
        "Al Zahraa",
        "Al Zeina",
        "Arabian Village",
        "Arzanah",
        "As Suwwah Island",
        "Bain Al Jisrain",
        "Balrmmd Island",
        "Bani Yas",
        "Baniyas City",
        "Belghailam Island Cluster",
        "Between two Bridges",
        "Bisrat Fahid Island Cluster",
        "Bloom Gardens",
        "Capital Centre",
        "Capital Plaza",
        "City of Lights",
        "Coconut Island",
        "Contemporary Village",
        "Corniche",
        "Danet Abu Dhabi",
        "Defense Road",
        "Delma Street",
        "Desert Village",
        "Eastern Road",
        "Electra",
        " Emirates Palace",
        "Futaysi Island",
        " Gargash Round About",
        "Gate District",
        "Ghantoot",
        "Golf Gardens",
        " Guggenheim &amp; Louvre Museums",
        "HIDD Al Saadiyat",
        "Hadbat Al Zafranah",
        " Hamdan Centre",
        "Hills Abu Dhabi",
        "Hodariyat Island",
        "Hydra City",
        "Hydra Village",
        "ICAD 3",
        " ICAD Main Gate",
        "Jawaher",
        " Khalidiyah Mall",
        "Khalifa City A",
        "Khalifa City C",
        "Khalifa Street",
        "Khor Al Raha",
        " Lifeline Hospital",
        "Liwa Street",
        "Liwa Village",
        "Lulu Island",
        "M-12",
        "M-13",
        "M-14",
        "M-15",
        "M-16",
        "M-17",
        "M-19",
        "M-20",
        "M-38",
        "M-39",
        "M-40",
        "M-42",
        "M-43",
        "M-45",
        "M-46",
        "M21",
        "ME-10",
        "ME-11",
        "ME-9",
        "MN-5",
        "MN-6",
        "Madinat Zayed",
        "Madinat Zayed City",
        " Madinat Zayed Shopping Centre",
        "Mamsha Al Saadiyat",
        "Mangrove Area North",
        " Marina Mall",
        "Marina Square",
        "Marina Village",
        "Masdar City",
        "Mediterranean Village",
        " Mina Mall",
        "Mohammed Bin Zayed City",
        "Motor World",
        "Mushrif Gardens",
        "Mussafah",
        "Mussafah Community",
        "Mussafah East",
        "Mussafah Industrial Area",
        "Mussafah Residential &amp; Commercial Area",
        "Najmat",
        " Najmat Reem Marina",
        "Nareel Island",
        "New Shahama",
        "Nudra",
        "Nurai Island",
        "Officers City",
        "Officers Club Area",
        " Police Traffic Dept",
        "Qasr Al Bahr",
        "Qasr El Shatie",
        "Qattouf",
        "Rowdhat",
        "Ruwais",
        "Saadiyat Beach",
        "Saadiyat Beach Residences",
        "Saadiyat Beach Villas",
        "Saadiyat Beach Villas 2",
        "Saadiyat Beach Villas 3",
        "Saadiyat Beach Villas 4",
        "Saadiyat Cultural District",
        "Saadiyat Island",
        "Saadiyat Marina",
        "Saadiyat Retreat",
        "Saadiyat South Beach Promenade",
        "Saadiyat Wetlands Reserve",
        "Samaliyah Island",
        "Sas Al Nakhl Village",
        "Sas An Nakhl Island",
        "Shabiya 12",
        " Shahama Market",
        "Shakhbout City (Khalifa City B)",
        "Shams Abu Dhabi",
        " Sheikh Khalifa Park",
        " Sheikh Zayed Grand Mosque",
        "Soho Square",
        "South Hodariyat Island",
        "Tamouh",
        "Tamouh CBD",
        "The Boardwalk Residence",
        "Tourist Club Area",
        "Umm Al Nar",
        "Umm Yifenah Island",
        "Yas Acres",
        "Yas Circuit &amp; Marina",
        "Yas Entertainment District",
        "Yas Island",
        "Yas Northern Marina Village",
        "Yas Northern Residential &amp; Golf",
        "Yas Southern Marina Village",
        "Yas Village",
        "Yas Waterfront Resorts &amp; Links",
        "Yas West",
        "Zayed Bay",
        "Zayed Sports City",
        "Zone 1",
        "Zone 1",
        "Zone 12",
        "Zone 13",
        "Zone 14",
        "Zone 15",
        "Zone 16",
        "Zone 17",
        "Zone 18",
        "Zone 19",
        "Zone 2",
        "Zone 2",
        "Zone 20",
        "Zone 21",
        "Zone 22",
        "Zone 23",
        "Zone 24",
        "Zone 25",
        "Zone 26",
        "Zone 27",
        "Zone 29",
        "Zone 3",
        "Zone 3",
        "Zone 30",
        "Zone 31",
        "Zone 32",
        "Zone 33",
        "Zone 34",
        "Zone 4",
        "Zone 4",
        "Zone 5",
        "Zone 5",
        "Zone 6",
        "Zone 6",
        "Zone 7",
        "Zone 7",
        "Zone 8",
        "Zone 8",
        "Zone 9"
      ];

      city["Ajman"] = [
        "Ajman Auto Market",
        "Ajman Global City",
        "Ajman Industrial Area",
        "Ajman Industrial Area 1",
        "Ajman Industrial Area 2",
        "Ajman Uptown",
        "Al Alia",
        "Al Bustan",
        "Al Butain",
        "Al Hamriya",
        "Al Helio",
        "Al Helio 1",
        "Al Helio 2",
        "Al Jarrf",
        "Al Jurf",
        "Al Jurf Industrial",
        "Al Manama",
        "Al Mowaihat",
        "Al Mowaihat 1",
        "Al Mowaihat 2",
        "Al Mowaihat 3",
        "Al Nakhil",
        "Al Nuaimia",
        "Al Nuaimia 1",
        "Al Nuaimia 2",
        "Al Nuaimia 3",
        "Al Owan",
        "Al Rashidiya",
        "Al Rawda 1",
        "Al Rawda 2",
        "Al Rawda 3",
        "Al Rumailah",
        "Al Sawan",
        "Al Yasmeen",
        "Al Zahra",
        "Al Zahya",
        "Al Zorah",
        "Corniche Ajman",
        "Emirates City",
        "Garden City",
        "Hamidiya",
        "Masfout",
        "Mushairef",
        "Paradise Lakes Towers",
        "Safia Island",
        "Sheikh Khalifa Bin Zayed"
      ];

      city["Al Ain"] = [
        "Abu Huraybah",
        "Abu Krayyah",
        "Abu Samrah",
        "Al Agabiyya",
        "Al Bateen",
        "Al Dhahra",
        "Al Falaj Hazzaa",
        "Al Foah",
        "Al Grayyeh",
        "Al Haiyir",
        "Al Hili",
        "Al Jimi",
        "Al Khabisi",
        "Al Khazna",
        "Al Maqam",
        "Al Masoudi",
        "Al Muraba'a",
        "Al Mutarad",
        "Al Mutawaa",
        "Al Muwaiji",
        "Al Niyadat",
        "Al Oyoun Village",
        "Al Qattara",
        "Al Quaa",
        "Al Rawdha",
        "Al Salamat",
        "Al Sinaiyah",
        "Al Tawia",
        "Al Wagan",
        "Al Yahar",
        "Al Zahir",
        "Asharij",
        "Gafat Al Nayyar",
        "Jabel Al Hafeet",
        "Mezyad",
        "Nahel",
        "Remah",
        "Shwaib",
        "Um El Zumool",
        "Um Ghafa",
        "Wahat Al Zaweya",
        "Zakher"
      ];

      city["Dubai"] = [
        "29 Burj Boulevard",
        "A La Carte Villas",
        "API Jumeirah Villas",
        "Abbey Crescent",
        "Abu Hail",
        "Acacia",
        "Acacia Avenues",
        "Academic City",
        "Acuna",
        "Adria Villas",
        "Afnan District",
        "Aknan Villas",
        "Aknan Villas",
        "Aknan Villas",
        "Akoya Oxygen",
        "Akoya Play",
        "Akoya Selfie",
        "Al Abraj Street",
        "Al Alka",
        "Al Arta",
        "Al Awir",
        "Al Badaa",
        "Al Badi Complex",
        "Al Baraha",
        "Al Barari",
        "Al Barari Villas",
        "Al Barsha",
        "Al Barsha 1",
        "Al Barsha 2",
        "Al Barsha 3",
        "Al Barsha South",
        "Al Barsha South 1",
        "Al Barsha South 2",
        "Al Barsha South 3",
        "Al Barsha Twin Towers",
        "Al Burooj",
        "Al Burooj Residence V",
        "Al Burooj Residence VII",
        "Al Buteen",
        "Al Daghaya",
        "Al Dhafrah",
        "Al Dhafrah",
        "Al Fattan Marine Towers",
        "Al Furjan",
        "Al Furjan Villas",
        "Al Furjan Villas Phase 2",
        "Al Ghaf",
        "Al Ghozlan",
        "Al Ghurair City Mall",
        "Al Habtoor City",
        "Al Habtoor Polo Resort &amp; Club - The Residences",
        "Al Jaddaf",
        "Al Jafiliya",
        "Al Jaz",
        "Al Khabaisi",
        "Al Khail Gate Phase 1",
        "Al Khail Gate Phase 2",
        "Al Khail Heights",
        "Al Khawaneej",
        "Al Kifaf",
        "Al Maha Towers",
        "Al Mahra",
        "Al Majara Towers",
        "Al Mamzar",
        "Al Manara",
        "Al Mankhool",
        "Al Mass Villas",
        "Al Mizhar",
        "Al Mizhar 1",
        "Al Murar",
        "Al Murooj Complex",
        "Al Muteena",
        "Al Nahda (Dubai)",
        "Al Nahda 1",
        "Al Nahda 2",
        "Al Nakheel",
        "Al Quoz",
        "Al Quoz 1",
        "Al Quoz 2",
        "Al Quoz 3",
        "Al Quoz 4",
        "Al Quoz Industrial Area 1",
        "Al Quoz Industrial Area 2",
        "Al Quoz Industrial Area 3",
        "Al Quoz Industrial Area 4",
        "Al Quoz Industrial District",
        "Al Qusais",
        "Al Qusais 1",
        "Al Qusais 2",
        "Al Qusais Industrial 1",
        "Al Qusais Industrial 2",
        "Al Qusais Industrial 3",
        "Al Qusais Industrial 4",
        "Al Qusais Industrial 5",
        "Al Raffa",
        "Al Rahaba Residences",
        "Al Ramth",
        "Al Ramth 21",
        "Al Ramth 37",
        "Al Ramth 41",
        "Al Ramth 45",
        "Al Ras",
        "Al Reem 1",
        "Al Reem 2",
        "Al Reem 3",
        "Al Rigga",
        "Al Sabkha",
        "Al Safa",
        "Al Safa 1",
        "Al Safa 2",
        "Al Sahab Tower",
        "Al Salam Townhouses",
        "Al Samar",
        "Al Shafar Village",
        "Al Sidir",
        "Al Sufouh",
        "Al Thamam",
        "Al Thammam 12",
        "Al Thammam 18",
        "Al Thammam 47",
        "Al Thammam 55",
        "Al Thammam 7",
        "Al Thayyal",
        "Al Thayyal 2",
        "Al Twar",
        "Al Twar 1",
        "Al Twar 2",
        "Al Twar 3",
        "Al Waha Villas",
        "Al Warqaa",
        "Al Warqaa 1",
        "Al Warqaa 2",
        "Al Warqaa 3",
        "Al Warqaa 4",
        "Al Warqaa 5",
        "Al Warsan",
        "Al Warsan 2",
        "Al Warsan 3",
        "Al Warsan 4",
        "Al Wasl",
        "Al Wasl",
        "Al Wasl Villas",
        "Al Wuheida",
        "Al Yousuf Towers",
        "Albizia",
        "Alma 1",
        "Alma 2",
        "Alma Townhomes",
        "Alvorada",
        "Alvorada 2",
        "Alvorada 3",
        "Alvorada 4",
        "Amaranta",
        "Amargo",
        "Amazonia",
        "American Hospital",
        "Amora Golf Verde",
        "Amsa",
        "Amwaj",
        "Anantara Residences",
        "Aqua Dunya",
        "Aquilegia",
        "Arabella Townhouses",
        "Arabella Townhouses 1",
        "Arabella Townhouses 2",
        "Arabella Townhouses 3",
        "Arabian Crown",
        "Arabian Ranches",
        "Arabian Ranches 2",
        "Arabian Ranches 3",
        "Arjan",
        "Arno",
        "Artesia",
        "Aster",
        "Atlantis The Palm",
        "Atlas Compound",
        "Aura",
        "Aurum Villas",
        "Aurum Villas",
        "Aurum Villas",
        "Aurum Villas",
        "Aurum Villas",
        "Autumn",
        "Avenue Residence",
        "Axis Residence",
        "Ayal Nasir",
        "Aykon City",
        "Azalea",
        "BLVD Crescent",
        "BLVD Heights",
        "BVLGARI Resort and Residences Dubai",
        "Bahar",
        "Balqis Residence Villas",
        "Baniyas Square",
        "Barsha Heights (Tecom)",
        "Barton House",
        "Basswood",
        "Bawadi",
        "Bay Central",
        "Bay Square",
        "Bayti 33",
        "Beach Vista",
        "Belgravia Ellington",
        "Bella Casa",
        "Bellevue Towers",
        "Bennett House",
        "Bliss",
        "Bloomingdale Townhouses",
        "Bluewaters",
        "Bluewaters Residences",
        "Boulevard Central",
        "Boulevard Central Towers",
        "Boulevard Plaza Towers",
        "Bristol Towers",
        "Brookfield",
        "Brookfield 1",
        "Brookfield 2",
        "Brookfield 3",
        "Bungalows Area",
        "Bur Dubai",
        "Burj Al Arab Hotel",
        "Burj Khalifa Area",
        "Burj Khalifa Tower",
        "Burj Park",
        "Burj Place",
        "Burj Residences",
        "Burj Views",
        "Burj Vista",
        "Burjuman Mall",
        "Business Bay",
        "Business Bay Bridge",
        "Business Park Motor City",
        "CASA at Arabian Ranches",
        "CBD (Central Business District)",
        "Cadi Residences",
        "Caesars Bluewaters Dubai",
        "Calida",
        "Camelia",
        "Canal Cove Frond A",
        "Canal Cove Frond B",
        "Canal Cove Frond C",
        "Canal Cove Frond D",
        "Canal Cove Frond E",
        "Canal Cove Frond F",
        "Canal Cove Frond G",
        "Canal Cove Frond H",
        "Canal Cove Frond I",
        "Canal Cove Frond J",
        "Canal Cove Frond K",
        "Canal Cove Frond L",
        "Canal Cove Frond M",
        "Canal Cove Frond N",
        "Canal Cove Frond O",
        "Canal Cove Frond P",
        "Canal Cove Villas",
        "Canal Residence",
        "Canal Villas",
        "Capital Bay",
        "Carmen",
        "Casa Dora",
        "Casa Familia",
        "Casa Flores",
        "Casa Viva",
        "Cassia at the Fields",
        "Cedre Villas",
        "Centaury",
        "Central Park Tower",
        "Century Mall",
        "Champions Towers",
        "Cherrywoods",
        "China Cluster",
        "Churchill Towers",
        "City Oasis",
        "City Walk",
        "City of Arabia",
        "Claren Towers",
        "Claret",
        "Claverton House",
        "Clock Tower",
        "Club Villas at Dubai Hills",
        "Corniche Deira",
        "Coursetia",
        "Creek Golf &amp; Yacht Club",
        "Creek Park",
        "Culture Village",
        "DAMAC Hills (Akoya by DAMAC)",
        "DAMAC Towers by Paramount",
        "DAMAC Towers by Paramount",
        "DANIA DISTRICT",
        "DEC Towers",
        "DIFC",
        "DIFC Gate Building",
        "DIFC Towers",
        "DMC, DIC &amp; KV Freezones",
        "DREAMZ",
        "Daria Island",
        "Deema",
        "Deema 1",
        "Deema 2",
        "Deema 3",
        "Deema 4",
        "Deira",
        "Deira City Centre Mall",
        "Desert Palm",
        "Diamond Arch",
        "Diamond Views",
        "Dickens Circus",
        "Discovery Gardens",
        "District 1",
        "District 2",
        "District 3",
        "District 4",
        "District 5",
        "District 6",
        "District 7",
        "District 7",
        "District 7",
        "District 8",
        "District 9",
        "District One",
        "District One Mansions",
        "District One Villas",
        "Down Town Jebel Ali",
        "Downtown Dubai",
        "Dragon City",
        "Dragon Mart",
        "Dragon Towers",
        "Dream Towers",
        "Dubai Airport Free Zone",
        "Dubai Autodrome",
        "Dubai Creek Golf Club",
        "Dubai Creek Harbour",
        "Dubai Design District",
        "Dubai Festival City",
        "Dubai Harbour",
        "Dubai Healthcare City",
        "Dubai Hills",
        "Dubai Hills Estate",
        "Dubai Hills Grove",
        "Dubai Hills View",
        "Dubai Hospital",
        "Dubai Industrial Park",
        "Dubai International Airport",
        "Dubai International Airport",
        "Dubai Internet City",
        "Dubai Investment Park",
        "Dubai Investment Park 1",
        "Dubai Investment Park 2",
        "Dubai Land",
        "Dubai Lifestyle City",
        "Dubai Marina",
        "Dubai Marina Towers (Emaar 6 Towers)",
        "Dubai Media City",
        "Dubai Museum",
        "Dubai Outlet Mall",
        "Dubai Outsource Zone",
        "Dubai Parks and Resorts",
        "Dubai Production City (IMPZ)",
        "Dubai Residence Complex",
        "Dubai Science Park",
        "Dubai Silicon Oasis",
        "Dubai South",
        "Dubai South 1",
        "Dubai Sports City",
        "Dubai Studio City",
        "Dubai Style Villas",
        "Dubai Taj Mahal",
        "Dubai Tennis Stadium",
        "Dubai World Central",
        "Dubai World Trade Centre",
        "Duraar Towers",
        "Earth",
        "Eden",
        "Eden Apartments",
        "Eden The Valley",
        "Elite Sports Residence",
        "Emaar Beachfront",
        "Emaar Business Park",
        "Emaar Business Park",
        "Emaar South",
        "Emirates Financial Towers",
        "Emirates Gardens 1",
        "Emirates Gardens 2",
        "Emirates Golf Club",
        "Emirates Golf Club Residences",
        "Emirates Hills",
        "Emirates Towers",
        "Empire Heights",
        "England Cluster",
        "Entertainment Foyer (Contemporary Clusters)",
        "Entertainment Foyer (European Clusters)",
        "Entertainment Foyer (Islamic Clusters)",
        "Entertainment Foyer (Mediterranean Clusters)",
        "Entertainment Foyer (Oasis Clusters)",
        "Esmeralda",
        "Eternity",
        "Ettore 971 Bugatti Style Villas",
        "Executive Towers",
        "Expo Golf Villas",
        "Fairway Vistas",
        "Falcon City of Wonders",
        "Family Villas",
        "Fendi Styled Villas",
        "Fiora Golf Verde",
        "Fire",
        "Flame Tree Ridge",
        "Floating Bridge",
        "Forat",
        "Forbidden City",
        "Forest Villas",
        "Forte",
        "Four Seasons Golf Club",
        "Foxhill",
        "France Cluster",
        "Garden East Apartments",
        "Garden Hall (Contemporary Clusters)",
        "Garden Hall (European Clusters)",
        "Garden Hall (Islamic Clusters)",
        "Garden Hall (Mediterranean Clusters)",
        "Garden Hall (Oasis Clusters)",
        "Garden Hall (Tropical Clusters)",
        "Garden Homes",
        "Garden Homes Frond A",
        "Garden Homes Frond B",
        "Garden Homes Frond C",
        "Garden Homes Frond D",
        "Garden Homes Frond E",
        "Garden Homes Frond F",
        "Garden Homes Frond G",
        "Garden Homes Frond H",
        "Garden Homes Frond I",
        "Garden Homes Frond J",
        "Garden Homes Frond K",
        "Garden Homes Frond L",
        "Garden Homes Frond M",
        "Garden Homes Frond N",
        "Garden Homes Frond O",
        "Garden Homes Frond P",
        "Garden View Villas",
        "Garden West Apartments",
        "Gardenia Townhomes",
        "Gardenia Villas",
        "Garhoud",
        "Garhoud Bridge",
        "Gate Precinct",
        "Gateway Towers",
        "German Sports Towers",
        "Ghadeer 1",
        "Ghadeer 2",
        "Ghadeer Community",
        "Ghantoot Race Course and Polo Club",
        "Ghoroob",
        "Glitz 3 by Danube",
        "Global Village",
        "Gold and Diamond Park",
        "Golden Mile",
        "Golden Wood Villas",
        "Golf City",
        "Golf Panorama",
        "Golf Place",
        "Golf Promenade",
        "Golf Promenade",
        "Golf Terrace",
        "Golf Terrace",
        "Golf Towers",
        "Golf Veduta",
        "Golf Vista",
        "Golf Vita",
        "Golfville",
        "Grand Boulevard",
        "Grand Horizon",
        "Grand Paradise",
        "Grand Paradise I",
        "Grand Paradise II",
        "Grand Views",
        "Grandeur Residences",
        "Greece Cluster",
        "Green Community",
        "Green Community East",
        "Green Community Market",
        "Green Community Motor City",
        "Green Community West",
        "Green Diamond Towers",
        "Hacienda",
        "Hajar Stone Villas",
        "Hamriya Port",
        "Hartland Gardenia",
        "Hartland Greens",
        "Hattan",
        "Hattan",
        "Hattan 1",
        "Hattan 2",
        "Hattan 3",
        "Hawthorne",
        "Hayat Townhouses",
        "Heaven",
        "Hor Al Anz",
        "Hor Al Anz East",
        "Hub-Golf Towers",
        "Hydra Twin Towers",
        "Ibn Batuta Mall",
        "Indigo Towers",
        "Indigo Ville 2",
        "Indigo Ville 4",
        "Indigo Ville 6",
        "International City",
        "International City Phase-2",
        "International Modern Hospital",
        "Iris Park Villas",
        "Italy Cluster",
        "J ONE",
        "JAFZA Jebel Ali Free Zone",
        "JAFZA Jebel Ali Free Zone",
        "JBR Jumeirah Beach Residence",
        "JLT Cluster A",
        "JLT Cluster B",
        "JLT Cluster C",
        "JLT Cluster D",
        "JLT Cluster E",
        "JLT Cluster F",
        "JLT Cluster G",
        "JLT Cluster H",
        "JLT Cluster I",
        "JLT Cluster J",
        "JLT Cluster K",
        "JLT Cluster L",
        "JLT Cluster M",
        "JLT Cluster N",
        "JLT Cluster O",
        "JLT Cluster P",
        "JLT Cluster Q",
        "JLT Cluster R",
        "JLT Cluster S (Green Lake Towers)",
        "JLT Cluster T",
        "JLT Cluster U (Al Seef Towers)",
        "JLT Cluster V",
        "JLT Cluster W",
        "JLT Cluster X (Jumeirah Bay Towers)",
        "JLT Cluster Y",
        "JLT Jumeirah Lake Towers",
        "JVC District 10",
        "JVC District 11",
        "JVC District 12",
        "JVC District 13",
        "JVC District 14",
        "JVC District 15",
        "JVC District 16",
        "JVC District 17",
        "JVC District 18",
        "JVC Jumeirah Village Circle",
        "JVT District 1",
        "JVT District 2",
        "JVT District 3",
        "JVT District 4",
        "JVT District 5",
        "JVT District 6",
        "JVT District 7",
        "JVT District 8",
        "JVT District 9",
        "JVT Jumeirah Village Triangle",
        "Janusia",
        "Jasmin",
        "Jebel Ali",
        "Jebel Ali Airport (planned)",
        "Jebel Ali Business Centre",
        "Jebel Ali Hills",
        "Jebel Ali Industrial Area",
        "Jebel Ali Industrial Area 1",
        "Jebel Ali Village",
        "Jenna",
        "Jenna Main Square",
        "Jouri Residences",
        "Joy",
        "Judi Residences",
        "Jumeirah",
        "Jumeirah 1",
        "Jumeirah 2",
        "Jumeirah 3",
        "Jumeirah Bay Island",
        "Jumeirah Beach Park",
        "Jumeirah Golf Estates",
        "Jumeirah Heights",
        "Jumeirah Islands",
        "Jumeirah Islands Townhouses",
        "Jumeirah Mosque",
        "Jumeirah Park",
        "Jumeirah Sands Villas",
        "Jumeirah Village",
        "Juniper",
        "Just Cavalli Villas",
        "Just Cavalli Villas",
        "Kamoon",
        "Karama",
        "Karama Park Area",
        "Kingdom of Sheba",
        "Knowledge Village",
        "La Mer",
        "La Quinta",
        "La Residencia Del Sol",
        "La Riviera Estate",
        "La Rosa",
        "Lake Allure",
        "Lake Almas East",
        "Lake Almas West",
        "Lake Apartments",
        "Lake Elucio",
        "Lakeview Apartments",
        "Layan",
        "Layan Community",
        "Le Grand Chateau",
        "Legacy Nova Villas",
        "Lehbab",
        "Lila",
        "Lilac Park",
        "Lime Tree Valley",
        "Living Legends",
        "Liwan",
        "Lootah Compound",
        "Lotus",
        "Lotus Park",
        "Luxury Villas Area",
        "MAG 5 Boulevard",
        "MAG Eye",
        "MIDTOWN",
        "Madinat Jumeirah Living",
        "Maeen",
        "Maeen 1",
        "Maeen 2",
        "Maeen 3",
        "Maeen 4",
        "Maeen 5",
        "Majan",
        "Maktoum Bridge",
        "Mall of the Emirates",
        "Mamzar Park",
        "Maple 1",
        "Maple 2",
        "Maple 3",
        "Maple at Dubai Hills Estate",
        "Marbella Village",
        "Marina Diamond",
        "Marina Gate",
        "Marina Promenade",
        "Marina Quays",
        "Marina Residence",
        "Marina Residences",
        "Marina View Tower",
        "Marina Walk",
        "Marina Wharf",
        "Marinascape",
        "Maritime City",
        "Marlowe House",
        "Marsa Al Arab",
        "Masakin Al Furjan",
        "Master View (Contemporary Clusters)",
        "Master View (European Clusters)",
        "Master View (Islamic Clusters)",
        "Master View (Mediterranean Clusters)",
        "Master View (Oasis Clusters)",
        "Master View (Tropical Clusters)",
        "Maysan Towers",
        "Mazaya Business Avenue",
        "Meadows Town Centre",
        "Media City",
        "Mediterranean Cluster",
        "Mercato Shopping Mall",
        "Metropolis Lofts",
        "Meydan",
        "Meydan Avenue",
        "Meydan Business Park",
        "Meydan City",
        "Meydan Gated Community",
        "Meydan Heights",
        "Meydan One (Azizi Riviera)",
        "Millenium Estates",
        "Millennium Estate",
        "Mimosa",
        "Mina Rashid",
        "Mira",
        "Mira 1",
        "Mira 2",
        "Mira 3",
        "Mira 4",
        "Mira 5",
        "Mira Oasis",
        "Mira Oasis 1",
        "Mira Oasis 2",
        "Mira Oasis 3",
        "Mirabella",
        "Mirabella 1",
        "Mirabella 2",
        "Mirabella 3",
        "Mirabella 4",
        "Mirabella 5",
        "Mirabella 6",
        "Mirabella 7",
        "Mirabella 8",
        "Mirador",
        "Mirador La Coleccion 1",
        "Mirador La Coleccion 2",
        "Mirador La Colección",
        "Mirdif",
        "Mirdif Hills",
        "Mirdif Villas",
        "Mogul Cluster - Building 148 to Building 202",
        "Mohammad Bin Rashid Boulevard",
        "Mohammed Bin Rashid Al Maktoum City",
        "Mohammed Bin Rashid Gardens",
        "Montgomerie Golf Club",
        "Montrose Residences",
        "Morocco Cluster",
        "Motor City",
        "Mudon",
        "Muhaisnah",
        "Muhaisnah 1",
        "Muhaisnah 2",
        "Muhaisnah 3",
        "Muhaisnah 4",
        "Mulberry",
        "Mulberry Mansions Villas",
        "Mulberry Park",
        "Murano Residences",
        "Muraqqabat",
        "Murjan",
        "Mushrif Park",
        "NASA Villas",
        "NSHAMA Town Square",
        "Nad Al Hamar",
        "Nad Al Shiba",
        "Nad Al Shiba Horse Racing",
        "Naif",
        "Nakheel Townhouses",
        "Nakheel Villas",
        "Naseem Townhouses",
        "Naseem Villas",
        "New Bridge Hills",
        "Nibras Oasis",
        "Niki Lauda Twin Towers",
        "Nirvana",
        "Noor Townhouses",
        "North Village",
        "North West Garden Apartments",
        "Norton Court",
        "OIA Residence",
        "Oasis Towers",
        "Oceana Residences",
        "Oceanic",
        "Odora",
        "Oia Residence",
        "Old Town Residences",
        "Oliva",
        "Olive Point",
        "One Central",
        "Opera District",
        "Opera Villas",
        "Orange Lake",
        "Orchid Park",
        "Oud Al Muteena",
        "Oud Metha",
        "Oxford Villas",
        "Pacific Village",
        "Pacifica",
        "Palm Deira",
        "Palm Jebel Ali",
        "Palm Jebel Ali Gate",
        "Palm Jebel Ali Gate",
        "Palm Views",
        "Palma",
        "Palmera",
        "Palmera 1",
        "Palmera 3",
        "Paloverde",
        "Paloverde",
        "Panorama at the Views",
        "Park Avenue",
        "Park Heights",
        "Park Heights 1",
        "Park Heights 2",
        "Park Island",
        "Park Lane",
        "Park Towers",
        "Park Villas",
        "Parkway Vistas",
        "Pearl Jumeirah",
        "Persia Cluster",
        "Phase 1",
        "Phase 2",
        "Platinum Residences",
        "Polo Homes",
        "Polo Residence",
        "Ponderosa",
        "Port Saeed",
        "Port de La Mer",
        "Prime Villas",
        "Primrose",
        "Queens Meadow",
        "Queue Point",
        "Rahat Villas",
        "Ras Al Khor",
        "Ras Al Khor Car Market",
        "Ras Al Khor Industrial",
        "Ras Al Khor Industrial 1",
        "Ras Al Khor Industrial 2",
        "Ras Al Khor Industrial 3",
        "Rasha",
        "Rashidia",
        "Rashidiya",
        "Redwood",
        "Redwood Avenue",
        "Redwood Park",
        "Reehan",
        "Reem",
        "Reem Community",
        "Regent House",
        "Remraam",
        "Residential City",
        "Richmond Villas",
        "Riggat Al Buteen",
        "Rimal",
        "Ritaj",
        "Rosa",
        "Roxana Residences",
        "Royal Golf Boutique Villas",
        "Royal Pearls",
        "Royal Residence",
        "Ruba",
        "Rufi Residency",
        "Rukan",
        "Russia Cluster",
        "Sadaf",
        "Safa Park",
        "Safeer Towers",
        "Saffron",
        "Safi",
        "Safi Townhouses",
        "Sahara Meadows",
        "Saheel",
        "Samara",
        "Sanctnary",
        "Sanctuary Falls",
        "Satwa",
        "Satwa Round About",
        "Savannah",
        "Seasons Community",
        "Sector E",
        "Sector H",
        "Sector HT",
        "Sector J",
        "Sector L",
        "Sector P",
        "Sector R",
        "Sector S",
        "Sector V",
        "Sector W",
        "Serena",
        "Serenia Residences",
        "Shaikh Hamdan Colony",
        "Shakespeare Circus",
        "Shams",
        "Sheikh Zayed Road",
        "Sherlock Circus",
        "Sherlock House",
        "Shindagha Tunnel",
        "Shoreline Apartments",
        "Shorooq",
        "Sidra Villas",
        "Sidra Villas 1",
        "Sidra Villas 2",
        "Sidra Villas 3",
        "Sienna Lakes",
        "Signature Villas",
        "Signature Villas Frond A",
        "Signature Villas Frond B",
        "Signature Villas Frond C",
        "Signature Villas Frond D",
        "Signature Villas Frond E",
        "Signature Villas Frond F",
        "Signature Villas Frond G",
        "Signature Villas Frond H",
        "Signature Villas Frond I",
        "Signature Villas Frond J",
        "Signature Villas Frond K",
        "Signature Villas Frond L",
        "Signature Villas Frond M",
        "Signature Villas Frond N",
        "Signature Villas Frond O",
        "Signature Villas Frond P",
        "Silver Springs",
        "Silverene",
        "Skycourts Towers",
        "Skyline",
        "Sobha Daffodil",
        "Sobha Hartland",
        "Sobha Hartland Villas",
        "Sobha Ivory Towers",
        "Somerset Mews",
        "Sonapur",
        "South Ridge",
        "South Village",
        "Southwest Apartments",
        "Spain Cluster",
        "Sparkle Towers",
        "Splendour Villas",
        "Spring",
        "Standpoint Towers",
        "Summer",
        "Sun",
        "Sunset Gardens",
        "Sycamore",
        "Tameem Villas",
        "Technology Park",
        "Terrace Apartments",
        "Terranova",
        "The 8",
        "The Address Residences Fountain Views",
        "The Address Sky View Towers",
        "The Aldea",
        "The Alef Residences",
        "The Centro",
        "The Crescent",
        "The Derby Residences",
        "The Dubai Mall",
        "The Fairmont Palm Residences",
        "The Fairways",
        "The Field",
        "The Flora",
        "The Fresh Market",
        "The Galleria Villas",
        "The Gardens",
        "The Gate Village",
        "The Greens",
        "The Heart of Europe",
        "The Hills",
        "The Hive",
        "The Imperial Residence",
        "The Jewels",
        "The Lagoons",
        "The Lakes",
        "The Lawns",
        "The Links",
        "The Lofts",
        "The Meadows",
        "The Meadows 1",
        "The Meadows 2",
        "The Meadows 3",
        "The Meadows 4",
        "The Meadows 5",
        "The Meadows 6",
        "The Meadows 7",
        "The Meadows 8",
        "The Meadows 9",
        "The Nest",
        "The Offices",
        "The Old Town Island",
        "The Onyx Towers",
        "The Palm Deira",
        "The Palm Jebel Ali",
        "The Palm Jebel Ali Gate",
        "The Palm Jumeirah",
        "The Parkway at Dubai Hills",
        "The Plantation, Equestrian &amp; Polo Club",
        "The Polo Townhouses",
        "The Pulse",
        "The Pulse Townhouses Townhouses",
        "The Rainforest",
        "The Roots Akoya Oxygen",
        "The Royal Estates",
        "The Springs",
        "The Springs 1",
        "The Springs 10",
        "The Springs 11",
        "The Springs 12",
        "The Springs 14",
        "The Springs 15",
        "The Springs 2",
        "The Springs 3",
        "The Springs 4",
        "The Springs 5",
        "The Springs 6",
        "The Springs 7",
        "The Springs 8",
        "The Springs 9",
        "The Sundials",
        "The Sustainable City",
        "The Turf",
        "The Valley",
        "The Views",
        "The Villa",
        "The Waves",
        "The Woods",
        "The World",
        "The collection",
        "The-Hills",
        "Tiara Residences",
        "Tijara Town",
        "Tilal Al Ghaf",
        "Time Square Mall",
        "Townhouses",
        "Townhouses Area",
        "Townhouses Area",
        "Travo",
        "Trinity",
        "Trixis",
        "Trump Estates",
        "Tulip Park",
        "Turia",
        "Tuscan Residences",
        "Ubora Towers",
        "Umm Al Sheif",
        "Umm Hurair",
        "Umm Hurair 1",
        "Umm Hurair 2",
        "Umm Ramool",
        "Umm Suqeim",
        "Umm Suqeim 1",
        "Umm Suqeim 2",
        "Umm Suqeim 3",
        "Umm Suqeim Public Beach",
        "Universal Apartments",
        "Uptown Mirdif",
        "Uptown Mirdiff Mall",
        "Uptown Motor City",
        "Urbana",
        "Valencia Park Townhouses",
        "Vardon",
        "Victoria",
        "Victory Heights",
        "Vida Residence",
        "Villa Lantana 1",
        "Villa Lantana 2",
        "Villanova",
        "Viridian at the Fields",
        "Vista Lux",
        "WASL1",
        "Wadi Almardi",
        "Wafi City Mall",
        "Warda Apartments",
        "Warsan Village",
        "Wasl Crystal",
        "Wasl Gate",
        "Water Canal Villas",
        "Waterfront Jebel Ali",
        "West Phase 3",
        "Westar Casablanca Villas",
        "Westar Constellation Villas",
        "Westar Les Castelets",
        "Westar Reflections Villas",
        "Westar Terrace Garden Villas",
        "Westar Vista",
        "Westburry Square",
        "Western Residence North",
        "Weston Court",
        "Whispering Pines",
        "Whitefield",
        "Widcombe House",
        "Wildflower",
        "Winter",
        "World Trade Center",
        "World Trade Centre Residence",
        "Xanadu Residences",
        "Yansoon",
        "Yasmin",
        "Zaafaran",
        "Zabeel",
        "Zabeel 1",
        "Zabeel 2",
        "Zabeel Palace",
        "Zahra Apartments",
        "Zahra Townhouses",
        "Zanzebeel",
        "Zen by Indigo",
        "Zenith Towers",
        "Zinnia",
        "Zinnia",
        "Zulal",
        "Zulal 1",
        "Zulal 2",
        "Zulal 3"
      ];

      city["Fujairah"] = [
        "Address Residences Fujairah Resort",
        "Al Faseel",
        "Dibba",
        "Fujairah Freezone",
        "Gurfah",
        "Hail",
        "Hayl",
        "Kalba",
        "Khor Fakkan",
        "Merashid",
        "Sakamkam",
        "Saniaya",
        "Sharm"
      ];

      city["Ras al Khaimah"] = [
        "AL Mataf",
        "Al Darbijaniyah",
        "Al Dhait",
        "Al Dhait North",
        "Al Dhait South",
        "Al Duhaisah",
        "Al Faslayn",
        "Al Ghail Industrial Area",
        "Al Ghubb",
        "Al Hamra",
        "Al Hamra Village",
        "Al Hudaibah",
        "Al Jazirah Al Hamra",
        "Al Juwais",
        "Al Kharran",
        "Al Mairid",
        "Al Mamourah",
        "Al Marjan Island",
        "Al Nadiyah",
        "Al Nakheel",
        "Al Nudood",
        "Al Qir",
        "Al Qurm",
        "Al Qusaidat",
        "Al Rams",
        "Al Riffa",
        "Al Seer",
        "Al Sharishah",
        "Al Turfa",
        "Al Uraibi",
        "Bab Al Bahr Residences",
        "Cove",
        "Dafan Al Khor",
        "Dahan",
        "Ghalilah",
        "Khuzam",
        "Marina Residences",
        "Mina Al Arab",
        "RAK City",
        "Ras Al Khaimah (South)",
        "Ras Al Khaimah Waterfront",
        "Seih",
        "Shamal Julphar",
        "Shams",
        "Sidroh",
        "Suhaim",
        "The Lagoons",
        "Yasmin Village"
      ];

      city["Sharjah"] = [
        "Abu Shagara",
        "Al Abar",
        "Al Azra",
        "Al Barashi",
        "Al Darari",
        "Al Dhaid",
        "Al Falaj",
        "Al Fayha",
        "Al Fisht",
        "Al Ghaphia",
        "Al Gharayen",
        "Al Gharb",
        "Al Ghubaiba",
        "Al Ghuwair",
        "Al Goaz",
        "Al Hamriyah Free Zone",
        "Al Hazana",
        "Al Heera",
        "Al Jazzat",
        "Al Jubail",
        "Al Juraina",
        "Al Khan",
        "Al Layyeh",
        "Al Mahatah",
        "Al Majaz",
        "Al Majaz 3",
        "Al Mamzar",
        "Al Manakh",
        "Al Mansura",
        "Al Mareija",
        "Al Mirgab",
        "Al Mujarrah",
        "Al Musalla",
        "Al Nabba",
        "Al Nahda (Sharjah)",
        "Al Nasserya",
        "Al Nouf",
        "Al Nud",
        "Al Qadisia",
        "Al Qasba",
        "Al Qasimia",
        "Al Qulayaa",
        "Al Rahmaniya",
        "Al Ramaqia",
        "Al Ramla",
        "Al Ramtha",
        "Al Rifaah",
        "Al Riffa",
        "Al Sabkha",
        "Al Sajaa",
        "Al Shahba",
        "Al Shuwaihean",
        "Al Soor",
        "Al Sweihat",
        "Al Taawun",
        "Al Tai",
        "Al Tala'a",
        "Al Yarmook",
        "Al Zahia",
        "Al Zubair",
        "Al Zubair Orchards",
        "Al khaledia",
        "Al khezamia",
        "Al nishama",
        "Al turrfa",
        "Aljada",
        "Bu Tina",
        "Corniche Al Buhaira",
        "Dasman",
        "Elyash",
        "Emirates Industrial City",
        "Halwan Suburb",
        "Hoshi Area",
        "Industrial Area 1",
        "Industrial Area 10",
        "Industrial Area 11",
        "Industrial Area 12",
        "Industrial Area 13",
        "Industrial Area 14",
        "Industrial Area 15",
        "Industrial Area 16",
        "Industrial Area 17",
        "Industrial Area 2",
        "Industrial Area 3",
        "Industrial Area 4",
        "Industrial Area 5",
        "Industrial Area 6",
        "Industrial Area 7",
        "Industrial Area 8",
        "Industrial Area 9",
        "Juwaiza'a",
        "Maryam Island",
        "Maysaloon",
        "Muwafjah",
        "Muwaileh",
        "Muwailih Commercial",
        "Nasma Residences",
        "Rolla Area",
        "Saif Zone",
        "Samnan",
        "Sharjah Industrial Area",
        "Sharjah Industrial Area 18",
        "Sharjah Waterfront City",
        "Sharqan",
        "Souq Al Haraj / Tasjeel Village",
        "Tilal City",
        "Um Tarrafa",
        "University City",
        "batayeh"
      ];

      city["Umm al Quwain"] = [
        "Al Aahad",
        "Al Dar Al Baida",
        "Al Haditha",
        "Al Hawiyah",
        "Al Humrah",
        "Al Khor",
        "Al Maidan",
        "Al Raas",
        "Al Ramlah",
        "Al Raudah",
        "Al Riqqah",
        "Al Salamah",
        "Defence Camp",
        "Emirates Modern Industrial",
        "Masjid Al Mazroui",
        "Old Town Area",
        "U.A.Q Industrial Area",
        "Umm Al Quwain Marina"
      ];

      // var loc = '';
      // $("#neigborhood").html('<option selected disabled>Select Neighborhood</option>');
      var loc = $("#location").val();
      var nn = '<?php echo $neighborhood; ?>';
      if(!!loc) {
        for(var j = 0; j < city[loc].length; j++) {
            if(nn != city[loc][j]) {
                $("#neigborhood").append("<option value='"+city[loc][j]+"'>"+city[loc][j]+"</option>");
            }
        }
      }

      $("#location").on("change", function(){
        var ct = $(this).val();
        $("#neigborhood").html('');
        // $("#neighbourhood").html('<option>Select Neighborhood</option>');
        for(var i = 0; i < city[ct].length; i++) {
          $("#neigborhood").append("<option value='"+city[ct][i]+"'>"+city[ct][i]+"</option>");
        }
      });
</script>
<script>
  $(window).on('load',function() {
        $('button.advanced-search').addClass("collapsed");
  });
</script>

<style type="text/css">
	.dr {
		width: 100%;
    	text-align: center;
    	margin: 5px 0;
    	padding: 8px;
	}

	.list-style {
		display: none;
	}
</style>
@endsection
