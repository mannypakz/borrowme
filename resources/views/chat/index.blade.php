@extends('layouts.template')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
  var database = firebase.database();

  var name = '{{$user->name}}';
  var user_id = '{{$user->id}}';

  database.ref("messages").on("child_added", function(snapshot){
  });

</script>

<div class="container mt-3">
	@if(Session::has('chat_error'))
		<div class="alert alert-danger" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    			<span aria-hidden="true">&times;</span>
  			</button>
			{{Session::get('chat_error')}}
		</div>
	@endif

	@if(Session::has('chat_success'))
		<div class="alert alert-success" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    			<span aria-hidden="true">&times;</span>
  			</button>
			Message request sent!
		</div>
	@endif
	
    <div class="row">
        <div class="col-md-3">
        	<div class="add-person">
        		<label for="btn-add">Add New</label>
        		<button class="btn btn-primary" id="btn-add" data-toggle="collapse" data-target="#collapseExample">+</button>
        	</div>
        	<div class="collapse" id="collapseExample">
        		<form method="post" action="{{route('add_user_group')}}" id="group-add" class="mt-3">
        			@csrf
        			<input type="text" id="add-user" placeholder="Enter user email" name="user_email" autocomplete="off">
        			<input type="hidden" name="user_id">
			  		<input type="submit" value="Add">
        		</form>
			</div>
			@foreach($group_users as $gu)
				<div class="person-lists" onclick="show_text_area('{{$gu}}')">
					<img src="{{asset('/uploads/'.$gu->image)}}" width="50" height="50">
					<span>{{$gu->first_name . ' ' . $gu->last_name}}</span>
					<span class="notif_badge" id="notif-{{$gu->group_user_id}}"></span>
				</div>
			@endforeach
        </div>
        <div class="col-md-7 side-border">
        	<div style="height: 860px;" id="welcom-text" class="mt-5">
        		<center>Nothing selected.</center>
        	</div>
        	<div style="height:860px; display: none;" id="chat-area">
        		<div id="profile-area">
        			<img id="group-user-img" width="50" height="50">
        			<span id="group-user-name"></span>
        		</div>
        		<div id="messages-area" style="height: 700px;"></div>
        		<div id="type-area">
        			<center>
        				<textarea id="type-here" placeholder="Type a message here..."></textarea><input type="image" id="send-msg" src="{{ asset('images/send-icon.png') }}">
        				<input type="hidden" id="current-group-user">
        			</center>
        		</div>
        	</div>
        </div>


    </div>
</div>

<script type="text/javascript">
	var message_counter = 0;
	$(".notif_badge").hide(); //hide the notification badge

	$(document).ready(function(){
		function autocomplete(inp, arr) {
		var currentFocus;
		inp.addEventListener("input", function(e) {
		  var a, b, i, val = this.value;
		  closeAllLists();
		  if (!val) { return false;}
		  currentFocus = -1;
		  a = document.createElement("DIV");
		  a.setAttribute("id", this.id + "autocomplete-list");
		  a.setAttribute("class", "autocomplete-items");
		  this.parentNode.appendChild(a);
		  for (i = 0; i < arr.length; i++) {
		    if (arr[i].email.substr(0, val.length).toUpperCase() == val.toUpperCase()) {
		      b = document.createElement("DIV");
		      b.innerHTML = "<strong>" + arr[i].email.substr(0, val.length) + "</strong>";
		      b.innerHTML += arr[i].email.substr(val.length);
		      b.innerHTML += "<input type='hidden' value='" + arr[i].email + "' data='"+arr[i].id+"'>";
		      b.addEventListener("click", function(e) {
		          inp.value = this.getElementsByTagName("input")[0].value;
		          $("input[name=user_id]").val(this.getElementsByTagName("input")[0].getAttribute('data'));
		          closeAllLists();
		      });
		      a.appendChild(b);
		    }
		  }
		});
	inp.addEventListener("keydown", function(e) {
	  var x = document.getElementById(this.id + "autocomplete-list");
	  if (x) x = x.getElementsByTagName("div");
	  if (e.keyCode == 40) {
	    currentFocus++;
	    addActive(x);
	  } else if (e.keyCode == 38) { //up
	    currentFocus--;
	    addActive(x);
	  } else if (e.keyCode == 13) {
	    e.preventDefault();
	    if (currentFocus > -1) {
	      if (x) x[currentFocus].click();
	    }
	  }
	});
	function addActive(x) {
	if (!x) return false;
	removeActive(x);
	if (currentFocus >= x.length) currentFocus = 0;
	if (currentFocus < 0) currentFocus = (x.length - 1);
	x[currentFocus].classList.add("autocomplete-active");
	}
	function removeActive(x) {
	for (var i = 0; i < x.length; i++) {
	  x[i].classList.remove("autocomplete-active");
	}
	}
	function closeAllLists(elmnt) {
	var x = document.getElementsByClassName("autocomplete-items");
	for (var i = 0; i < x.length; i++) {
	  if (elmnt != x[i] && elmnt != inp) {
	    x[i].parentNode.removeChild(x[i]);
	  }
	}
	}
	
	document.addEventListener("click", function (e) {
	  closeAllLists(e.target);
	});
	}

	var users = '{{$users}}';
	users = JSON.parse(users.replace(/&quot;/g,'"'));
	autocomplete(document.getElementById("add-user"), users);
	/*End of autocomplete*/

	});

	$("#group-add").on("submit", function(e){
		var fd = $("#group-add").serializeArray();
		if(!!fd[1].value && !!fd[2].value) {
			database.ref("/users/"+user_id+"/"+fd[2].value).set({
				"user": fd[1].value
  			});
		}
	});

	$("#send-msg").on("click", function(){
		var msg = $("#type-here").val();
		var id = $("#current-group-user").val();
		database.ref("messages").push().set({
			"from": user_id,
			"to": id,
			"message": msg
  		});
  		// $("#messages-area").html('');
  		// get_messages();
  		$("#type-here").val('');
	});

	var single = '<?php echo $single_ug; ?>';
	if(single !== 'null') {
		show_text_area(single);
	}

	//initialize the message count
	function initialize_count() {
		database.ref("messages").once('value').then((snapshot) => {
			var msgs = snapshot.val();
			var m_count = 0;
			for(const key of Object.keys(msgs)) {
				if(msgs[key].to == user_id) {
					m_count++;
					localStorage.setItem('message_from_'+msgs[key].from+'_to_'+msgs[key].to, m_count);
				}
			}
		});
	}
	initialize_count();

	var count;
	var replies;
	var msg_area_height = $("#messages-area").height();

	function show_text_area(data) {
		var json = JSON.parse(data);
		count = 0; // initialize
		replies = 0;
		$("#messages-area").html('');
		$("#welcom-text").hide();
		$("#chat-area").show();
		$("#current-group-user").val(json.group_user_id);
		$("#group-user-img").attr("src", "{{asset('uploads')}}"+"/"+json.image);
		$("#group-user-name").text(json.first_name + " " + json.last_name);

		// fetch old messages
		database.ref("messages").once('value').then((snapshot) => {
			var hist = snapshot.val();
			if(!!hist) {
				for(const key of Object.keys(hist)) {
					if(user_id == hist[key].from && json.group_user_id == hist[key].to) {
						$("#messages-area").append("<div class='my-message' style='text-align: right;'>"+hist[key].message+"</div>");
						count++;
					}
					else if(hist[key].from == json.group_user_id && hist[key].to == user_id) {
						$("#messages-area").append("<div class='reply'>"+hist[key].message+"</div>");
						count++;
					}
				}
			}
			
			// console.log((msg_area_height + (count * 80)));
			if(count == 0) {
				$("#messages-area").append("<center class='mt-3'>Start a conversation.</center>");
			}
			else {
				$("#messages-area").animate({
   					scrollTop: (msg_area_height + (count * 80))
   				}, 800);
			}

		});

		$('html, body').animate({
        	scrollTop: $("#type-here").offset().top
   		}, 1000);

	}

	var c = 0;
	var m_count = 0;
	// listen for new messages
	database.ref("messages").on("child_added", function(snapshot){
		var cid = $("#current-group-user").val();
		if(snapshot.val().from == user_id && cid == snapshot.val().to) { // I wrote a message
			$("#messages-area").append("<div class='my-message' style='text-align: right;'>"+snapshot.val().message+"</div>");
			
			$("#messages-area").animate({
   				scrollTop: (msg_area_height + (count * 100))
   			}, 800);
		}
		else if(snapshot.val().from == cid && snapshot.val().to == user_id) { // I received a reply
			$("#messages-area").append("<div class='reply'>"+snapshot.val().message+"</div>");
			
			$("#messages-area").animate({
   				scrollTop: (msg_area_height + (count * 100))
   			}, 800);
		}

		if(snapshot.val().to == user_id) {
			m_count++;
			c = localStorage.getItem("message_from_"+snapshot.val().from+"_to_"+snapshot.val().to);
			if(m_count - c > 0) {
				$("#notif-"+snapshot.val().from).removeAttr("style");
				$("#notif-"+snapshot.val().from).text(m_count - c);
			}
			else {
				$("#notif-"+snapshot.val().from).hide();
				$("#notif-"+snapshot.val().from).text("");
			}
		}

 	});
	
	// remove the notif and initialize count again
	$("#type-here").on("click", function(){
		initialize_count();
		var current_tab = $("#current-group-user").val();
		$("#notif-"+current_tab).hide();
	});

</script>

<style type="text/css">
.autocomplete {
/*the container must be positioned relative:*/
position: relative;
display: inline-block;
}
.autocomplete-items {
  /*position: absolute;*/
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}
.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff;
  border-bottom: 1px solid #d4d4d4;
}
.autocomplete-items div:hover {
  /*when hovering an item:*/
  background-color: #e9e9e9;
}
.autocomplete-active {
  /*when navigating through the items using the arrow keys:*/
  background-color: DodgerBlue !important;
  color: #ffffff;
}
.notif_badge {
	padding: 2px 6px;
    background: red;
    border-radius: 50%;
    font-size: 12px;
    color: white;
}
</style>

@endsection
