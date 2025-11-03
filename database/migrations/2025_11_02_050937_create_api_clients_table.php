<?php
// database/migrations/xxxx_xx_xx_create_api_clients_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiClientsTable extends Migration
{
    public function up()
    {
        Schema::create('api_clients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('token_hash'); // store hashed token (sha256)
            $table->string('ip_whitelist')->nullable(); // optional CSV of allowed IPs
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('api_clients');
    }
}