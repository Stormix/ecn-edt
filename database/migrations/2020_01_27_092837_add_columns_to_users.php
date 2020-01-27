<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use DB;
class AddColumnsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->nullable();
            $table->string('avatar')->nullable();
            $table->string('avatar_original')->nullable();
            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('google_id');
            $table->dropColumn('avatar');
            $table->dropColumn('avatar_original');
             /* set null values to 0 first */
            DB::statement('UPDATE `users` SET `password` = 0 WHERE `password` IS NULL;');
            /* alter table */
            DB::statement('ALTER TABLE `users` MODIFY `password` varchar(255) NOT NULL;');
        });
    }
}
