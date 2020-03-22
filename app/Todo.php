<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    public $table = 'todos';
    public $fillable = ['purpose', 'category', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
