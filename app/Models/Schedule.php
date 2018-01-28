<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['date','event'];

    public function rules($id = null)
    {
        return [
            'event' => 'required | min:3',
            'date'  => 'required'
        ];
    }

    public function rulesSearch()
    {
        return[
            'key'   =>  'required'
        ];
    }
}
