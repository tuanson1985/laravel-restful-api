<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->text('image_banner')->nullable()->after('image'); // Thêm cột image_banner sau cột image
        });
    }

    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('image_banner'); // Xóa cột khi rollback
        });
    }
};
