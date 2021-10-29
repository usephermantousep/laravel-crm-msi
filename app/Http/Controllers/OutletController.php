<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Outlet;
use App\Models\Region;
use App\Models\Cluster;
use App\Models\Division;
use App\Models\BadanUsaha;
use Illuminate\Http\Request;
use App\Exports\OutletExport;
use App\Exports\TemplateOutletExport;
use App\Imports\OutletImport;
use Maatwebsite\Excel\Facades\Excel;

class OutletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $outlets = Outlet::with(['badanusaha', 'cluster', 'region', 'divisi']);
        $users = User::with(['tm'])->get();

        return view('outlet.index', [
            'outlets' => $outlets->filter()->orderBy('kode_outlet')->paginate(10),
            'title' => 'Outlet',
            'users' => $users,
            'active' => 'outlet',
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $outlet = Outlet::find($id);
        return view('outlet.show', [
            'outlet' => $outlet,
            'title' => 'Detail'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $outlet = Outlet::findOrFail($id);
        $badanusahas = BadanUsaha::all();
        $divisis = Division::all();
        $regions = Region::all();
        $clusters = Cluster::all();
        return view('outlet.edit', [
            'title' => 'Outlet',
            'active' => 'outlet',
            'outlet' => $outlet,
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
            $outlet = Outlet::findOrFail($id);
            $request->validate([
                'kode_outlet' => ['required', 'string', 'max:255','unique:outlets,kode_outlet,'.$outlet->id],
                'nama_outlet' => ['required', 'string'],
                'alamat_outlet' => ['required', 'string'],
                'radius' => ['required'],
                'status_outlet' => ['required'],
                'limit' => ['required'],
                'badanusaha_id' => ['required'],
                'divisi_id' => ['required'],
                'region_id' => ['required'],
                'cluster_id' => ['required'],
            ]);
            $data = $request->all();
            $data['kode_outlet'] = strtoupper($request->kode_outlet);
            $data['nama_outlet'] = strtoupper($request->nama_outlet);
            $data['nama_pemilik_outlet'] = strtoupper($request->nama_pemilik_outlet);
            $data['alamat_outlet'] = strtoupper($request->alamat_outlet);
            $outlet->update($data);
            return redirect('outlet')->with(['success' => 'berhasil edit outlet']);
        } catch (Exception $e) {
            error_log($e);
            return redirect('outlet')->with(['error' => $e->getMessage()]);
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

    public function export()
    {
        return Excel::download(new OutletExport, 'outlet.xlsx');
    }

    public function import(Request $request)
    {
        $file = $request->file('file');
        $namaFile = $file->getClientOriginalName();
        $file->move('import',$namaFile);

        Excel::import(new OutletImport,public_path('/import/'.$namaFile));
        return redirect('outlet')->with(['success' => 'berhasil import outlet']);
    }

    public function template()
    {
        return Excel::download(new TemplateOutletExport, 'outlet_template.xlsx');
    }
}
