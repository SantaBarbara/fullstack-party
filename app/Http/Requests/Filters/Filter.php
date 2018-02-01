<?php

namespace App\Http\Requests\Filters;

use Illuminate\Http\Request;

abstract class Filter
{
    const DEFAULT_ITEMS_PER_PAGE = 1;

    const DEFAULT_PAGE = 1;

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get requested page number.
     *
     * @return int
     */
    public function page() :int
    {
        return (int) $this->request->get('page') ?: static::DEFAULT_PAGE;
    }

    /**
     * Get requested items per page number.
     * Allowed max items is 100.
     *
     * @return int
     */
    public function per_page() :int
    {
        $per_page = (int) $this->request->get('per_page');

        if (!$per_page || $per_page > 100) {
            $per_page = static::DEFAULT_ITEMS_PER_PAGE;
        }

        return $per_page;
    }
}
