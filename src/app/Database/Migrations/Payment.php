<?php
namespace  Showcase\Database\Migrations {
    use \Showcase\Framework\Database\Config\Table;
    use \Showcase\Framework\Database\Config\Column;

    class Payment extends Table{

        /**
         * Migration details
         * @return array of columns
         */
        function handle(){
            $this->name = 'payments';
            $this->column(
                Column::factory()->name('id')->autoIncrement()->primary()
            );
            $this->column(
                Column::factory()->name('commandId')->int()
            );
            $this->column(
                Column::factory()->name('type')->string()->default('cash')
            );
            $this->column(
                Column::factory()->name('cc_name')->string()->nullable()
            );
            $this->column(
                Column::factory()->name('cc_number')->string()->nullable()
            );
            $this->column(
                Column::factory()->name('cc_expiration')->string()->nullable()
            );
            $this->column(
                Column::factory()->name('cc_ccv')->string()->nullable()
            );
            $this->column(
                Column::factory()->name('amount')->double()
            );
            $this->column(
                Column::factory()->name('payed')->bool()->default(false)
            );
            $this->timespan();
        }
    }
}