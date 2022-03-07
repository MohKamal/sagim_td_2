<?php
namespace  Showcase\Database\Migrations {
    use \Showcase\Framework\Database\Config\Table;
    use \Showcase\Framework\Database\Config\Column;

    class Command extends Table{

        /**
         * Migration details
         * @return array of columns
         */
        function handle(){
            $this->name = 'commands';
            $this->column(
                Column::factory()->name('id')->autoIncrement()->primary()
            );
            $this->column(
                Column::factory()->name('userId')->int()
            );
            $this->column(
                Column::factory()->name('status')->string()->default('inProgress')
            );
            $this->column(
                Column::factory()->name('promocode')->string()->nullable()
            );
            $this->timespan();
        }
    }
}