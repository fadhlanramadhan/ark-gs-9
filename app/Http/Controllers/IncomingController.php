<?php

namespace App\Http\Controllers;

use App\Exports\IncomingExport;
use App\Exports\IncomingExportThisYear;
use App\Imports\IncomingImport;
use App\Models\Incoming;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class IncomingController extends Controller
{
    public function index()
    {
        return view('incoming.index');
    }

    public function index_this_year()
    {
        return view('incoming.index_this_year');
    }

    public function show($id)
    {
        $incoming = Incoming::findOrFail($id);

        return view('incoming.show', compact('incoming'));
    }

    public function truncate()
    {
        Incoming::truncate();

        return redirect()->route('incoming.index')->with('success', 'Table has been truncated.');
    }

    public function import_excel(Request $request)
    {
        // validasi
        $this->validate($request, [
            'file_upload' => 'required|mimes:xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file_upload');

        // membuat nama file unik
        $nama_file = rand().$file->getClientOriginalName();

        // upload ke folder file_upload
        $file->move('file_upload', $nama_file);

        // import data
        Excel::import(new IncomingImport, public_path('/file_upload/'.$nama_file));

        // alihkan halaman kembali
        return redirect()->route('incoming.index')->with('status', 'Data Excel Berhasil Diimport!');
    }

    public function export_this_month()
    {
        return Excel::download(new IncomingExport(), 'incoming_this_month.xlsx');
    }

    public function export_this_year()
    {
        return Excel::download(new IncomingExportThisYear(), 'incoming_this_year.xlsx');
    }

    public function data()
    {
        $list = Incoming::whereMonth('posting_date', Carbon::now())
                ->get();

        return datatables()->of($list)
                ->editColumn('posting_date', function ($list) {
                    return date('d-m-Y', strtotime($list->posting_date));
                })
                ->addIndexColumn()
                ->toJson();
    }

    public function data_this_year()
    {
        $list = Incoming::orderby('posting_date')->get();

        return datatables()->of($list)
                ->editColumn('posting_date', function ($list) {
                    return date('d-m-Y', strtotime($list->posting_date));
                })
                ->addIndexColumn()
                ->toJson();
    }
}