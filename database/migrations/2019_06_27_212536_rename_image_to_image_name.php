<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameImageToImageName extends Migration
{
    private $from = 'image';
    private $to = 'image_name';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->renameColumn($this->from, $this->to);
        });
        Schema::table('rooms', function (Blueprint $table) {
            $table->renameColumn($this->from, $this->to);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->renameColumn($this->to, $this->from);
        });
        Schema::table('rooms', function (Blueprint $table) {
            $table->renameColumn($this->to, $this->from);
        });
    }
}
