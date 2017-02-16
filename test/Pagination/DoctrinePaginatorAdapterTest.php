<?php

namespace League\Fractal\Test\Pagination;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use League\Fractal\Pagination\DoctrinePaginatorAdapter;
use League\Fractal\Pagination\PaginatorInterface;
use Mockery;

class DoctrinePaginatorAdapterTest extends \PHPUnit_Framework_TestCase
{
    public function testPaginationAdapter()
    {
        $total = 50;
        $count = 10;
        $perPage = 10;
        $currentPage = 2;
        $lastPage = 5;

        $paginator = Mockery::mock(Paginator::class);
        $entityManager = Mockery::mock(EntityManagerInterface::class);
        $configuration = Mockery::mock(Configuration::class);
        $configuration->shouldReceive('getDefaultQueryHints')->andReturn([]);
        $configuration->shouldReceive('isSecondLevelCacheEnabled')->andReturn(false);
        $entityManager->shouldReceive('getConfiguration')->andReturn($configuration);
        $query = Mockery::mock(new Query($entityManager));
        $query->shouldReceive('getFirstResult')->andReturn(($currentPage - 1) * $perPage);
        $query->shouldReceive('getMaxResults')->andReturn($perPage);
        $paginator->shouldReceive('count')->andReturn($total);
        $paginator->shouldReceive('getQuery')->andReturn($query);

        $adapter = new DoctrinePaginatorAdapter($paginator);

        $this->assertInstanceOf(PaginatorInterface::class, $adapter);
        $this->assertInstanceOf(Paginator::class, $adapter->getPaginator());

        $this->assertSame($currentPage, $adapter->getCurrentPage());
        $this->assertSame($lastPage, $adapter->getLastPage());
        $this->assertSame($count, $adapter->getCount());
        $this->assertSame($total, $adapter->getTotal());
        $this->assertSame($perPage, $adapter->getPerPage());
        $this->assertSame(1, $adapter->getUrl(1));
    }

    public function tearDown()
    {
        Mockery::close();
    }
}
