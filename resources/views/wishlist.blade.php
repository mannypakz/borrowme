@extends('layouts.app')

@section('content')
<div class="container">
	<h3>Saved Items</h3>
	@for($i = 0; $i < count($saved_items);) 
        <div class="row">
        	@for($j = 0; $i < count($saved_items) && $j < 3; $j++)
        		<div class="col-md-4">
        			<div>{{$saved_items[$i]->name}}</div>
        			<img src="{{$saved_items[$i]->image}}" height="200px" width="250px">
        			<div>
        				Vendor: {{$saved_items[$i]->vendor}}
        			</div>
        		</div>
        		@php
					$i++
				@endphp
        	@endfor
        </div>
    @endfor
</div>
@endsection
