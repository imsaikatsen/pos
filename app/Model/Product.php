<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function supplier(){
    	return $this->hasOne(Supplier::class,'id','supplier_id');
    }

     public function unit(){
    	return $this->hasOne(Unit::class,'id','unit_id');
    }

     public function category(){
    	return $this->hasOne(Category::class,'id','category_id');  
    }
}
