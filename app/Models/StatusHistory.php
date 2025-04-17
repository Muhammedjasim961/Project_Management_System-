<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    public function up()
    {
        Schema::create('status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'in_progress', 'completed']);
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }
}
