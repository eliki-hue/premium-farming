<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
        protected $fillable = ['name', 'location'];

    public function stockMovements() { return $this->hasMany(StockMovement::class); }
public function up()
{
    Schema::create('stores', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('location')->nullable();
        $table->timestamps();
    });
}
//

}
