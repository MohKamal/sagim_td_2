<?php
namespace  Showcase\Models{
    use \Showcase\Framework\Database\Models\BaseModel;
    use \Exception;
    
    class Payment extends BaseModel
    {
        /**
         * Init the model
         */
        public function __construct(){
            $this->migration = 'Payment';
            BaseModel::__construct();
        }

        public function command(){
            return DB::factory()->model('Command')->select()->where('id', $this->commandId)->first();
        }
    }

}