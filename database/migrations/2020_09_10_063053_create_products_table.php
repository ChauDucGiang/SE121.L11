<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->integer('category_id');
            $table->string('materials')->comment('Product material');
            $table->string('weaving')->comment('Product weaving')->nullable();
            $table->text('info')->nullable();
            $table->float('price')->nullable();
            $table->string('color')->nullable();
            $table->text('images')->nullable();
            $table->integer('package_id')->nullable();

//            Size Product
            $table->string('size_l')->default(0);
            $table->string('size_w')->default(0);
            $table->string('size_h')->default(0);
//            Container info
            $table->float('ctn_qty')->default(1)->comment('Product quantity of Carton');
            $table->float('ctn_l')->default(0)->comment('Carton length');
            $table->float('ctn_w')->default(0)->comment('Carton width');
            $table->float('ctn_h')->default(0)->comment('Carton height');
            $table->float('cbm', 8, 8)->default(0)->comment('Carton volume');
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
}
