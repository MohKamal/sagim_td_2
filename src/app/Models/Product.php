<?php
namespace  Showcase\Models{
    use \Showcase\Framework\Database\Models\BaseModel;
    use \Exception;
    
    class Product extends BaseModel
    {
        /**
         * Init the model
         */
        public function __construct(){
            $this->migration = 'Product';
            BaseModel::__construct();
        }

    }

}