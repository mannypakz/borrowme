@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card verification-page">
                @if(session('resend_status') == 'sent')
                    <small style="color:#2cb7aa;">Verification sent! Please check your email</small>
                @endif
                <h2>{{ __('Verification!') }}</h2>
                <p>A 6-digit code is sent to your email address. Kindly enter<br>that code here to activate your account. Thanks!</p>

                <div class="card-body verification-content">
                    <form class="d-inline" method="POST" action="{{ route('verify_process') }}">
                        @csrf
                        <div class="input-group">
                            <input type="text" maxlength="1" onkeypress="return isNumberKey(event, 2)" class="form-control code" name="code1" autocomplete="off">
                            <input type="text" maxlength="1" onkeypress="return isNumberKey(event, 3)" class="form-control code" name="code2" autocomplete="off">
                            <input type="text" maxlength="1" onkeypress="return isNumberKey(event, 4)" class="form-control code" name="code3" autocomplete="off">
                            <input type="text" maxlength="1" onkeypress="return isNumberKey(event, 5)" class="form-control code" name="code4" autocomplete="off">
                            <input type="text" maxlength="1" onkeypress="return isNumberKey(event, 6)" class="form-control code" name="code5" autocomplete="off">
                            <input type="text" maxlength="1" onkeypress="return isNumberKey(event)" class="form-control code" name="code6" autocomplete="off">
                        </div>
                        @if(session('verification_status') == 'error')
                            <small style="color:red">Verification code is incorrect!</small>
                        @endif
                        <div class="form-group text-center mt-5">
                            <button type="submit" class="btn btn-primary">Accept code</button>
                        </div>
                        <div class="text-center">
                            <a href="javascript:void(0);" onclick="resend_code();">Resend confirmation code</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Resend Form -->
<form method="post" action="{{ route('resend_code') }}" id="resend-form">
    @csrf
    <input type="hidden" name="user_id" value="{{$user_id}}">
</form>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
function resend_code() {
    $("#resend-form").submit();
}

function isNumberKey(evt, next = null) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    evt.target.style.backgroundColor = "#2cb7aa";
    evt.target.style.color = "#fff";
    console.log();
    $(".code").next("input[name=code"+next+"]").focus();
    return true;
}

function previous(evt, prev = null) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if(charCode == 8) {
       $("input[name="+prev+"]").prev(".code").focus();
    }
}

$(document).ready(function(){
    $(".code").on("paste", function(e){
        var txt = e.originalEvent.clipboardData.getData('text');
        var inputs = $(".code");
        for(var j = 0; j < txt.length; j++) {
            $("input[name=code" + (parseInt(j) + 1)).val(txt[j]);
        }
    });

    $(".code").on("keyup", function(evt){
        var input = $(this);
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if(charCode == 8) {
            input.prev('.code').focus();
        }
    });
});
</script>