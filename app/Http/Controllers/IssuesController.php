<?php

namespace App\Http\Controllers;

use App\Traits\InteractsWithGitHub;
use App\Http\Requests\Filters\Issue;
use App\Http\Requests\Filters\IssueComments;
use Illuminate\Pagination\LengthAwarePaginator;

class IssuesController extends Controller
{
    use InteractsWithGitHub;

    /**
     * @param \App\Http\Requests\Filters\Issue $filter
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Issue $filter)
    {
        return view('issues.index', [
            'current_page' => $filter->page(),
        ]);
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
                'items' => [],
            ];
        }

        return response()->json([
            'success' => true,
            'issues' => $issues,
        ]);
    }

    public function count(Issue $filter)
    {
        $count = $this->issues_count($filter);

        return response()->json([
            'success' => true,
            'open' => $count['open'],
            'closed' => $count['closed'],
        ]);
    }

    /**
     * @param $username
     * @param $repository
     * @param $issue_id
     * @param \App\Http\Requests\Filters\IssueComments $filter
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($username, $repository, $issue_id, IssueComments $filter)
    {
        try {
            $issue = $this->issueWithComments(
                $username, $repository, (int) $issue_id, $filter
            );

            $comments = new LengthAwarePaginator(
                $issue['comments_list'],
                $issue['comments'],
                $filter->per_page(),
                $filter->page(),
                ['path' => route('issues.show', [$username, $repository, $issue_id])]
            );

            return view('issues.show', compact('issue', 'comments'));
        } catch (\Exception $e) {
            abort(404);
        }
    }
}
