<?php
namespace  Showcase\Controllers{

    use \Showcase\Framework\HTTP\Controllers\BaseController;
    use \Showcase\Framework\Validation\Validator;
    use \Showcase\Framework\HTTP\Links\URL;
    use \Showcase\Framework\Database\DB;
    use \Showcase\Framework\HTTP\Gards\Auth;
    use \Showcase\Framework\HTTP\Routing\Request;
    use \Showcase\Framework\Session\Session;
    use \Showcase\Models\Cart;
    use \Showcase\Models\User;
    use \Showcase\Models\Command;
    use \Showcase\Models\Payment;

    class ShopController extends BaseController{

        /**
         * @return View
         */
        static function index(){
            return self::response()->view('App/welcome');
        }
        
        /**
         * @return View
         */
        static function cart(){
            $cartId = Session::retrieve('cart_id');
            $cart = null;
            if($cartId) {
                $cart = DB::factory()->model('Cart')->select()->where('id', $cartId)->first();
            } else {
                if(Auth::check()) {
                    $cart = DB::factory()->model('Cart')->select()->where('userId', Auth::user()->id)->first();
                }
            }
            return self::response()->view('App/cart', ['cart' => $cart]);
        }
        
        /**
         * @return View
         */
        static function checkout(){
            $cartId = Session::retrieve('cart_id');
            $cart = null;
            if($cartId) {
                $cart = DB::factory()->model('Cart')->select()->where('id', $cartId)->first();
            } else {
                if(Auth::check()) {
                    $cart = DB::factory()->model('Cart')->select()->where('userId', Auth::user()->id)->first();
                }
            }
            if($cart) {
                return self::response()->view('App/checkout', ['cart' => $cart]);
            }
            return self::response()->view('App/cart', ['cart' => $cart]);
        }

        static function cartCount() {
            $cartId = Session::retrieve('cart_id');
            $cart = null;
            if($cartId) {
                $cart = DB::factory()->model('Cart')->select()->where('id', $cartId)->first();
            } else {
                if(Auth::check()) {
                    $cart = DB::factory()->model('Cart')->select()->where('userId', Auth::user()->id)->first();
                }
            }
            $count = 0;
            if($cart) { $count = $cart->linesCount(); }

            return self::response()->json(['cartCount' => $count], 200);
        }
        
        static function addQuantity(Request $request) {
            if(Validator::validate($request->get(), ['line', 'quantity'])){
                $line = DB::factory()->model('CartLine')->select()->where('id', $request->get()['line'])->first();
                if($line) {
                    $line->quantity = $request->get()['quantity'];
                    $line->save();
                }
                return self::response()->json(['lineTotal' => $line->total(),'subTotal' => $line->cart()->subTotal(), 'total' => $line->cart()->total()], 200);
            }
            return self::response()->json(['message' => 'this item was not found in your cart'], 500);
        }
        
        static function removeItemFromCart(Request $request) {
            if(Validator::validate($request->get(), ['line'])){
                $line = DB::factory()->model('CartLine')->select()->where('id', $request->get()['line'])->first();
                $cart = null;
                if($line) {
                    $cart = $line->cart();
                    $line->delete();
                }
                return self::response()->json(['subTotal' => $cart->subTotal(), 'total' => $cart->total()], 200);
            }
            return self::response()->json(['message' => 'this item was not found in your cart'], 500);
        }

        /**
         * Post method
         * @param \Showcase\Framework\HTTP\Routing\Request
         * @return Redirection
         */
        static function command(Request $request){
            if(Validator::validate($request->get(), ['firstname', 'lastname', 'address', 'zip', 'state'])){
                $cartId = Session::retrieve('cart_id');
                $cart = null;
                if($cartId) {
                    $cart = DB::factory()->model('Cart')->select()->where('id', $cartId)->first();
                } else {
                    if(Auth::check()) {
                        $cart = DB::factory()->model('Cart')->select()->where('userId', Auth::user()->id)->first();
                    }
                }

                if(!$cart) { return self::response()->redirect('/checkout'); }
                $user = null;
                if(Auth::guest()) {
                    $user = new User();
                    $user->firstname = $request->get()['firstname'];
                    $user->bcrypt("12345678");
                    $user->lastname = $request->get()['lastname'];
                    $user->address = $request->get()['address'];
                    $user->zip = $request->get()['zip'];
                    $user->country = $request->get()['country'];
                    $user->state = $request->get()['state'];
                    $user->address2 = $request->get()['address2'];

                    $saveInfo = false;
                    if (isset($request->get()['save-info'])) {
                        if ($request->get()['save-info'] == 'on') {
                            $saveInfo = true;
                        }
                    }
                    if($saveInfo) {
                        $user->username = $request->get()['username'];
                        $user->email = $request->get()['email'];
                    } else {
                        if (isset($request->get()['username'])) {
                            $user->username = $request->get()['username'];
                        } else {
                            $user->username = 'anonymous_user_' . rand();
                        }

                        if (isset($request->get()['email'])) {
                            $user->email = $request->get()['email'];
                        } else {
                            $user->email = 'anonymous_user_' . rand();
                        }
                    }

                    $user->save();
                } else {
                    $user = Auth::user();
                    $user->firstname = $request->get()['firstname'];
                    $user->lastname = $request->get()['lastname'];
                    $user->address = $request->get()['address'];
                    $user->zip = $request->get()['zip'];
                    $user->country = $request->get()['country'];
                    $user->state = $request->get()['state'];
                    $user->address2 = $request->get()['address2'];
                    $user->save();
                }

                $command = new Command();
                $command->userId = $user->id;
                $command->promocode = $cart->promocode;
                $command->save();

                foreach($cart->lines() as $line) {
                    $command->addProduct($line->product());
                }

                Session::clear('cart_id');
                $cart->delete();

                //payement
                $paymentType = $request->get()['paymentMethod'];

                $payment = new Payment();
                $payment->commandId = $command->id;
                $payment->amount = floatval($command->total());
                $payment->payed = 0;
                $payment->type = $paymentType;
                $payment->save();
                if($paymentType == 'credit') {
                    $payment->cc_name = $request->get()['cc-name'];
                    $payment->cc_number = strval($request->get()['cc-number']);
                    $payment->cc_expiration = $request->get()['cc-expiration'];
                    $payment->cc_ccv = strval($request->get()['cc-cvv']);
                    $payment->payed = 1;
                }
                $payment->save();
                return self::response()->view('App/thankyou');
            }
            return self::response()->redirect('/checkout'); 
        }

        static function coupon(Request $request) 
        {
            if (Validator::validate($request->get(), ['cart'])) {
                $cart = DB::factory()->model('Cart')->select()->where('id', $request->get()['cart'])->first();
                if($cart) {
                    $cart->promocode = isset($request->get()['coupon']) ? $request->get()['coupon'] : "";
                    $cart->save();
                }
            }

            return self::response()->back(); 
        }
        
        /**
         * Post method
         * @param \Showcase\Framework\HTTP\Routing\Request
         * @return Redirection
         */
        static function addToCart(Request $request){
            if(Validator::validate($request->get(), ['product'])){
                $product = DB::factory()->model('Product')->select()->where('id', $request->get()['product'])->first();
                if(!$product) {
                    return self::response()->json(['message' => 'no product was selected'], 500); 
                }
                $cartId = Session::retrieve('cart_id');
                $cart = null;
                if ($cartId != null) { 
                    $cart = DB::factory()->model('Cart')->select()->where('id', $cartId)->first();
                }

                if(!$cart) {
                    $cart = new Cart();
                    if(Auth::guest()) {
                        $cart->userId = 0;
                    } else {
                        $cart->userId = Auth::user()->id;
                    }
                    $cart->save();
                }

                $cart->addProduct($product);
                Session::store('cart_id', $cart->id);
                return self::response()->json(['message' => 'done'], 200); 
            }
        return self::response()->json(['message' => 'no product was selected'], 500); 
        }
    }
}