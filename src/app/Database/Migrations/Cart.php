<?php
namespace  Showcase\Database\Migrations {
    use \Showcase\Framework\Database\Config\Table;
    use \Showcase\Framework\Database\Config\Column;

    class Cart extends Table{

        /**
         * Migration details
         * @return array of columns
         */
        function handle(){
            $this->name = 'carts';
            $this->column(
                Column::factory()->name('id')->autoIncrement()->primary()
            );
            $this->column(
                Column::factory()->name('userId')->int()
            );
            $this->column(
                Column::factory()->name('promocode')->string()->nullable()
            );
            $this->timespan();
        }
    }
}