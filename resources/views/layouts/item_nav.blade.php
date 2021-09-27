<div class="item-nav-wrapper">
  <ul class="item-lists">
    <li>
      <div class="nav-border mb-3">
        <a href="{{URL::route('item_index')}}" class="font-weight-bold" id="item">Item Management</a>
      </div>
    </li>
    <li>
      <div class="nav-border mb-3">
        <a href="{{URL::route('item_history')}}" class="font-weight-bold" id="item-history">My Items History</a>
      </div>
    </li>
    <li>
      <div class="nav-border">
        <a href="{{URL::route('order_history')}}" class="font-weight-bold" id="order-history">My Orders History</a>
      </div>
    </li>
  </ul>

  <div class="nav-border mb-3">
    <h3 class="font-weight-bold">Profile</h3>
    <ul>
      <li>
        <a href="{{URL::route('profile_index')}}" id="contact">My Contact Details</a>
      </li>
      <li>
        <a href="{{URL::route('profile_favorite')}}" id="favorite">My Favorite</a>
      </li>
    </ul>
  </div>

  <div class="nav-border mb-3">
     <h3 class="font-weight-bold">Settings</h3>
    <ul>
      <li>
        <a href="{{URL::route('setting_index')}}" id="password">Password Management</a>
      </li>
      <li>
        <a href="{{URL::route('setting_notification')}}" id="notification">Notifications</a>
      </li>
    </ul>
  </div>

  <div class="nav-border">
    <h3 class="font-weight-bold">Products</h3>
    <ul>
      <li>
        <a href="{{URL::route('product_listing')}}">Create</a>
      </li>
    </ul>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    var uri = new URL(window.location.href);
    console.log(uri.pathname);
    switch(uri.pathname) {
      case '/item':
        $("#item").attr("style", "color: #2cb7aa !important");
        break;
      case '/item/history':
        $("#item-history").attr("style", "color: #2cb7aa !important");
        break;
      case '/orders/history':
        $("#order-history").attr("style", "color: #2cb7aa !important");
        break;
      case '/profile':
        $("#contact").attr("style", "color: #2cb7aa !important");
        break;
      case '/profile/favorite':
        $("#favorite").attr("style", "color: #2cb7aa !important");
        break;
      case '/setting':
        $("#password").attr("style", "color: #2cb7aa !important");
        break;
      case '/setting/notification':
        $("#notification").attr("style", "color: #2cb7aa !important");
    }
  });
</script>