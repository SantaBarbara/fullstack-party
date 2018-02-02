<?php

namespace App\Http\Requests\Filters;

use Illuminate\Http\Request;

class Issue extends Filter
{
    const DEFAULT_STATE = 'open';

    /**
     * Filters which will be applied to the search.
     *
     * @var array
     */
    protected $appliedFilters;

    /**
     * Available filter names.
     *
     * @var array
     */
    protected $allowedFilters = [
        'state',
    ];

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->appliedFilters = [
            'state' => self::DEFAULT_STATE,
            'mentions' => auth()->user()->nickname,
        ];
    }

    /**
     * @return string
     */
    public function make(): string
    {
        foreach ($this->allowedFilters as $filter) {
            if ($this->request->has($filter)) {
                $this->$filter($this->request->get($filter));
            }
        }

        return $this->assembleQuery();
    }

    /**
     * Apply issue state filter.
     *
     * @param $state
     *
     * @return \App\Http\Requests\Filters\Issue
     */
    public function state($state)
    {
        $this->appliedFilters['state'] = in_array($state, ['open', 'closed']) ? $state : self::DEFAULT_STATE;

        return $this;
    }

    /**
     * @return string
     */
    protected function assembleQuery() :string
    {
        return collect($this->appliedFilters)->map(function ($value, $key) {
            return $key.':'.$value;
        })->implode(' ');
    }
}
