<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_users', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->enum('gender', ['L', 'P']);
            $table->date('birth');
            $table->string('phone');
            $table->string('photo')->nullable();
            $table->text('address')->nullable();
            $table->string('job')->nullable();
            $table->text('work_address')->nullable();
            $table->text('practice_place_address')->nullable();
            $table->string('office_phone_number')->nullable();
            $table->integer('is_verified')->default(0);
            $table->string('benefits')->nullable();
            $table->float('price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_users');
    }
};
