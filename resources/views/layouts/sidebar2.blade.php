<!-- Main Sidebar Container -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
  
      <span class="brand-text font-weight-light">Search</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">   
      <!-- Sidebar Menu -->
      <form method="GET" action="{{route('search')}}">
        <input type="hidden" name="s" value="true">
      <nav class="mt-2">
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
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="for_sale" name="for_sale">
              <label class="form-check-label" for="for_sale">
              Available for sale
              </label>
            </div>
          </li>
          <li>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="listed_by_business" name="listed_by_business">
              <label class="form-check-label" for="listed_by_business">
              Items listed by business
              </label>
            </div>
          </li>
          <li>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="" id="listed_by_individual" name="listed_by_individual">
              <label class="form-check-label" for="listed_by_individual">
              Items listed by individuals
              </label>
            </div>
          </li>
          <li>
            <button type="button" class="btn btn-primary">Search</button>
          </li>
          <li>
            <a href="#">Clear search</a>
          </li>
        </ul>

        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li>
            <button type="button" class="btn btn-outline-primary" data-toggle="collapse" data-target="#collapsibleNavbar" aria-expanded="false" aria-controls="collapsibleNavbar">Advance Options +</button>
          </li>
          <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
              <li class="nav-item">
                <select class="custom-select" name="neigborhood">
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
                 <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="show_ads_photo" name="show_ads_photo">
                  <label class="form-check-label" for="show_ads_photo">
                  Show Ads with photos only
                  </label>
                </div>
              </li>
              <li class="nav-item">
                <button type="button" class="btn btn-primary">Update Search</button>
              </li>
            </ul>
          </div>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>