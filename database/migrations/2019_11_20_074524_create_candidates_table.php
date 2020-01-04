<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('national_id');
            $table->string('english_name');
            $table->string('arabic_name');
            $table->string('mobile1');
            $table->string('mobile2');
            $table->integer('tests')->default(0);
            $table->integer('money')->default(0);
            $table->string('notes');
            $table->unsignedBigInteger('skills_card_id')->nullable();
            $table->foreign('skills_card_id')->references('id')->on('skills_cards')->onDelete('set null');
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
        Schema::dropIfExists('candidates');
    }
}
