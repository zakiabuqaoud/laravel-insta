<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletePosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('media')->nullable()->after('content');
            $table->enum('status', ['published', 'draft'])->after('media');
            $table->enum('visibility', ['me', 'followers', 'public'])->default('public')->after('status');
            $table->softDeletes();
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
            $table->dropColumn('status');
            $table->dropColumn('visibility');
            $table->dropColumn('media');
            $table->dropSoftDeletes();
        });
    }
}
