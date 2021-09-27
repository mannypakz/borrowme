@extends('layouts.template')

@section('content')


<div class="container">
	<div class="row mt-4">
		<div class="col-md-3">
			<div class="search-sidebar">
				<!-- Main Sidebar Container -->
				<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
				  <aside>
				    <!-- Sidebar -->
				    <div class="">   
				      <!-- Sidebar Menu -->
				      <form method="GET" action="{{route('search')}}">
				        <input type="hidden" name="s" value="true">
				      <nav class="mt-2 rounded-border">
				      	<!-- Brand Logo -->
					    <a href="index3.html" class="brand-link">
					      <span class="brand-text">Search</span>
					    </a>
				        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				          <!-- Add icons to the links using the .nav-icon class
				               with font-awesome or any other icon font library -->
				          <li>
				            <select class="custom-select" name="category">
				              <option selected disabled>Category</option>
				              <option value="1">One</option>
				              <option value="2">Two</option>
				              <option value="3">Three</option>
				            </select>
				          </li>
				          <li>
				            <select class="custom-select" name="sub_category">
				              <option selected disabled>Sub-Category</option>
				              <option value="1">One</option>
				              <option value="2">Two</option>
				              <option value="3">Three</option>
				            </select>
				          </li>
				          <li>
				            <select class="custom-select" name="item_type">
				              <option selected disabled>Item Type</option>
				              <option value="1">One</option>
				              <option value="2">Two</option>
				              <option value="3">Three</option>
				            </select>
				          </li>
				          <li>
				            <select class="custom-select" name="required_dates">
				              <option selected disabled>Required Dates</option>
				              <option value="1">One</option>
				              <option value="2">Two</option>
				              <option value="3">Three</option>
				            </select>
				          </li>
				          <li>
				            <div class="form-check pl-0">
				              <label class="container form-check-label" for="for_sale">Available for sale
								  <input class="form-check-input" type="checkbox" value="" id="for_sale" name="for_sale" checked>
								  <span class="checkmark"></span>
							  </label>
				            </div>
				          </li>
				          <li>
				            <div class="form-check pl-0">
				              <label class="container form-check-label" for="listed_by_business">Items listed by business
								   <input class="form-check-input" type="checkbox" value="" id="listed_by_business" name="listed_by_business" checked>
								  <span class="checkmark"></span>
							  </label>
				            </div>
				          </li>
				          <li>
				            <div class="form-check pl-0">
				              <label class="container form-check-label" for="listed_by_individual">Items listed by individuals
								   <input class="form-check-input" type="checkbox" value="" id="listed_by_individual" name="listed_by_individual" checked>
								  <span class="checkmark"></span>
							  </label>
				            </div>
				          </li>
				          <li>
				          	<div class="text-center mt-4 mb-1">
				          		<button type="button" class="btn btn-primary">Search</button>
				          	</div>
				          </li>
				          <li>
				            <a href="#" class="d-block text-center text-color-black" style="color:#000;">Clear search</a>
				          </li>
				        </ul>
				      </nav>
				      <nav class="mt-4 rounded-border">
				      	<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				          <li>
				            <button type="button" class="btn btn-outline-primary advanced-search" data-toggle="collapse" data-target="#collapsibleNavbar" aria-expanded="false" aria-controls="collapsibleNavbar">Advance Options +</button>
				          </li>
				          <div class="collapse navbar-collapse" id="collapsibleNavbar">
				            <ul class="navbar-nav">
				              <li class="nav-item">
				                <select class="custom-select mt-4" name="neigborhood">
				                  <option selected disabled>Select Neighborhood</option>
				                  <option value="1">One</option>
				                  <option value="2">Two</option>
				                  <option value="3">Three</option>
				                </select>
				              </li>
				              <li class="nav-item">
				                <select class="custom-select" name="condition">
				                  <option selected disabled>Select Condition</option>
				                  <option value="1">One</option>
				                  <option value="2">Two</option>
				                  <option value="3">Three</option>
				                </select>
				              </li>
				              <li class="nav-item">
				                <select class="custom-select" name="age">
				                  <option selected disabled>Select Age</option>
				                  <option value="1">One</option>
				                  <option value="2">Two</option>
				                  <option value="3">Three</option>
				                </select>
				              </li>
				              <li class="nav-item">
				                 <div class="form-check pl-0">
				                  <label class="container form-check-label" for="show_ads_photo">Show Ads with photos only
									  <input class="form-check-input" type="checkbox" value="" id="show_ads_photo" name="show_ads_photo" checked>
									  <span class="checkmark"></span>
								  </label>
				                </div>
				              </li>
				              <li class="nav-item">
				              	<div class="text-center mt-4 mb-3">
				              		<button type="button" class="btn btn-primary">Update Search</button>
				              	</div>
				              </li>
				            </ul>
				          </div>
				        </ul>
				      </nav>
				      <!-- /.sidebar-menu -->
				    </div>
				    <!-- /.sidebar -->
				  </aside>
			</div>
		</div>
		<div class="col-md-9">
			<div class="search-content">
				<div class="row">
					<div class="col-md-10">
						<div class="form-group">
			    			<input type="text" class="form-control search-field" name="keyword" placeholder="Search">
			  			</div>
					</div>
					<div class="col-sm-2">
						<div class="text-right">
							<button type="submit" class="btn btn-primary">Search</button>
						</div>
					</div>
				</div>
				<div class="row mt-3 mb-5">
					<div class="col-md-7">
						<h3>Search results:</h3>
					</div>
					<div class="col-md-5">
						<div class="row align-items-center">
							<div class="col-md-8">
								<select class="custom-select" name="filter">
					                <option value="nearest">Nearest First</option>
					                <option value="user_rating">User rating</option>
					                <option value="price_lowest">Price: Lowest to highest</option>
					                <option value="price_highest">Price: Highest to lowest</option>
					            </select>
							</div>
							<div class="col-md-2 text-center">
								<div class="grid-icon">
									<i class="fas fa-th"></i>
								</div>
							</div>
							<div class="col-md-2 text-center">
								<div class="list-icon">
									<i class="fas fa-list"></i>
								</div>
							</div>
						</div>
					</div>
					</form>
				</div>
				@for($i = 0; $i < count($products); )
					<div class="row">
					@for($j = 0; $i < count($products) && $j < 3; $j++)
						<div class="col-md-4">
							<div class="product-wrapper">
								<a href="/orders/{{$products[$i]->id}}">
									<img src="{{$products[$i]->image->src}}" height="250px" width="270px" style="max-width:100%;">
								</a>
								<div class="product-short-desc">{{$products[$i]->body_html}}</div>
								<div>
									<span>AED-{{$products[$i]->daily ?? ''}}/day</span>
									<span>
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
										(100)
									</span>
								</div>
								<div>
									<span><i class="fa fa-calendar" aria-hidden="true"></i></span>
									<span>Available for rent</span>
								</div>
							</div>
						</div>
						@php
							$i++
						@endphp
					@endfor
					</div>
				@endfor
			</div>
		</div>
	</div>
</div>
@endsection