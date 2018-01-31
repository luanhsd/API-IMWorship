<?php

$this->group(['prefix' => 'v1'], function(){

    $this->resource('users', 'API\V1\UserController', ['except' => 
    [
        'create','edit'
    ]]);

    $this->get('userssearch', 'API\V1\UserController@search');

    $this->get('login', 'API\V1\UserController@login');

    $this->resource('schedules', 'API\V1\ScheduleController', ['except' => 
    [
        'create','edit'
    ]]);

    $this->get('schedulessearch', 'API\V1\ScheduleController@search');

    $this->resource('musics', 'API\V1\MusicController', ['except' => 
    [
        'create','edit'
    ]]);

    $this->get('musicssearch', 'API\V1\MusicController@search');

    $this->resource('team', 'API\V1\ScheduleTeamController', ['except' => 
    [
        'create','edit'
    ]]);

    $this->get('teamlist', 'API\V1\ScheduleTeamController@list');

    $this->resource('listmusics', 'API\V1\ScheduleMusicController', ['except' => 
    [
        'create','edit'
    ]]);

    $this->get('listmusicslist', 'API\V1\ScheduleMusicController@list');

});

