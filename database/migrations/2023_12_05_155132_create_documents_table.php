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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->foreignId('branch_id')->constrained('branches');
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('division_id')->constrained('divisions');
            $table->foreignId('section_id')->constrained('sections');
            $table->string('document_access')->comment('1 = Public, 2 = Private, 3 = Confidential');
            $table->string('tags');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
};
