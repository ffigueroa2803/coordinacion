<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('numero_documento',4);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('type_request_id');
            $table->foreign('type_request_id')->references('id')->on('type_requests');
            $table->unsignedBigInteger('type_document_id');
            $table->foreign('type_document_id')->references('id')->on('type_documents');
            $table->string('codigo_universitario',10);
            $table->string('numero_recibo',10);
            $table->double('monto', 8, 2);
            $table->tinyInteger('estado', 1)->default(0);
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
        Schema::dropIfExists('documents');
    }
}
