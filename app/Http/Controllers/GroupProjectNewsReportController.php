<?php

namespace App\Http\Controllers;

use App\GroupProject;
use App\GroupProjectNewsReport;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GroupProjectNewsReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function storeNews(Request $request, $id)
    {
        $groupProject = GroupProject::findOrFail($id);
        if ($request->hasFile('berita')) {
            $fileBerita = $request->file('berita');
            $folderBerita = 'berkas/berita';
            $fileNameBerita = Carbon::now()->timestamp . '_' . uniqId() . 'BeritaAcara';
            $fileBerita->move($folderBerita, $fileNameBerita);
        }
        $groupProject->report = $fileNameBerita;

        if ($groupProject->save()) {
            return response()->json('success');
        }
        return response()->json('failed');
    }
    public function store(Request $request, $id)
    {
        $groupProject = GroupProject::findOrFail($id);
        if ($request->hasFile('berita')) {
            $fileRevisi = $request->file('berita');
            $folderRevisi = 'berkas/revisi';
            $fileNameRevisi = Carbon::now()->timestamp . '_' . uniqId() . '_CatatanRevisi';
            $fileRevisi->move($folderRevisi, $fileNameRevisi);
        }
        $groupProject->revisi = $fileNameRevisi;

        if ($groupProject->save()) {
            return response()->json('success');
        }
        return response()->json('failed');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GroupProjectNewsReport  $groupProjectNewsReport
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        $groupProject = GroupProject::findOrFail($id);
        return response()->json(['data' => $groupProject]);
    }

    public function getNews($id)
    {
        $groupProject = GroupProject::findOrFail($id);
        return response()->json(['data' => $groupProject]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GroupProjectNewsReport  $groupProjectNewsReport
     * @return \Illuminate\Http\Response
     */
    public function edit(GroupProjectNewsReport $groupProjectNewsReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GroupProjectNewsReport  $groupProjectNewsReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GroupProjectNewsReport $groupProjectNewsReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GroupProjectNewsReport  $groupProjectNewsReport
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $groupProject = GroupProject::with('InternshipStudents')->find($id);
        $groupProject->increment('is_verified');
        foreach ($groupProject->InternshipStudents as $i) {
            $i->status = "L";
            $i->update();
        }
    }
}
