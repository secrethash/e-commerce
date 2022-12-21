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
        Schema::table('carrier_pricing', function (Blueprint $table) {
            $table->bigInteger('maximum_order')
                ->nullable()
                ->after('calculable_type');
            $table->bigInteger('minimum_order')
                ->nullable()
                ->after('calculable_type');
            $table->string('method')
                ->default('flat')
                ->nullable()
                ->after('calculable_type');
            $table->string('calculable_value')
                ->nullable()
                ->after('calculable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carrier_pricing', function (Blueprint $table) {
            $table->dropColumn([
                'maximum_order',
                'minimum_order',
                'method',
                'calculable_value',
            ]);
        });
    }
};
