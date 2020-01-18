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
            $table->string('national_id')->nullable();
            $table->string('english_name')->nullable();
            $table->string('arabic_name')->nullable();
            $table->string('mobile1')->nullable();
            $table->string('mobile2')->nullable();
            $table->integer('tests')->default(0)->nullable();
            $table->integer('money')->default(0)->nullable();
            $table->string('notes')->nullable();
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
