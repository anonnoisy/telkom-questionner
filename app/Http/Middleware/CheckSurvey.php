<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckSurvey
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
        $survey = DB::table('surveys')->where('name', $request->survey)->first();
        if (empty($survey)) {
            echo "Please make it sure your link is valid.";
            return false;
        }

        $group = DB::table('groups')->where('name', $request->group)->first();
        if (empty($group)) {
            echo "Please make it sure your link is valid.";
            return false;
        }

        return $next($request);
    }
}
