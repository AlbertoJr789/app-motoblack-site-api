@php
    echo "<?php".PHP_EOL;
@endphp

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
        Schema::create('{{ $config->tableName }}', function (Blueprint $table) {
            {!! $fields !!}
            $table->boolean('active')->default(true);
            $table->foreignId('creator_id')->references('id')->on('users');
            $table->foreignId('editor_id')->nullable()->references('id')->on('users');
            $table->foreignId('deleter_id')->nullable()->references('id')->on('users');

            Permission::create([ 'name' => '{{$config->modelNames->camel}}.view']);
            Permission::create([ 'name' => '{{$config->modelNames->camel}}.create']);
            Permission::create([ 'name' => '{{$config->modelNames->camel}}.delete']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('{{ $config->tableName }}');
    }
};
