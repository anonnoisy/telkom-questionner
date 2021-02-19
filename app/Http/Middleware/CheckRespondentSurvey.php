<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckRespondentSurvey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $survey = DB::table('surveys')
            ->where('name', $request->survey)
            ->first();

        if (empty($survey)) {
            return redirect()->route('questioner.login');
        }

        if ($survey->is_private) {
            $group = DB::table('groups')
                ->where('name', $request->group)
                ->first();

            if (empty($group)) {
                return redirect()->route('questioner.login');
            }
        }

        $respondent = DB::table('respondents')
            ->where('nik', $request->nik)
            ->first();

        $response = DB::table('responses')
            ->where('respondent_id', $respondent->id)
            ->first();

        if (!empty($response->completed_at)) {
            return redirect()->route('questioner.sorry', [
                'survey' => $request->survey,
                'group' => $request->group,
            ]);
        }

        if (!empty($respondent)) {
            return $next($request);
        }

        return redirect()->route('questioner.login', [
            'survey' => $request->survey,
            'group' => $request->group,
        ]);
    }
}
