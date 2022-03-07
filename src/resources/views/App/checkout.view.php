@extend("Layout/shop")
<div class="container">
  <div class="row mt-3">
    <div class="col-md-4 order-md-2 mb-4">
      <h4 class="d-flex justify-content-between align-items-center mb-3">
        <span class="text-muted">Your cart</span>
        <span class="badge badge-secondary badge-pill">3</span>
      </h4>
      <ul class="list-group mb-3">
          @foreach($cart->lines() as $line)
        <li class="list-group-item d-flex justify-content-between lh-condensed">
          <div>
            <h6 class="my-0">{{ $line->product()->name }}</h6>
            <small class="text-muted">Quantity: {{ $line->quantity }}</small>
          </div>
          <span class="text-muted">${{ $line->product()->price }}</span>
        </li>
        @endforeach
        <li class="list-group-item d-flex justify-content-between bg-light">
          <div class="text-success">
            <h6 class="my-0">Shipping</h6>
            <small>FREE</small>
          </div>
          <span class="text-success">$0</span>
        </li>
        <li class="list-group-item d-flex justify-content-between bg-light">
          <div class="text-success">
            <h6 class="my-0">Promo code</h6>
            @if($cart->promocode === "")
                <small>NONE</small>
            @else
                <small>{{$cart->promocode}}</small>
            @endif
          </div>
            @if($cart->promocode === "")
                <span class="text-success">$0</span>
            @else
                <span class="text-success">-$5</span>
            @endif
        </li>
        <li class="list-group-item d-flex justify-content-between">
          <span>Total (USD)</span>
          <strong>${{ $cart->total() }}</strong>
        </li>
      </ul>

      <form class="card p-2" action="/coupon" method="post">
          @csrf
        <div class="input-group">
            @if($cart)
            <input type="hidden" name="cart" value="{{$cart->id}}">
            <input type="text" name="coupon" class="form-control" placeholder="Promo code" value="{{$cart->promocode}}">
            @else
            <input type="text" name="coupon" class="form-control" placeholder="Promo code">
            @endif
          <div class="input-group-append">
            <button type="submit" class="btn btn-secondary">Redeem</button>
          </div>
        </div>
      </form>
    </div>
    <div class="col-md-8 order-md-1">
      <h4 class="mb-3">Billing address</h4>
      <form class="needs-validation" novalidate  action="/command" method="post">
          @csrf
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="firstName">First name</label>
            <input type="text" class="form-control" id="firstName" name="firstname" placeholder="" 
            @if(Auth::check())
                value="{{Auth::user()->firstname}}"
            @endif  
            required>
            <div class="invalid-feedback">
              Valid first name is required.
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="lastName">Last name</label>
            <input type="text" class="form-control" id="lastName" name="lastname" placeholder="" 
            @if(Auth::check())
                value="{{Auth::user()->lastname}}"
            @endif  
            required>
            <div class="invalid-feedback">
              Valid last name is required.
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="username" id="username-label">Username <span class="text-muted">(Optional)</span></label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">@</span>
            </div>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username"
            @if(Auth::check())
                value="{{Auth::user()->username}}" disabled
            @endif  
            >
            <div class="invalid-feedback" style="width: 100%;">
              Your username is required.
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="email" id="email-label">Email <span class="text-muted">(Optional)</span></label>
          <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com"
          @if(Auth::check())
                value="{{Auth::user()->email}}"
          @endif  
          >
          <div class="invalid-feedback">
            Please enter a valid email address for shipping updates.
          </div>
        </div>

        <div class="mb-3">
          <label for="address">Address</label>
          <input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St" required
          @if(Auth::check())
                value="{{Auth::user()->address}}"
          @endif  
          >
          <div class="invalid-feedback">
            Please enter your shipping address.
          </div>
        </div>

        <div class="mb-3">
          <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
          <input type="text" class="form-control" id="address2" name="address2" placeholder="Apartment or suite"
          @if(Auth::check())
                value="{{Auth::user()->address2}}"
          @endif  
          >
        </div>

        <div class="row">
          <div class="col-md-5 mb-3">
            <label for="country">Country</label>
            <select class="custom-select d-block w-100" id="country" name="country" required>
              <option value="">Choose...</option>
              <option>Morocco</option>
            </select>
            <div class="invalid-feedback">
              Please select a valid country.
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <label for="state">State</label>
            <select class="custom-select d-block w-100" id="state" name="state" required>
              <option value="">Choose...</option>
              <option>Rabat</option>
              <option>Casablanca</option>
              <option>Marrakech</option>
            </select>
            <div class="invalid-feedback">
              Please provide a valid state.
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <label for="zip">Zip</label>
            <input type="text" class="form-control" id="zip" name="zip" placeholder="" required
            @if(Auth::check())
                value="{{Auth::user()->zip}}"
            @endif
            >
            <div class="invalid-feedback">
              Zip code required.
            </div>
          </div>
        </div>
        <hr class="mb-4">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" name="same-address" class="custom-control-input" id="same-address">
          <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
        </div>
        @if(Auth::guest())
        <div class="custom-control custom-checkbox">
          <input type="checkbox" name="save-info" class="custom-control-input" id="save-info">
          <label class="custom-control-label" for="save-info">Save this information for next time</label>
        </div>
        @endif
        <hr class="mb-4">

        <h4 class="mb-3">Payment</h4>

        <div class="d-block my-3">
          <div class="custom-control custom-radio">
            <input id="credit" name="paymentMethod" value="credit" type="radio" class="custom-control-input" checked required>
            <label class="custom-control-label" for="credit">Credit card</label>
          </div>
          <div class="custom-control custom-radio">
            <input id="cash" name="paymentMethod" value="cash" type="radio" class="custom-control-input" required>
            <label class="custom-control-label" for="cash">Cash</label>
          </div>
          <div class="custom-control custom-radio">
            <input id="paypal" name="paymentMethod" value="paypal" type="radio" class="custom-control-input" required>
            <label class="custom-control-label" for="paypal">PayPal</label>
          </div>
        </div>
        <div class="row credit-form">
          <div class="col-md-6 mb-3">
            <label for="cc-name">Name on card</label>
            <input type="text" class="form-control" id="cc-name" name="cc-name" placeholder="" required>
            <small class="text-muted">Full name as displayed on card</small>
            <div class="invalid-feedback">
              Name on card is required
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="cc-number">Credit card number</label>
            <input type="text" class="form-control" id="cc-number" name="cc-number" placeholder="" required>
            <div class="invalid-feedback">
              Credit card number is required
            </div>
          </div>
        </div>
        <div class="row credit-form">
          <div class="col-md-3 mb-3">
            <label for="cc-expiration">Expiration</label>
            <input type="text" class="form-control" id="cc-expiration" name="cc-expiration" placeholder="" required>
            <div class="invalid-feedback">
              Expiration date required
            </div>
          </div>
          <div class="col-md-3 mb-3">
            <label for="cc-cvv">CVV</label>
            <input type="text" class="form-control" id="cc-cvv" name="cc-cvv" placeholder="" required>
            <div class="invalid-feedback">
              Security code required
            </div>
          </div>
        </div>
        <div class="row paypal-form">
          <div class="col-md-3 mb-3">
                <div style="white-space: nowrap">
                    <a href="https://www.paypal.com/us/verified/pal=grassbusters%2eemail%40gmail%2ecom" target="_blank">
                        <img src="https://www.paypal.com/en_US/i/icon/verification_seal.gif" alt="Official PayPal Seal" border="0" />
                    </a>
                    <input type="hidden" name="currency_code" value="USD" />
                    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif" alt="PayPal - The safer, easier way to pay online!" /> <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1" />
                </div>    
            </div>
        </div>
        <hr class="mb-4">
        <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
      </form>
    </div>
  </div>


@section("JS")
<script src="./js/checkout.js"></script>
@endsection

@section("CSS")
<style>
    .bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    }

    @media (min-width: 768px) {
    .bd-placeholder-img-lg {
        font-size: 3.5rem;
    }
    }
</style>
<!-- Custom styles for this template -->
<link href="./css/checkout.css" rel="stylesheet">
@endsection