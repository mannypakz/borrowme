@extends('layouts.template')
@section('content')
<div id="notificationsContainer" class="container">
    <div class="notifications">
        <div class="heading">
            <div class="col-md-12">
                <h3>Recent</h3>
            </div>
        </div>
        <div class="container-fluid">
            @foreach($req as $r)
                <div class="row content">
                    <div class="col-md-1 icon-container">
                        <span class="fa-stack fa-lg">
                            <!-- <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fas fa-bullhorn fa-stack-1x"></i> -->
                        </span>
                    </div>
                    <div class="col-md-11">
                        <p>
                            <form method="post" action="{{route('accept_invite')}}" class="form-inline">
                                @csrf
                                <img src="{{asset('uploads') . '/' . $r->image}}" height="70px" width="90px" style="border-radius: 50%;">
                                {{$r->name}} would like to add you on chat.
                                <input type="hidden" name="user_id" value="{{$r->id}}">
                                <input type="hidden" name="ug_id" value="{{$r->ug_id}}">
                                <div class="form-group" style="margin-left: 2%;">
                                    <button type="submit" class="btn btn-primary btn-sm">Accept</button>
                                </div>
                            </form>
                        </p>
                        <div class="row timestamp">
                            <div class="col-md-12">
                                <span>{{$r->ago}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
