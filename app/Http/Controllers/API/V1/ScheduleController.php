<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    private $schedule;

    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = $this->schedule->all();
        return response()->json(['schedules' => $schedules]);
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
        $validate =validator($data, $this->schedule->rules());
        if($validate->fails())
            return response()->json(['validate' => $validate->messages()]);

        if(!$insert = $this->schedule->create($data))
            return response()->json(['error' => 'schedule not insert!', 500]);
            
        return response()->json(['schedule' => $insert]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(! $schedule = $this->schedule->find($id))
            return response()->json(['error' => 'schedule not found'] , 404);
        return response()->json(['schedule' => $schedule]);
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

        $validate =validator($data, $this->schedule->rules());
        if($validate->fails())
            return response()->json(['validate' => $validate->messages()]);

        if(!$schedule = $this->schedule->find($id))
            return response()->json(['error' => 'schedule not found'] , 404);

        if(!$update = $schedule->update($data))
            return response()->json(['error' => 'failed to update schedule'], 500);
        
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
        if(!$schedule = $this->schedule->find($id))
            return response()->json(['error' => 'schedule not found'] , 404);

        if(!$delete = $schedule->delete())
            return response()->json(['error' => 'failed to delete schedule'], 500);
        
        return response()->json(['delete' => $delete]);
    }

    public function search(Request $request)
    {
        $data = $request->all();

        $validate =validator($data, $this->schedule->rulesSearch());
        if($validate->fails())
            return response()->json(['validate' => $validate->messages()]);

        $schedule = $this->schedule
                            ->where('date','LIKE',"%{$data['key']}%")
                            ->orWhere('event','LIKE',"%{$data['key']}%")
                            ->get();

        return response()->json(['result' => $schedule]);
    }
}
