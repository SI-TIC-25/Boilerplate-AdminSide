<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $user = new User();
        Schema::create('model_histories', function (Blueprint $table) use ($user) {
            $table->id();
            $table->morphs('model'); // model_type & model_id
            $table->json('before')->nullable();
            $table->json('after')->nullable();
            $table->enum('action', ['created', 'updated', 'deleted']);
            $table->foreignId('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references($user->getKeyName())->on($user->getTable())->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_histories');
    }
};
