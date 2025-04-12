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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Título de la propiedad
            $table->string('slug')->unique(); // Slug único
            $table->string('reference_id')->unique(); // Referencia interna / ID
            $table->foreignId('property_type_id')->constrained('property_types'); // Tipo de propiedad
            $table->foreignId('operation_id')->constrained('operations'); // Operación
            $table->foreignId('property_status_id')->nullable()->constrained('property_statuses'); // Estado del inmueble
            $table->string('address'); // Dirección
            $table->string('locality'); // Localidad
            $table->string('postal_code'); // Código postal
            $table->foreignId('province_id')->constrained('provinces'); // Provincia
            $table->decimal('latitude', 10, 7)->nullable(); // Coordenadas (latitud)
            $table->decimal('longitude', 10, 7)->nullable(); // Coordenadas (longitud)
            $table->foreignId('zone_id')->nullable()->constrained('zones'); // Zona / Barrio / Urbanización
            $table->float('constructed_area')->nullable(); // Superficie construida (m²)
            $table->float('usable_area')->nullable(); // Superficie útil (m²)
            $table->float('land_area')->nullable(); // Superficie del terreno / parcela (m²)
            $table->integer('rooms')->nullable(); // Nº de habitaciones
            $table->integer('bathrooms')->nullable(); // Nº de baños
            $table->integer('floors')->nullable(); // Nº de plantas
            $table->year('construction_year')->nullable(); // Año de construcción
            $table->string('housing_type')->nullable(); // Tipo de vivienda
            $table->boolean('living_room')->default(false); // Salón / comedor
            $table->boolean('equipped_kitchen')->default(false); // Cocina equipada
            $table->boolean('terrace')->default(false); // Terraza / porche
            $table->boolean('garden')->default(false); // Jardín
            $table->boolean('pool')->default(false); // Piscina
            $table->boolean('storage_room')->default(false); // Trastero
            $table->boolean('garage')->default(false); // Garaje / parking
            $table->string('orientation')->nullable(); // Orientación
            $table->string('views')->nullable(); // Vistas
            $table->boolean('air_conditioning')->default(false); // Aire acondicionado
            $table->boolean('fireplace')->default(false); // Chimenea / estufa
            $table->boolean('heating')->default(false); // Calefacción
            $table->boolean('drinking_water')->default(false); // Agua potable
            $table->boolean('electricity')->default(false); // Electricidad
            $table->boolean('internet')->default(false); // Internet / fibra
            $table->boolean('well')->default(false); // Pozo / agua de riego
            $table->boolean('solar_panels')->default(false); // Paneles solares
            $table->boolean('security_system')->default(false); // Sistema de seguridad
            $table->boolean('accessible')->default(false); // Acceso adaptado / movilidad reducida
            $table->string('land_type')->nullable(); // Tipo de terreno
            $table->string('current_crops')->nullable(); // Cultivos actuales o posibles
            $table->boolean('own_well')->default(false); // Pozo propio / derecho de agua
            $table->boolean('agricultural_facilities')->default(false); // Almacenes / naves / instalaciones agrarias
            $table->boolean('fenced')->default(false); // Vallado
            $table->boolean('road_access')->default(false); // Acceso por carretera / pista
            $table->string('topography')->nullable(); // Topografía
            $table->decimal('price', 15, 2); // Precio de venta / alquiler
            $table->decimal('commission', 15, 2)->nullable(); // Comisión (si aplica)
            $table->decimal('community_fees', 15, 2)->nullable(); // Gastos de comunidad (si aplica)
            $table->decimal('ibi', 15, 2)->nullable(); // IBI anual
            $table->decimal('estimated_profitability', 15, 2)->nullable(); // Rentabilidad estimada (opcional)
            $table->text('short_description')->nullable(); // Descripción corta
            $table->longText('long_description')->nullable(); // Descripción larga
            $table->text('internal_notes')->nullable(); // Notas internas (solo para uso interno)
            $table->json('gallery')->nullable(); // Galería de fotos
            $table->string('video')->nullable(); // Vídeo
            $table->string('virtual_tour')->nullable(); // Tour virtual / 360º
            $table->string('blueprint')->nullable(); // Plano
            $table->string('brochure')->nullable(); // Brochure PDF (si aplica)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
