<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDataChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_changes', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('modified_record_id');
            $table->text('previous_value_of_record')->nullable();
            $table->text('present_value_of_record')->nullable();
            $table->integer('action_type_id')->nullable();
            $table->integer('table_name_id')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('action_type_id')->references('id')->on('action_types')->cascadeOnDelete();
            $table->foreign('table_name_id')->references('id')->on('table_names')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_changes');
    }
}
