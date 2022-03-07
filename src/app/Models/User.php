<?php
namespace  Showcase\Models{
    use \Showcase\Framework\Database\Models\BaseModel;
    use \Showcase\Framework\Database\DB;
    use \Exception;
    
    class User extends BaseModel
    {
        /**
         * Init the model
         */
        public function __construct(){
            $this->migration = 'User';
            BaseModel::__construct();
        }

        function commands() 
        {
            return DB::factory()->model('Command')->select()->where('userId', $this->id)->get();
        }

        function carts() 
        {
            return DB::factory()->model('Cart')->select()->where('userId', $this->id)->get();
        }

    }

}