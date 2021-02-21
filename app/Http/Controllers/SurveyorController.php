<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Respondent;
use App\Models\Response;
use App\Models\Survey;
use App\Models\SurveyResponse;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class SurveyorController extends Controller
{
    public function loginView(Request $request)
    {
        return Inertia::render('Questioner/Login', [
                'survey_name' => $request->survey ?? null,
                'group_name' => $request->group ?? null,
                'create_url' => URL::route('questioner.register', [
                    'survey' => $request->survey ?? null,
                    'group' => $request->group ?? null,
                ]),
            ]
        );
    }

    public function registerView(Request $request)
    {
        return Inertia::render('Questioner/Register', [
                'survey_name' => $request->survey,
                'group_name' => $request->group,
                'units' => Unit::all(),
                'create_url' => URL::route('questioner.login', [
                    'survey' => $request->survey ?? null,
                    'group' => $request->group ?? null,
                ]),
            ]
        );
    }

    public function login(Request $request)
    {
        Validator::make($request->all(), [
            'nik' => ['required'],
        ])->validate();

        $respondent = Respondent::where('nik', $request->nik)
            ->first();

        if (empty($respondent)) {
            return redirect()
                ->back()
                ->with('message', 'You are not in the survey, maybe you need to register first');
        }

        $response = DB::table('responses')
            ->where('respondent_id', $respondent->id)
            ->first();

        if (!empty($response->completed_at)) {
            return redirect()->route('questioner.sorry', [
                'survey' => $request->survey,
                'group' => $request->group,
            ]);
        }

        $survey = Survey::where('name', $request->survey_name)
            ->first();

        Response::create([
            'survey_id' => $survey->id,
            'respondent_id' => $respondent->id,
            'started_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('questioner.ongoing', [
            'survey' => $request->survey_name,
            'group' => $request->group_name,
            'nik' => $request->nik
        ]);
    }

    public function register(Request $request)
    {
        $group = Group::where('name', $request->group_name)->first();
        if (empty($group)) {
            return redirect()
                ->back()
                ->with('message', 'Please check your questioner link!');
        }

        Validator::make($request->all(), [
            'nik' => 'required|integer',
        ])->validate();

        $respondent = Respondent::where('nik', $request->nik)->first();
        if (!empty($respondent)) {
            return redirect()
                ->back()
                ->with('message', 'you have registered as a participant, please login below.');
        }

        $respondent = Respondent::create([
            'name' => $request->name ?? NULL,
            'nik' => $request->nik,
            'objid_posisi' => $request->objid_posisi ?? NULL,
            'jabatan' => $request->jabatan ?? NULL,
            'band' => $request->band ?? NULL,
            'lokasi_kerja_id' => $request->lokasi_kerja_id ?? NULL,
            'sub_unit_id' => $request->sub_unit_id ?? NULL,
            'unit_id' => $request->unit_id ?? NULL,
        ]);

        $group->respondents()->attach($respondent->id);

        return redirect()->route('questioner.start', [
            'survey' => $request->survey_name,
            'group' => $request->group_name,
            'nik' => $request->nik
        ]);
    }

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

    public function startQuestioner(Request $request)
    {
        $respondent = Respondent::where('nik', $request->nik)
            ->first();

        return Inertia::render('Questioner/Questioner', [
                'survey_name' => $request->survey,
                'group_name' => $request->group,
                'respondent' => $respondent,
                'survey' => Survey::where('name', $request->survey)
                    ->with([
                        'responses' => function ($query) use ($respondent) {
                            $query->where("respondent_id", "=", $respondent->id);
                        },
                        'questions.question_choices',
                        'questions.question_types'
                    ])->first(),
            ]);
    }

    public function finishQuestioner(Request $request)
    {
        foreach ($request->questions as $question) {
            SurveyResponse::create([
                'response_id' => $request->response_id,
                'respondent_id' => $request->respondent_id,
                'question_id' => $question['question_id'],
                'answer' => $question['answer']
            ]);
        }

        Response::find($request->response_id)->update([
            'completed_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->route('questioner.thanks', [
            'survey' => $request->survey_name,
            'group' => $request->group_name,
        ]);
    }

    public function thankYou(Request $request)
    {
        return Inertia::render('Questioner/ThankYou', [
            'survey_name' => $request->survey,
            'group_name' => $request->group,
        ]);
    }

    public function sorry(Request $request)
    {
        return Inertia::render('Questioner/Sorry', [
            'survey_name' => $request->survey,
            'group_name' => $request->group,
        ]);
    }
}
