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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_owner')->default(false);
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_approved')->default(false);
            $table->string('avatar_uri')->nullable();
            $table->string('description', 500)->nullable();
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
            $table->dropColumn([
                'is_owner',
                'is_admin',
                'is_approved',
                'avatar_uri',
                'description',
            ]);
        });
    }
};
