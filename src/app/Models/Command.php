<?php
namespace  Showcase\Models{
    use \Showcase\Framework\Database\Models\BaseModel;
    use \Showcase\Framework\Database\DB;
    use \Exception;
    
    class Command extends BaseModel
    {
        /**
         * Init the model
         */
        public function __construct(){
            $this->migration = 'Command';
            BaseModel::__construct();
        }

        public function addProduct(Product $product) {
            if(!$product){
                return false;
            }

            $line = new CommandLine();
            $line->productId = $product->id;
            $line->commandId = $this->id;
            $line->quantity = 1;
            $line->price = $product->price;
            $line->save();

            return $line;
        }

        public function lines() {
            return DB::factory()->model('CommandLine')->select()->where('commandId', $this->id)->get();
        }

        public function linesCount() {
            return DB::factory()->model('CommandLine')->select()->where('commandId', $this->id)->count()->run();
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

        public function payment(){
            return DB::factory()->model('Payment')->select()->where('commandId', $this->id)->first();
        }

    }

}