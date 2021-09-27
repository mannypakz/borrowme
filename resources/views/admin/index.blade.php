@extends('admin.template')

@section('content')
<div class="container mt-3" style="height:700px;">
	<h3 class="mb-3">Administrator</h3>
	<div class="row">
	  <div class="col-md-6">
	    <div class="card">
	      <div class="card-body">
	        <h5 class="card-title"><b>Users</b></h5>
	        <p class="card-text">See a list of registered users in your system.</p>
	        <a href="admin/users" class="btn btn-primary float-right">Manage</a>
	      </div>
	    </div>
	  </div>
	  <div class="col-md-6">
	    <div class="card">
	      <div class="card-body">
	        <h5 class="card-title"><b>Categories</b></h5>
	        <p class="card-text">Create, Update, Delete categories</p>
	        <a href="admin/categories" class="btn btn-primary float-right">Manage</a>
	      </div>
	    </div>
	  </div>
	</div>
</div>
@endsection