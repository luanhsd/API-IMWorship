<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Music;

class MusicController extends Controller
{
    private $music;
    private $pages = 10;

    public function __construct(Music $music)
    {
        $this->music = $music;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $musics = $this->music->get();
        return response()->json(['musics' , $musics]);
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
        $validate =validator($data, $this->music->rules());
        if($validate->fails())
            return response()->json(['validate' => $validate->messages()]);

        if(!$insert = $this->music->create($data))
            return response()->json(['error' => 'music not insert!', 500]);
            
        return response()->json(['music' => $insert]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(! $music = $this->music->find($id))
            return response()->json(['error' => 'music not found'] , 404);
        return response()->json(['music' => $music]);
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

        $validate =validator($data, $this->music->rules());
        if($validate->fails())
            return response()->json(['validate' => $validate->messages()]);

        if(!$music = $this->music->find($id))
            return response()->json(['error' => 'music not found'] , 404);

        if(!$update = $music->update($data))
            return response()->json(['error' => 'failed to update music'], 500);
        
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
        if(!$music = $this->music->find($id))
            return response()->json(['error' => 'music not found'] , 404);

        if(!$delete = $music->delete())
            return response()->json(['error' => 'failed to delete music'], 500);
        
        return response()->json(['delete' => $delete]);
    }

    public function search(Request $request)
    {
        $data = $request->all();

        $validate =validator($data, $this->music->rulesSearch());
        if($validate->fails())
            return response()->json(['validate' => $validate->messages()]);

        $musics = $this->music
                            ->where('name','LIKE',"%{$data['key']}%")
                            ->orWhere('author','LIKE',"%{$data['key']}%")
                            ->get();

        return response()->json(['result' => $musics]);
    }
}
