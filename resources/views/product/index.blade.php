@extends('layouts.admin')

@section('content')

<form class="form-horizontal col-md-input" id="publish-product-form" role='form' method="post" action="products/publish_products">
@csrf

<div class="card" style="padding:20px;">
    
    <div class="row">
    <div class="col-sm-1"><button type="submit" class="btn btn-info class_publish"> Publish </button></div>
    <div class="col-sm-2"><a href="{{config('app.url')}}/products/get_products" class="btn btn-info"> Get Shopify Products </a></div>
    </div><br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th><input type="checkbox" id="checkAll"></th>
                <th>Title</th>
                <th>Product Image</th>
                <th>Description</th>
                <th>Product Type</th>
                <th>For</th>
                <th>Extra/day</th>
                <th>Vendor</th>
                <th>Price</th>    
                <th>Quantity</th>
                <th>Location</th>
                <th>&nbsp;</th>  
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)          
                <tr>
                    <td><input type="checkbox" name="checkid[]" value="<?php echo $product->id?>"></td>
                    <td> {{ $product->title }}</td>
                    <td> <img src="{{asset('uploads/' . $product->product_image)}}" alt="Image" width="100px" height="100px"> </td>
                    <td> {{ $product->product_description }}</td>
                    <td> {{ $product->product_type }}</td>
                    <td> {{ $product->term }}</td>
                    <td> {{ $product->extra_per_day }}</td>
                    <td> {{ $product->vendor }}</td>
                    <td> {{ $product->price }}</td>
                    <td> {{ $product->quantity }}</td>
                    <td> {{ $product->location }}</td>
                    <td> <a href="{{config('app.url')}}/products/{{$product->id}}/edit/" class="btn btn-info"> Edit </a></td>
                </tr>       
            @endforeach
        </tbody>
    </table>
</div>
</form>
@endsection