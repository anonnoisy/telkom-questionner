<?php

namespace App\Http\Controllers;

use App\Imports\RespondentImport;
use App\Models\Group;
use App\Models\Respondent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $groups = Group::orderBy('name', 'asc')
            ->filter($request->only('search'))
            ->paginate();

        return Inertia::render('Group/Index', [
            'filters' => $request->all('search'),
            'groups' => Group::orderBy('name', 'asc')
                ->with('respondents')
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
        return Inertia::render('Group/Create', [
            'respondents' => Respondent::orderBy('name', 'asc')
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
        $group = Group::create([
            'name' => $request->name,
            'description' => $request->description ?? NULL,
        ]);

        $import = Excel::import(new RespondentImport($group), request()->file('members'));
        Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'respondents' => 'required|array',
            'members' => 'nullable|mimes:xls,xlsx',
        ])->validate();

        return redirect()
            ->back()
            ->with('message', 'Successfully created group.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Inertia::render('Group/Show', [
            'respondent' => Group::where('id', $id)
                ->with('respondents')
                ->first(),
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
        return Inertia::render('Group/Edit', [
            'group' => Group::where('id', $id)
                ->with('respondents')
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
        Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'nullable|string',
        ])->validate();

        $group = Group::find($id);
        $group->update([
            'name' => $request->name,
            'description' => $request->description ?? NULL,
        ]);

        if ($request->file('membersFile')) {
            $import = Excel::import(new RespondentImport($group), request()->file('members'));
        }

        return redirect()
            ->back()
            ->with('message', 'Successfully updated group.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = Group::find($id);
        $group->respondents()->detach();
        $group->delete();

        return redirect()
            ->back()
            ->with('message', 'Successfully deleted group.');
    }
}
