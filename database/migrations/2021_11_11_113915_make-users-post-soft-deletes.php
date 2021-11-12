<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeUsersPostSoftDeletes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
            $table->index('deleted_at');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->softDeletes();
            $table->index('deleted_at');
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
            $table->dropIndex('deleted_at');
            $table->dropSoftDeletes();
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropIndex('deleted_at');
            $table->dropSoftDeletes();
        });
    }
}
