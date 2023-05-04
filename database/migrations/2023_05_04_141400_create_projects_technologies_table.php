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
        Schema::create('projects_technologies', function (Blueprint $table) {
            $table->id();
                
            $table->foreignId('project_id')->nullable() 
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('technology_id')->nullable() 
                ->constrained()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects_technologies');
    }
};