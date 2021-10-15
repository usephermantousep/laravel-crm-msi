<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Role;
use App\Models\User;
use App\Models\Region;
use App\Models\Cluster;
use App\Models\Division;
use App\Models\BadanUsaha;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with(['role', 'region', 'cluster', 'divisi', 'badanusaha'])->filter()->get()->sortBy('nama_lengkap');
        $roles = Role::all();
        $badanusahas = BadanUsaha::all();
        $divisis = Division::all();
        $regions = Region::all();
        $clusters = Cluster::all();
        return view('user.index', [
            'users' => $users,
            'title' => 'User',
            'active' => 'user',
            'roles' => $roles,
            'badanusahas' => $badanusahas,
            'divisis' => $divisis,
            'regions' => $regions,
            'clusters' => $clusters,
        ]);
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
        $validatedata = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:255', 'unique:users,username'],
            'nama_lengkap' => ['required', 'string'],
            'role_id' => ['required'],
            'badanusaha_id' => ['required'],
            'divisi_id' => ['required'],
            'region_id' => ['required'],
            'cluster_id' => ['required'],
            'password' => ['required']
        ]);

        if (!$validatedata) {
            return redirect('user')->with(['error' => 'gagal menambahkan !']);
        }
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['nama_lengkap'] = strtoupper($request->nama_lengkap);
        User::create($data);
        return redirect('user')->with(['success' => 'berhasil menambahkan user']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        $badanusahas = BadanUsaha::all();
        $divisis = Division::all();
        $regions = Region::all();
        $clusters = Cluster::all();
        return view('user.edit', [
            'user' => $user,
            'title' => 'User',
            'active' => 'user',
            'roles' => $roles,
            'badanusahas' => $badanusahas,
            'divisis' => $divisis,
            'regions' => $regions,
            'clusters' => $clusters,
        ]);
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
        try {
            $user = User::findOrFail($id);
            $request->validate([
                'username' => ['required', 'string', 'max:255','unique:users,username,'.$user->id],
                'nama_lengkap' => ['required', 'string'],
                'role_id' => ['required'],
                'badanusaha_id' => ['required'],
                'divisi_id' => ['required'],
                'region_id' => ['required'],
                'cluster_id' => ['required'],
                'password' => ['required'],
            ]);
            $data = $request->all();
            $data['password'] = bcrypt($request->password);
            $data['nama_lengkap'] = strtoupper($request->nama_lengkap);

            $user->update($data);
            return redirect('user')->with(['success' => 'berhasil edit user']);
        } catch (Exception $e) {
            error_log($e);
            return redirect('user')->with(['error' => $e->getMessage()]);
        }
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
}
