<?php
namespace  Showcase\Database\Seed {    

    use \Showcase\Framework\Database\Seeding\Seeder;
    use \Showcase\Framework\HTTP\Controllers\BaseController;
    use \Showcase\Framework\Utils\Utilities;
    use \Showcase\Framework\Database\DB;
    use \Showcase\Models\Product;

    class ProductSeeder extends Seeder{

        /**
         * Seeder details
         */
        function execute(){
            $this->name = 'ProductSeeder';
            
            $p1 = new Product();
            $p1->name = "Fancy Product";
            $p1->price = 23;
            $p1->save();
            
            $p2 = new Product();
            $p2->name = "Special Item";
            $p2->price = 15;
            $p2->save();
            
            $p3 = new Product();
            $p3->name = "Sale Item";
            $p3->price = 19.99;
            $p3->save();
            
            $p4 = new Product();
            $p4->name = "Popular Item";
            $p4->price = 49.99;
            $p4->save();
        }
    }
}