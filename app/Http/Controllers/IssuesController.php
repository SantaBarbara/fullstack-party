<?php

namespace App\Http\Controllers;

use App\Http\Requests\Filters\IssueComments;
use App\Http\Requests\Filters\Issue;
use App\Traits\InteractsWithGitHub;

class IssuesController extends Controller
{
    use InteractsWithGitHub;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('issues.index');
    }

    /**
     * @param \App\Http\Requests\Filters\Issue $filter
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter(Issue $filter)
    {
        try {
            $issues = $this->issues($filter);
        } catch (\Exception $e) {
            $issues = [
                'total_count' => 0,
                'items' => []
            ];
        }

        return response()->json([
            'success' => true,
            'issues' => $issues,
        ]);
    }

    public function show($username, $repository, $issue_id, IssueComments $filter)
    {
        try {
            $issue = $this->issueWithComments(
                $username, $repository, (int) $issue_id, $filter
            );

             return view('issues.show', compact('issue'));
        } catch (\Exception $e) {
            abort(404);
        }
    }
}
