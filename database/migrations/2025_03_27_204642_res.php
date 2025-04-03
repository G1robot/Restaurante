<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Restaurante', function (Blueprint $table) {
            $table->id('id_restaurante');
            $table->string('nombre',length:80);
            $table->string('direccion',length:80);
            $table->string('nit',length:80);
            $table->timestamps();
        });

        Schema::create('Usuario', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('nombre',length:80);
            $table->string('apellidos',length:80);
            $table->string('ci',length:30)->unique();
            $table->string('usuario',length:80)->unique();
            $table->string('contrasena',length:255);
            $table->enum('rol', ['administrador', 'personal']);
            $table->timestamps();
        });
        Schema::create('Cliente', function (Blueprint $table) {
            $table->id('id_cliente');
            $table->string('nombre',length:80);
            $table->string('apellidos',length:80);
            $table->string('ci',length:30)->unique();
            $table->timestamps();
        });
        Schema::create('Promocion', function (Blueprint $table) {
            $table->id('id_promocion');
            $table->string('nombre',length:80);
            $table->decimal('descuento',total:8,places:2);
            $table->date('fecha');
            $table->string('foto',length:80);
            $table->enum('estado', ['activo', 'inactivo']);
            $table->timestamps();
        });

        Schema::create('Plato', function (Blueprint $table) {
            $table->id('id_producto');
            $table->string('nombre',length:80);
            $table->decimal('precio',total:8,places:2);
            $table->integer('stock')->default(0);
            $table->enum('estado', ['activo', 'inactivo']);
            $table->string('descripcion',length:255);
            $table->string('foto',length:80);
            $table->timestamps();
        });

        Schema::create('Pago', function (Blueprint $table) {
            $table->id('id_pago');
            $table->string('nombre',length:80);
            $table->timestamps();
        });


        Schema::create('Venta', function (Blueprint $table) {
            $table->id('id_venta');
            $table->date('fecha');
            $table->decimal('total',total:8,places:2);
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_pago');
            $table->unsignedBigInteger('id_promocion')->nullable();
            $table->enum('estado', ['pendiente', 'pagado']);
            $table->unsignedBigInteger('id_restaurante');
            $table->timestamps();

            $table->foreign('id_usuario')->references('id_usuario')->on('Usuario');
            $table->foreign('id_cliente')->references('id_cliente')->on('Cliente');
            $table->foreign('id_pago')->references('id_pago')->on('Pago');
            $table->foreign('id_promocion')->references('id_promocion')->on('Promocion');
            $table->foreign('id_restaurante')->references('id_restaurante')->on('Restaurante');
        });


        Schema::create('Detalle_venta', function (Blueprint $table) {
            $table->id('id_detalle');
            $table->integer('cantidad')->default(0);
            $table->unsignedBigInteger('id_plato');
            $table->unsignedBigInteger('id_venta');
            $table->timestamps();

            $table->foreign('id_venta')->references('id_venta')->on('Venta');
            $table->foreign('id_plato')->references('id_producto')->on('Plato');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
