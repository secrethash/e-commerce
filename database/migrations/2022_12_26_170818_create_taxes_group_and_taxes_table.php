<?php

use App\Models\TaxGroup;
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
        Schema::create('tax_groups', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_default')->default(0);
            $table->boolean('is_active')->default(0);
            $table->timestamps();
        });

        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TaxGroup::class)->nullable()->constrained();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('short_name');
            $table->text('description')->nullable();
            $table->string('calculation_type')->default('simple');
            $table->bigInteger('rate');
            $table->boolean('is_active')->default(0);
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
        Schema::dropIfExists('taxes');
        Schema::dropIfExists('tax_groups');
    }
};
