<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ScheduleTeam;

class ScheduleTeamController extends Controller
{
    private $scheduleTeam;

    public function __construct(ScheduleTeam $scheduleTeam)
    {
        $this->scheduleTeam = $scheduleTeam;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $scheduleTeams = $this->scheduleTeam->get();
        return response()->json(['teams' => $scheduleTeams]);
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
        $validate =validator($data, $this->scheduleTeam->rules());
        if($validate->fails())
            return response()->json(['validate' => $validate->messages()]);

        if(!$insert = $this->scheduleTeam->create($data))
            return response()->json(['error' => 'scheduleTeam not insert!', 500]);
            
        return response()->json(['scheduleTeam' => $insert]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(! $scheduleTeam = $this->scheduleTeam->find($id))
            return response()->json(['error' => 'scheduleteam not found'] , 404);
        return response()->json(['scheduleteam' => $scheduleTeam]);
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

        $validate =validator($data, $this->scheduleTeam->rules());
        if($validate->fails())
            return response()->json(['validate' => $validate->messages()]);

        if(!$scheduleTeam = $this->scheduleTeam->find($id))
            return response()->json(['error' => 'scheduleTeam not found'] , 404);

        if(!$update = $scheduleTeam->update($data))
            return response()->json(['error' => 'failed to update scheduleTeam'], 500);
        
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
        if(!$scheduleTeam = $this->scheduleTeam->find($id))
            return response()->json(['error' => 'scheduleTeam not found'] , 404);

        if(!$delete = $scheduleTeam->delete())
            return response()->json(['error' => 'failed to delete scheduleTeam'], 500);
        
        return response()->json(['delete' => $delete]);
    }

    public function list(Request $request)
    {
        $data = $request->all();

        $validate =validator($data, $this->scheduleTeam->rulesSearch());
        if($validate->fails())
            return response()->json(['validate' => $validate->messages()]);

        $list = $this->scheduleTeam
                            ->join('schedules','schedules.id','=','schedule_id')
                            ->join('users','users.id','=','team_id')
                            ->select('users.*')
                            ->where('schedule_id',$data['key'])
                            ->get();

        return response()->json(['result' => $list]);
    }
}
