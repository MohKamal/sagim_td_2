<?php
namespace  Showcase\Models{
    use \Showcase\Framework\Database\Models\BaseModel;
    use \Showcase\Framework\Database\DB;
    use \Exception;
    
    class CommandLine extends BaseModel
    {
        /**
         * Init the model
         */
        public function __construct(){
            $this->migration = 'CommandLine';
            BaseModel::__construct();
        }

        public function product(){
            return DB::factory()->model('Product')->select()->where('id', $this->productId)->first();
        }

        public function total() {
            return $this->product()->price * $this->quantity;
        }

        public function command() {
            return DB::factory()->model('Command')->select()->where('id', $this->cartId)->first();
        }

    }

}