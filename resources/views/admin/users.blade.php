@extends('admin.template')

@section('content')
<div class="container">
	<a href="/admin">&#8678;Back</a>
	<div class="row mt-5">
		<div class="col-md-12">
			<h3 class="mb-4">Users</h3>
			<table class="table table-striped" id="user-table">
				<thead>
					<tr>
						<th>No.</th>
						<th>Email</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@php $i= 1; @endphp
					@foreach($users as $u)
						<tr>
							<td>{{$i}}</td>
							<td>{{$u->email}}</td>
							<form method="post" action="{{route('user_delete')}}">
								@csrf
								<input type="hidden" name="user_id" value="{{$u->id}}">
								<td><button type="submit" class="btn btn-outline-primary">Delete</button></td>
							</form>
						</tr>
						@php $i++; @endphp
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready( function () {
    	$('#user-table').DataTable();
    	$(".dataTables_length select").addClass("show-select");
	});
</script>
@endsection
<style type="text/css">
	.show-select {
		width: 60px;
	}
</style>