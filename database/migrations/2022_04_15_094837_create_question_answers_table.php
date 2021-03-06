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
    Schema::create('question_answers', function (Blueprint $table) {
      $table->unsignedBigInteger('id', true);
      $table->text('question', 1000);
      $table->text('answer', 1000);
      $table->unsignedBigInteger('title_id');
      $table->unsignedBigInteger('user_id');
      $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
      $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
      $table->foreign('title_id')->references('id')->on('titles')->cascadeOnDelete()
      ->cascadeOnUpdate();
      $table->foreign('user_id')->references('id')->on('users');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('question_answers');
  }
};
