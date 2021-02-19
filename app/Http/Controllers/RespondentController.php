<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Respondent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class RespondentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Respondent/Index', [
            'filters' => $request->all('search'),
            'respondents' => Respondent::orderBy('name', 'asc')
                ->filter($request->only('search'))
                ->paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Respondent/Create', [
            'groups' => Group::orderBy('name', 'asc')
                ->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'nullable|string',
            'nik' => 'required|integer',
            'groups' => 'nullable|array',
        ])->validate();

        $respondent = Respondent::create([
            'name' => $request->name ?? NULL,
            'nik' => $request->nik,
            'objid_posisi' => $request->objid_posisi ?? NULL,
            'jabatan' => $request->jabatan ?? NULL,
            'band' => $request->band ?? NULL,
            'lokasi_kerja' => $request->lokasi_kerja ?? NULL,
            'sub_unit' => $request->sub_unit ?? NULL,
            'unit' => $request->unit ?? NULL,
        ]);
        $respondent->groups()->attach($request->groups);

        return redirect()
            ->back()
            ->with('message', 'Successfully added new respondent.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Inertia::render('Respondent/Edit', [
            'respondents' => Respondent::where('id', $id)
                ->with('groups')
                ->get(),
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
        return Inertia::render('Respondent/Edit', [
            'groups' => Group::orderBy('name', 'asc')->get(),
            'respondent' => Respondent::where('id', $id)
                ->with('groups')
                ->first(),
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
        //
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
