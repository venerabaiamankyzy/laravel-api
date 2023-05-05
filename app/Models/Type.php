<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = ['label', 'color'];

    //! Relations

    public function projects() {
        return $this->hasMany(Project::class);
    }

    //! HTML
    
    public function getBadgeHTML() {
        return '<span class="badge" style="background-color:' . $this->color . '">' . $this->label . '</span>';
    }
    
}