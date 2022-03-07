<?php
namespace  Showcase\Database\Migrations {
    use \Showcase\Framework\Database\Config\Table;
    use \Showcase\Framework\Database\Config\Column;

    class CommandLine extends Table{

        /**
         * Migration details
         * @return array of columns
         */
        function handle(){
            $this->name = 'commandlines';
            $this->column(
                Column::factory()->name('id')->autoIncrement()->primary()
            );
            $this->column(
                Column::factory()->name('commandId')->int()
            );
            $this->column(
                Column::factory()->name('productId')->int()
            );
            $this->column(
                Column::factory()->name('price')->double()
            );
            $this->column(
                Column::factory()->name('quantity')->int()->default(1)
            );
            $this->timespan();
        }
    }
}