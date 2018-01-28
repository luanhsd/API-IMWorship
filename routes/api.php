<?php

$this->group(['prefix' => 'v1'], function(){

    $this->resource('users', 'API\V1\UserController', ['except' => 
    [
        'create','edit'
    ]]);

    $this->get('users/search', 'API\V1\UserController@search');

    $this->resource('schedules', 'API\V1\ScheduleController', ['except' => 
    [
        'create','edit'
    ]]);

    $this->get('schedules/search', 'API\V1\ScheduleController@search');

    $this->resource('musics', 'API\V1\MusicController', ['except' => 
    [
        'create','edit'
    ]]);

    $this->get('musics/search', 'API\V1\MusicController@search');

    $this->resource('team', 'API\V1\ScheduleTeamController', ['except' => 
    [
        'create','edit'
    ]]);

    $this->get('team/list', 'API\V1\ScheduleTeamController@list');

    $this->resource('listmusics', 'API\V1\ScheduleMusicController', ['except' => 
    [
        'create','edit'
    ]]);

    $this->get('listmusics/list', 'API\V1\ScheduleMusicController@list');

});

