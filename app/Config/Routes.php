<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Books::index');
$routes->get('authors', 'Authors::index');
$routes->get('publishers', 'Publishers::index');
$routes->get('members', 'Members::index');
$routes->get('borrows', 'Borrows::index');

$routes->group('api', function ($routes) {
    $routes->resource('books', ['controller' => 'Api\BookController']);
    $routes->resource('authors', ['controller' => 'Api\AuthorController']);
    $routes->resource('publishers', ['controller' => 'Api\PublisherController']);
    $routes->resource('members', ['controller' => 'Api\MemberController']);
    $routes->resource('borrows', ['controller' => 'Api\BorrowTransactionController']);
});
