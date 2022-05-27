<?php

    $routes = array(
        'AuthorsController' => array(
            'authors/page=([0-9]+)' => 'index/$1',
            'authors' => 'index',
            'author/add' => 'add',
            'author/edit/([0-9]+)' => 'edit/$1',
            'author/delete/([0-9]+)' => 'delete/$1'

        ),
        'GenresController' => array(
            'genres' => 'index',
            'genre/add' => 'add',
            'genre/edit/([0-9]+)' => 'edit/$1',
            'genre/delete/([0-9]+)' => 'delete/$1'
        ),
        'UsersController' => array(
            'reg' => 'reg',
            'auth' => 'auth',
            'logout' => 'logout'
        ),
        'BooksController' => array(
            'books' => 'index',
            'book/add' => 'add',
            'book/edit/([0-9]+)' => 'edit/$1',
            'book/delete/([0-9]+)' => 'delete/$1'
        ),
    );
