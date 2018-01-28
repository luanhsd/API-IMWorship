<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ScheduleMusic;

class ScheduleMusicController extends Controller
{
    private $scheduleMusic;

    public function __construct(ScheduleMusic $scheduleMusic)
    {
        $this->scheduleMusic = $scheduleMusic;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $scheduleMusics = $this->scheduleMusic->get();
        return response()->json(['schedulemusics' => $scheduleMusics]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validate =validator($data, $this->scheduleMusic->rules());
        if($validate->fails())
            return response()->json(['validate' => $validate->messages()]);

        if(!$insert = $this->scheduleMusic->create($data))
            return response()->json(['error' => 'scheduleMusic not insert!', 500]);
            
        return response()->json(['scheduleMusic' => $insert]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(! $scheduleMusic = $this->scheduleMusic->find($id))
            return response()->json(['error' => 'schedulemusic not found'] , 404);
        return response()->json(['schedulemusic' => $scheduleMusic]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $validate =validator($data, $this->scheduleMusic->rules());
        if($validate->fails())
            return response()->json(['validate' => $validate->messages()]);

        if(!$scheduleMusic = $this->scheduleMusic->find($id))
            return response()->json(['error' => 'scheduleMusic not found'] , 404);

        if(!$update = $scheduleMusic->update($data))
            return response()->json(['error' => 'failed to update scheduleMusic'], 500);
        
        return response()->json(['update' => $update]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!$scheduleMusic = $this->scheduleMusic->find($id))
            return response()->json(['error' => 'scheduleMusic not found'] , 404);

        if(!$delete = $scheduleMusic->delete())
            return response()->json(['error' => 'failed to delete scheduleMusic'], 500);
        
        return response()->json(['delete' => $delete]);
    }

    public function list(Request $request)
    {
        $data = $request->all();

        $validate =validator($data, $this->scheduleMusic->rulesSearch());
        if($validate->fails())
            return response()->json(['validate' => $validate->messages()]);

        $list = $this->scheduleMusic
                            ->join('schedules','schedules.id','=','schedule_id')
                            ->join('musics','musics.id','=','music_id')
                            ->select('musics.*')
                            ->where('schedule_id',$data['key'])
                            ->get();

        return response()->json(['result' => $list]);
    }
}
