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
    Schema::create('followers', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');      // quem está sendo seguido
        $table->foreignId('follower_id')->constrained('users')->onDelete('cascade'); // quem está seguindo
        $table->timestamps();

        $table->unique(['user_id', 'follower_id']); // previne seguir duas vezes
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('followers');
    }
};
