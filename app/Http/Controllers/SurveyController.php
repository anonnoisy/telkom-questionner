<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Question;
use App\Models\QuestionType;
use App\Models\ResponseChoice;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Inertia::render('Survey/Index', [
                'filters' => $request->all('search'),
                'surveys' => Survey::orderBy('created_at', 'desc')
                    ->filter($request->only('search'))
                    ->paginate(),
            ]
        );
    }

    /**
     * Show the form for create new survey.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Survey/Create', [
                'groups' => Group::orderBy('name', 'asc')->get(),
            ]
        );
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
            'name' => ['required'],
            'is_private' => ['required', 'boolean'],
            'group_id' => ['nullable'],
            'questions' => ['required', 'array'],
        ])->validate();

        $survey = Survey::create([
            'name' => $request->name,
            'description' => null,
            'is_private' => $request->is_private,
            'group_id' => $request->is_private ? $request->group_id : NULL,
            'opening_time' => null,
            'closing_time' => null,
        ]);

        foreach ($request->questions as $questionReq) {
            $question = Question::create([
                'survey_id' => $survey->id,
                'question' => $questionReq['question']
            ]);

            QuestionType::create([
                'question_id' => $question->id,
                'type' => $questionReq['type']
            ]);

            if ($questionReq['type'] == 'C' && count($questionReq['choices']) > 0) {
                foreach ($questionReq['choices'] as $responseChoice) {
                    ResponseChoice::create([
                        'question_id' => $question->id,
                        'alpha_choice' => $responseChoice['alpha_choice'],
                        'choice' => $responseChoice['choice']
                    ]);
                }
            }
        }

        return redirect()
            ->back()
            ->with('message', 'Survey Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $survey = Survey::where('id', $id)->with([
            'group.respondents.unit',
            'group.respondents.responses'
        ])->first();

        return Inertia::render('Survey/Show', [
            'survey' => $survey,
            'responses' => $survey->responses,
            'group' => $survey->group,
            'respondents' => $survey->group->respondents->groupBy('unit_name'),
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
        return Inertia::render('Survey/Edit', [
            'survey' => Survey::where('id', $id)
                ->with('questions')
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
