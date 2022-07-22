<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddViewsToPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedInteger('views_count')->default(0)->after('visibility');
            $table->unsignedInteger('likes_count')->default(0)->after('views_count');
            $table->unsignedInteger('comments_count')->default(0)->after('likes_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('views_count');
            $table->dropColumn('likes_count');
            $table->dropColumn('comments_count');
        });
    }
}
