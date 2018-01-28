<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleTeam extends Model
{
    protected $fillable = ['schedule_id','team_id'];

    public function rules()
    {
        return [
            'schedule_id'   => 'required | exists:schedules,id',
            'team_id'      => 'required | exists:users,id'
        ];
    }

    public function rulesSearch()
    {
        return [
            'key'   =>  'required'
        ];
    }

}
