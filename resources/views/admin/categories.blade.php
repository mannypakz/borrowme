@extends('admin.template')

@section('content')
<script type="text/javascript" src="{{asset('js/sortable.js')}}"></script>
<div class="container mt-3">
	<a href="/admin">&#8678;Back</a>
	<div class="row">
		<!-- <div class="col-md-6">
			<h4>Menu Structure</h4>
			
			<ul style="height:600px; background-color: #e0e1e0;">
			</ul>
		</div> -->
		<div class="col-md-12">
			<form class="form-inline">
				<div class="form-group mx-sm-3 mb-2">
					<input type="text" class="form-control" id="category-name" placeholder="Category" autocomplete="off" autofocus="autofocus">
				</div>
				<button type="button" class="btn btn-primary mb-2 submit-but" style="padding: 5px 10px;">Add</button>
			</form>
			<small>Drag and drop list items to create a menu.</small>
				@if(count($menu) != 0)
				<div id="category-list">
					{!!html_entity_decode($menu[0]->menu_html)!!}
				</div>
				<form method="post" action="{{route('create_menu')}}" id="menu-form">
					@csrf
					<input type="hidden" name="menu_html">
					<input type="hidden" name="menu_json">
					<input type="hidden" name="json_update" value="false">
					<button class="btn btn-primary float-right d-none" id="update-menu">Update Menu</button>
				</form>
				@else
				<div id="category-list">
					<ol id="category-ol">
					@foreach($categories as $c)
						<li id="category_{{$c->id}}" class="category-but mt-2" data-id="{{$c->id}}" data-name="{{$c->category_name}}" x="1">
							<a href="/category/{{$c->slug}}"{{$c->category_name}}</a>
							<a href="javascript:void(0);" onclick="remove({{$c->id}});" class="hide float-right">&#10005;</a>
							<ol class="sub-menu">
								
							</ol>

						</li>
					@endforeach
					</ol>
				</div>
				<form method="post" action="{{route('create_menu')}}" id="menu-form">
					@csrf
					<input type="hidden" name="menu_html">
					<input type="hidden" name="menu_json">
					<input type="hidden" name="json_update" value="false">
					<button class="btn btn-primary float-right d-none" id="update-menu">Update Menu</button>
				</form>
				@endif
		</div>
	</div>
</div>

<!-- Delete modal -->
<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Delete Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this category including the subcategories inside it?
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary delete-data">Delete</button>
      </div>
    </div>
  </div>
</div>

<form method="post" action="{{route('delete_category')}}" id="delete-cat-form">
	@csrf
	<input type="hidden" name="menu_html">
	<input type="hidden" name="menu_json">
	<input type="hidden" name="delete_id">	
</form>


<script type="text/javascript">
	$(".submit-but").on("click", function(){
		ajax_submit();
	});

	$("#category-name").on("keypress", function(e){
		if(e.which == 13) {
			e.preventDefault();
			ajax_submit();
		}
	});

	function remove(id) {
		$("input[name=delete_id]").val(id);
		$("#delete-modal").modal('show');
	}

	$(".delete-data").on("click", function() {
		var id = $("input[name=delete_id]").val();
		$("#category_"+id).remove();
		var menu_html = $("#category-list").html();
		var data = y.sortable("serialize").get();
		var menu_json = JSON.stringify(data);

		$("input[name=menu_html]").val(menu_html);
		$("input[name=menu_json]").val(menu_json);
		$("#delete-cat-form").submit();
	});

	function ajax_delete_categories(id) {
		$("#delete-modal").modal('hide');
		var fd = new FormData();
		
		fd.append('_token', '<?php echo csrf_token(); ?>');
		fd.append('delete_id', id);
		fd.append('json_update', true);

		if(!!id) {
			$.ajax({
				type: 'POST',
				data: fd,
				url: '/admin/category/delete',
        		contentType: false,
        		processData: false,
        		success: function() {

        		},
        		error: function() {
        			console.log("error");
        		}
			});
		}
	}

	// submission for category name
	function ajax_submit() {
		var category = $("#category-name").val();
		var fd = new FormData();
		fd.append('_token', '<?php echo csrf_token(); ?>');
		fd.append('category_name', category);

		if(!!category) {
			$.ajax({
				type: 'POST',
				data: fd,
				url: '/admin/categories/create',
        		contentType: false,
        		processData: false,
        		success: function(response) {
        			var json = JSON.parse(response);
        			var html = "<li id='category_"+json.id+"' class='category-but mt-2' data-id='"+json.id+"' data-name='"+json.category_name+"'><a href='/category/"+json.slug+"' id='"+json.slug+"'>"+json.category_name+"</a><a href='javascript:void(0);' onclick='remove("+json.id+");' class='hide float-right'>&#10005;</a><ol class='sub-menu'></ol></li>";
        			$("#category-ol").append(html);
        			$("#category-name").val('');
        			ajax_update_menu();
        		},
        		error: function(response) {
        			console.log(response);
        		}
			});
		}
	}

	// submission for menu data
	function ajax_update_menu() {
		var menu_html = $("#category-list").html();
		var data = y.sortable("serialize").get();
		var menu_json = JSON.stringify(data);

		var fd = new FormData();
		fd.append('_token', '<?php echo csrf_token(); ?>');
		fd.append('menu_html', menu_html);
		fd.append('menu_json', menu_json);
		fd.append('json_update', true);

		if(!!menu_html && !!menu_json) {
			$.ajax({
				type: 'POST',
				data: fd,
				url: '/admin/menu/create',
        		contentType: false,
        		processData: false,
        		success: function() {
        			// console.log("success");
        		},
        		error: function() {
        			console.log("error");
        		}
			});
		}
	}

	$("#update-menu").on("click", function(e){
		e.preventDefault();
		var menu_html = $("#category-list").html();
		var data = y.sortable("serialize").get();
		var menu_json = JSON.stringify(data);

		$("input[name=menu_html]").val(menu_html);
		$("input[name=menu_json]").val(menu_json);

		// console.log(menu_json);
		$("#menu-form").submit();
	});

	var oldContainer;
	var y = $("#category-ol").sortable({
	  group: 'nested',
	  afterMove: function (placeholder, container) {
	    if(oldContainer != container){
	      if(oldContainer)
	        oldContainer.el.removeClass("active");
	      container.el.addClass("active");
	      oldContainer = container;
	    }
	  },
	  onDrop: function ($item, container, _super) {
	    container.el.removeClass("active");
	    _super($item, container);
	    $("#update-menu").removeClass("d-none");
        
	  },
	  isValidTarget: function($item, container) {
	  	var depth = 1, // Start with a depth of one (the element itself)
        maxDepth = 3,
        children = $item.find('ol').first().find('li');

	    // Add the amount of parents to the depth
	    depth += container.el.parents('ol').length;

	    // Increment the depth for each time a child
	    while (children.length) {
	        depth++;
	        children = children.find('ol').first().find('li');
	    }

	    return depth <= maxDepth;
	  },
	});
</script>

<style type="text/css">
	.category-but {
		padding: 6px 10px;
    	border: 1px solid;
    	background-color: #cccc;
    	text-align: left;
    	list-style: none;*/
    	margin-top: 1%;
	}
	
	body.dragging, body.dragging * {
	  cursor: move !important;
	}
	li {
		list-style-type: square;
	}
	.dragged {
	  position: absolute;
	  opacity: 0.5;
	  z-index: 2000;
	}
	
	ol.example li.placeholder {
	  position: relative;
	  /** More li styles **/
	}
	ol.example li.placeholder:before {
	  position: absolute;
	  /** Define arrowhead **/
	}
</style>
@endsection