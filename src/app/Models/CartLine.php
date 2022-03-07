<?php
namespace  Showcase\Models{
    use \Showcase\Framework\Database\Models\BaseModel;
    use \Showcase\Framework\Database\DB;
    use \Exception;
    
    class CartLine extends BaseModel
    {
        /**
         * Init the model
         */
        public function __construct(){
            $this->migration = 'CartLine';
            BaseModel::__construct();
        }

        public function product(){
            return DB::factory()->model('Product')->select()->where('id', $this->productId)->first();
        }

        public function total() {
            return $this->product()->price * $this->quantity;
        }

        public function cart() {
            return DB::factory()->model('Cart')->select()->where('id', $this->cartId)->first();
        }
    }

}