<?php

namespace App\Models;

use GuzzleHttp\Handler\Proxy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Psy\TabCompletion\Matcher\FunctionsMatcher;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['type_id', 'title', 'image', 'text', 'link', 'is_published' ];
    
     //! Relations

    public function type() {
        return $this->belongsTo(Type::class);
    }


     //! # Mutators - formattazione date
     protected function getUpdatedAtAttribute($value) {
        return date('d/m/Y H:i', strtotime($value));
    }

    protected function getCreatedAtAttribute($value) {
        return date('d/m/Y H:i', strtotime($value));
    }

    // protected function getCreatedAtAttribute($value) {
    //     return date('d/m/Y H:i:s', strtotime($value));
    // }

    //! Getter
    public function getAbstract($max = 50) {
        return substr($this->text, 0, $max). "...";
    }

    public function getTitle($max = 50) {
        return substr($this->title, 0, $max). "...";
    }

    //!  Unique slug generation

    public static function generateSlug($title) {

        $possible_slug = Str::of($title)->slug('-');
        
         //controllare che lo slug sia unico e, se non lo è, rigenerarlo finché non lo si trova
        $projects = Project::where('slug', $possible_slug)->get();
        
        $original_slug = $possible_slug;
        $i = 2;

        while(count($projects)) {
            $possible_slug = $original_slug . "-" . $i;
            $projects = Project::where('slug', $possible_slug)->get();
            $i++;
        }
        
        return $possible_slug;
    }
    
   
    
    public function getImageUri() {
        return $this->image ? asset('storage/' . $this->image) : 'https://www.frosinonecalcio.com/wp-content/uploads/2021/09/default-placeholder.png';
    }
} 
    