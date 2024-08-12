<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguageTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('translationable_id');
            $table->string('translationable_type');
            $table->integer('language_id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('question')->nullable();
            $table->text('answer')->nullable();
            $table->timestamps();

            $table->index(['translationable_id', 'translationable_type'], 'translatable_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('language_translations');
    }
}
