<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class SchoolSelectorController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $school = School::findOrFail($request->school_selector);
        return $this->save($school);
    }

    protected function save(School $school)
    {
        $key = "school_selector_id";
        session([$key => $school->getKey()]);
        return session($key);
    }
}
