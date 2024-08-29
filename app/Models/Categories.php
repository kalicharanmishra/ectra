<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class Categories extends Model

{

    use HasFactory;





    protected $table = 'categories';



    protected $fillable =

    [

        'title',

        'parent',

        'icon',

        'description',

        'status'

    ];

    public function parent_cat_data(){

        return $this->hasOne(Categories::class, 'id','parent');

    }

    public function courses(){

        return $this->hasMany(Course::class, 'category','id');

    }

    public function childcat(){

        return $this->hasMany(Categories::class, 'parent','id')->with('childcat')->orderBy('indexing', 'ASC');

    }

}