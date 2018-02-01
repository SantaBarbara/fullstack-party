<?php

namespace App\Traits;

use App\Http\Requests\Filters\IssueComments;
use App\Http\Requests\Filters\Issue;

trait InteractsWithGitHub
{
    /**
     * @return \Github\Client
     */
    public function github()
    {
        return app('GitHub');
    }

    /**
     * Fetch authenticated users issues.
     *
     * @param \App\Http\Requests\Filters\Issue $filter
     *
     * @return array
     */
    public function issues(Issue $filter)
    {
        return $this->github()->search()
            ->setPage($filter->page())
            ->setPerPage($filter->per_page())
            ->issues($filter->make());
    }

    /**
     * @param string $repository_owner
     * @param string $repository
     * @param int $issue_id
     *
     * @return array
     */
    public function issue(string $repository_owner, string $repository, int $issue_id) :array
    {
        return $this->github()
            ->issue()
            ->show($repository_owner, $repository, $issue_id);
    }

    /**
     * @param string $repository_owner
     * @param string $repository
     * @param int $issue_id
     *
     * @param \App\Http\Requests\Filters\IssueComments $filter
     *
     * @return array
     */
    public function issueWithComments(string $repository_owner, string $repository, int $issue_id, IssueComments $filter) :array
    {
        $issue = $this->issue($repository_owner, $repository, $issue_id);

        $issue['comments'] = $this->github()
            ->issue()
            ->comments()
            ->setPage($filter->page())
            ->setPerPage($filter->per_page())
            ->all($repository_owner, $repository, $issue_id);

        return $issue;
    }
}
