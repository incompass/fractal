<?php

/*
 * This file is part of the League\Fractal package.
 *
 * (c) Phil Sturgeon <me@philsturgeon.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\Fractal\Pagination;

use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * A paginator adapter for illuminate/pagination.
 *
 * @author Joe Mizzi <themizzi@me.com>
 * @author Maxime Beaudoin <firalabs@gmail.com>
 * @author Marc Addeo <marcaddeo@gmail.com>
 */
class DoctrinePaginatorAdapter implements PaginatorInterface
{
    /**
     * The paginator instance.
     *
     * @var Paginator
     */
    protected $paginator;

    /**
     * Create a new illuminate pagination adapter.
     *
     * @param Paginator $paginator
     */
    public function __construct(Paginator $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * Get the current page.
     *
     * @return int
     */
    public function getCurrentPage()
    {
        return intval(floor($this->paginator->getQuery()->getFirstResult() / $this->paginator->getQuery()->getMaxResults()) + 1);
    }

    /**
     * Get the last page.
     *
     * @return int
     */
    public function getLastPage()
    {
        return intval(floor($this->paginator->count() / $this->paginator->getQuery()->getMaxResults()));
    }

    /**
     * Get the total.
     *
     * @return int
     */
    public function getTotal()
    {
        return $this->paginator->count();
    }

    /**
     * Get the count.
     *
     * @return int
     */
    public function getCount()
    {
        return $this->getPerPage();
    }

    /**
     * Get the number per page.
     *
     * @return int
     */
    public function getPerPage()
    {
        return $this->paginator->getQuery()->getMaxResults();
    }

    /**
     * Get the url for the given page.
     *
     * @param int $page
     *
     * @return string
     */
    public function getUrl($page)
    {
        return $page;
    }

    /**
     * Get the paginator instance.
     *
     * @return Paginator
     */
    public function getPaginator()
    {
        return $this->paginator;
    }
}
