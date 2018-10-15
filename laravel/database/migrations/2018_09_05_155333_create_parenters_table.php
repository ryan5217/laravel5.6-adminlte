<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parenters', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('nickname') -> nullable('true') -> comment('称呼');
            $table->string('mobile') -> nullable('true') -> comment('电话号码');
            $table->string('email') -> nullable('true') -> comment('email');
            $table->string('company') -> nullable('true') -> comment('公司名称');
            $table->string('position') -> nullable('true') -> comment('职位');
            $table->text('remark')-> nullable('true') -> comment('备注');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parenters');
    }
}
