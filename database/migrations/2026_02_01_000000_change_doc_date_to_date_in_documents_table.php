<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Change doc_date from TIMESTAMP to DATE so historical dates (e.g. 1946)
     * are valid. MySQL TIMESTAMP only supports approx. 1970-2038.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE documents MODIFY doc_date DATE NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE documents MODIFY doc_date TIMESTAMP NULL');
    }
};
