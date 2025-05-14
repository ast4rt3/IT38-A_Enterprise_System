<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('first_name');
        $table->string('last_name');
        $table->string('middle_initial')->nullable();
        $table->string('suffix')->nullable();
        $table->string('email')->unique();
        $table->string('phone')->nullable();
        $table->boolean('is_driver')->nullable();
        $table->string('license')->nullable();
        $table->string('region')->nullable();
        $table->string('province')->nullable();
        $table->string('city')->nullable();
        $table->string('password');
        $table->rememberToken();
        $table->timestamps();
    });
}


    public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn([
            'first_name',
            'last_name',
            'middle_initial',
            'suffix',
            'phone',
            'is_driver',
            'license',
            'region',
            'province',
            'city',
        ]);
    });
}

};

