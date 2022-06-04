<?php

namespace App\Http\Controllers;

use App\Center;
use App\User;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($term = null)
    {
        if ($term != null) {
            $centers = Center::where('name', 'like', '%'.$term.'%')->with('user')->get();
            return response()->json($centers, 200);
        }

        return $this->_allRecord();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'user_id' => 'required',
        ]);

        Center::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
        ]);

        return $this->_allRecord();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Center  $centers
     * @return \Illuminate\Http\Response
     */
    public function show(Center $center)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Center  $centers
     * @return \Illuminate\Http\Response
     */
    public function edit(Center $center)
    {
        return response()->json($center, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Center  $centers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Center $center)
    {
        $request->validate([
            'name' => 'required|min:6',
        ]);

        $center->update([
            'name' => $request->name,
        ]);

        return $this->_allRecord();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Center  $centers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Center $center)
    {
        if ($center->delete()) {
            return $this->_allRecord();
        } else {
            return response()->json(425, ['delete' => 'Error deleting record']);
        }
    }  

    private function _allRecord()
    {
        $centers = Center::latest()->with('user')->paginate(5);
        return response()->json($centers, 200);
    }
    public function users()
    {
        $users = User::get();
        return response()->json($users);
    }
}
