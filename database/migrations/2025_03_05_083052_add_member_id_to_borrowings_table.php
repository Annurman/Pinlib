<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('borrowings', function (Blueprint $table) {
        if (!Schema::hasColumn('borrowings', 'member_id')) {
            $table->unsignedBigInteger('member_id')->after('id');
        }
    });
}


public function down()
{
    Schema::table('borrowings', function (Blueprint $table) {
       
        
    });
}


};
