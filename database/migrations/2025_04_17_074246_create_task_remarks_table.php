<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_task_remarks_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('task_remarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->text('remark');
            $table->date('remark_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('task_remarks');
    }
};
