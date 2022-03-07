<?php
namespace  Showcase\Database\Migrations {
    use \Showcase\Framework\Database\Config\Table;
    use \Showcase\Framework\Database\Config\Column;

    class Product extends Table{

        /**
         * Migration details
         * @return array of columns
         */
        function handle(){
            $this->name = 'products';
            $this->column(
                Column::factory()->name('id')->autoIncrement()->primary()
            );
            $this->column(
                Column::factory()->name('name')->string()
            );
            $this->column(
                Column::factory()->name('price')->double()->default(10)
            );
            $this->column(
                Column::factory()->name('image')->string()->nullable()
            );
            $this->timespan();
        }
    }
}