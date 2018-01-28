<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleMusic extends Model
{
    protected $fillable = ['schedule_id','music_id'];

    public function rules()
    {
        return [
            'schedule_id'   => 'required | exists:schedules,id',
            'music_id'      => 'required | exists:musics,id'
        ];
    }

    public function rulesSearch()
    {
        return [
            'key'   =>  'required'
        ];
    }
}
