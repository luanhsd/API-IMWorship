<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->get();

        return response()->json($users);
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
        $validate =validator($data, $this->user->rules());
        if($validate->fails())
            return response()->json(['validate' => $validate->messages()]);

        if(!$insert = $this->user->create($data))
            return response()->json(['error' => 'user not insert!', 500]);
            
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(! $user = $this->user->find($id))
            return response()->json(['error' => 'user not found'] , 404);
        return response()->json($user);
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

        $validate =validator($data, $this->user->rules($id));
        if($validate->fails())
            return response()->json(['validate' => $validate->messages()]);

        if(!$user = $this->user->find($id))
            return response()->json(['error' => 'user not found'] , 404);

        if(!$update = $user->update($data))
            return response()->json(['error' => 'failed to update user'], 500);
        
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request)
    {
        $data = $request->all();

        $validate =validator($data, $this->user->rulesSearch());
        if($validate->fails())
            return response()->json(['validate' => $validate->messages()]);

        $users = $this->user
                            ->where('name','LIKE',"%{$data['key']}%")
                            ->orWhere('username','LIKE',"%{$data['key']}%")
                            ->orWhere('email','LIKE',"%{$data['key']}%")
                            ->get();

        return response()->json($users);
    }

    public function login(Request $request)
    {
        $data = $request->all();
        $validate =validator($data, $this->user->rulesLogin());
        if($validate->fails())
            return response()->json(['validate' => $validate->messages()]);

        $users = $this->user
                            ->where('username',$data['username'])
                            ->where('password',$data['password'])
                            ->get();

        return response()->json($users);
    }
}
