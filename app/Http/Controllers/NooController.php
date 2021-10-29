<?php

namespace App\Http\Controllers;

use App\Exports\NooExport;
use App\Models\Noo;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class NooController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $noos = Noo::with(['badanusaha', 'cluster', 'region', 'divisi'])->latest()->filter()->paginate(10);
        return view('noo.index', [
            'noos' => $noos,
            'title' => 'NOO',
            'active' => 'noo',
        ]);
    }

    public function show(Request $request, $id)
    {
        $noo = Noo::findOrFail($id);
        return view('noo.edit', [
            'noo' => $noo,
            'title' => 'NOO',
            'active' => 'noo',
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $noo = Noo::findOrFail($id);
            if ($request->status == 'PENDING') {
                $noo['status'] = $request->status;
                $noo['confirmed_by'] = null;
                $noo['confirmed_at'] = null;
                $noo['rejected_at'] = null;
                $noo['rejected_by'] = null;
                $noo['limit'] = null;
            } else {
                $noo['status'] = $request->status;
                $noo['rejected_at'] = null;
                $noo['rejected_by'] = null;
            }
            $noo['keterangan'] = null;
            $noo->save();
            return redirect('noo')->with(['success' => 'berhasil edit status noo']);
        } catch (Exception $e) {
            return redirect('noo')->with(['error' => $e->getMessage()]);
        }
    }

    public function export()
    {
        return Excel::download(new NooExport, 'noo.xlsx');
    }
}
