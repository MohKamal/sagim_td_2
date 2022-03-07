@extend("Layout/shop")
<div class="cart-wrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="main-heading">Shopping Cart</div>
                <div class="table-cart">
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($cart)
                                @foreach($cart->lines() as $line)
                            <tr>
                                <td>
                                    <div class="display-flex align-center">
                                        <div class="img-product">
                                            <img src="https://www.91-img.com/pictures/laptops/asus/asus-x552cl-sx019d-core-i3-3rd-gen-4-gb-500-gb-dos-1-gb-61721-large-1.jpg" alt="" class="mCS_img_loaded">
                                        </div>
                                        <div class="name-product">
                                            {{$line->product()->name}}
                                        </div>
                                        <div class="price">
                                            ${{$line->product()->price}}
                                        </div>
                                    </div>
                                </td>
                                <td class="product-count">
                                    <div class="count-inlineflex">
                                        <div class="qtyminus" data-line="{{$line->id}}">-</div>
                                        <input type="text" name="quantity" value="{{$line->quantity}}" class="qty">
                                        <div class="qtyplus" data-line="{{$line->id}}">+</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="total totalLine">
                                        ${{$line->product()->price * $line->quantity}}
                                    </div>
                                </td>
                                <td>
                                    <a href="#" title="">
                                        <img src="images/icons/delete.png" alt="" class="mCS_img_loaded">
                                    </a>
                                </td>
                            </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div class="coupon-box">
                        <form action="/coupon" method="post" accept-charset="utf-8">
                            @csrf
                            <div class="coupon-input">
                                @if($cart)
                                <input type="hidden" name="cart" value="{{$cart->id}}">
                                <input type="text" name="coupon" placeholder="Coupon Code" value="{{$cart->promocode}}">
                                @else
                                <input type="text" name="coupon" placeholder="Coupon Code">
                                @endif
                                <button type="submit" class="round-black-btn">Apply Coupon</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.table-cart -->
            </div>
            <!-- /.col-lg-8 -->
            <div class="col-lg-4">
                <div class="cart-totals">
                    <h3>Cart Totals</h3>
                    <form action="#" method="get" accept-charset="utf-8">
                        <table>
                            <tbody>
                                <tr>
                                    <td>Subtotal</td>
                                    <td class="subtotal" id="subtotal">${{$cart !== null && !is_string($cart) ? $cart->subTotal() : 00.00}}</td>
                                </tr>
                                <tr>
                                    <td>Shipping</td>
                                    <td class="free-shipping">Free Shipping</td>
                                </tr>
                                <tr class="total-row">
                                    <td>Total</td>
                                    <td class="price-total" id="total">${{$cart !== null && !is_string($cart) ? $cart->total() : 00.00}}</td>
                                </tr>
                            </tbody>
                        </table>
                        @if($cart)
                        <div class="btn-cart-totals">
                            <a href="/checkout" class="checkout round-black-btn" title="">Proceed to Checkout</a>
                        </div>
                        @endif
                        <!-- /.btn-cart-totals -->
                    </form>
                    <!-- /form -->
                </div>
                <!-- /.cart-totals -->
            </div>
            <!-- /.col-lg-4 -->
        </div>
    </div>
</div>
@csrf

@section("CSS")
<link href="./css/cart.css" rel="stylesheet" />
@endsection
@section("JS")
<script src="./js/cart.js"></script>
@endsection