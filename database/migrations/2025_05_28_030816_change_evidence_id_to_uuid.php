<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Hapus auto increment dan ubah tipe id ke char(36)
        Schema::table('evidence', function (Blueprint $table) {
            $table->dropPrimary(); // drop primary int
            $table->char('id', 36)->change(); // ubah ke UUID
        });

        Schema::table('evidence', function (Blueprint $table) {
            $table->primary('id'); // set sebagai PK lagi
        });
    }

    public function down()
    {
        Schema::table('evidence', function (Blueprint $table) {
            $table->dropPrimary();
            $table->integer('id')->autoIncrement()->change();
            $table->primary('id');
        });
    }
};
