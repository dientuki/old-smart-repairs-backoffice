<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';

            $table->id();
            $table->foreignId('fk_account');
            $table->foreignId('fk_user');
            $table->tinyInteger('fk_rol')->unsigned();
            $table->boolean('is_owner')->unsigned()->default(false);
            $table->boolean('is_active')->unsigned()->default(false);

            $table->foreign('fk_account')->references('id')->on('accounts');
            $table->foreign('fk_user')->references('id')->on('users');
            $table->foreign('fk_rol')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('memberships');
    }
}
