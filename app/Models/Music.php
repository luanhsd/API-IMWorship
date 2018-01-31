<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    protected $fillable = ['name','author'];

    protected $hidden = [
        'created_at', 'updated_at',
    ];
    
    public function rules()
    {
        return [
            'name'      => 'required',
            'author'    => 'required'
        ];
    }

    public function rulesSearch()
    {
        return [
            'key' => 'required'
        ];
    }
}
