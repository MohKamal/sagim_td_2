<?php
namespace  Showcase\Models{
    use \Showcase\Framework\Database\Models\BaseModel;
    use \Showcase\Framework\Database\DB;
    use \Exception;
    
    class Cart extends BaseModel
    {
        /**
         * Init the model
         */
        public function __construct(){
            $this->migration = 'Cart';
            BaseModel::__construct();
        }

        public function addProduct(Product $product) {
            if(!$product){
                return false;
            }

            $line = new CartLine();
            $line->productId = $product->id;
            $line->cartId = $this->id;
            $line->quantity = 1;
            $line->save();

            return $line;
        }

        public function lines() {
            return DB::factory()->model('CartLine')->select()->where('cartId', $this->id)->get();
        }

        public function linesCount() {
            return DB::factory()->model('CartLine')->select()->where('cartId', $this->id)->count()->run();
        }

        public function subTotal() {
            $total = 0;
            foreach($this->lines() as $line) {
                $total += $line->total();
            }

            return number_format((float)$total, 2, '.', '');
        }

        public function total($shipping=0) {
            $total = number_format((float)($this->subTotal() + $shipping), 2, '.', '');
            if($this->promocode !== "") {
                $total -= 5;
            }

            return $total;
        }

    }

}