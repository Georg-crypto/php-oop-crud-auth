<?php

class BooksController
{
    private $bookModel;
    private $authorModel;
    private $genreModel;
    public $isAuthorized;

    public function __construct()
    {
        $this->bookModel = new Book();
        $this->authorModel = new Author();
        $this->genreModel = new Genre();
        $userModel = new User();
        $this->isAuthorized = $userModel->checkIfUserAuthorized();
    }

    public function actionIndex()
    {
        $books = $this->bookModel->getAll();
        $title = 'Книги';
        require_once("views/books/table.html");
    }

    public function actionAdd()
    {
        $title = 'Добавление книги';
        $errors = [];
        if(isset($_POST['name'])) {
            $name = htmlentities($_POST['name']);
            $year = htmlentities($_POST['year']);
            $price = htmlentities($_POST['price']);
            $genre = htmlentities($_POST['genre']);
            $authors = $_POST['authors'];
            // TODO: сделать проверку на регулярки -> если проверка на регулярку не проходит, то пушим в errors
            $data = array (
                'name' => $name,
                'year' => $year,
                'price' => $price,
                'genre' => $genre,
                'authors' => $authors
            );
            $this->bookModel->add($data);
            header('Location: ' . FULL_SITE_ROOT . 'books');
        }
        $genres = $this->genreModel->getAll();
        $authors = $this->authorModel->getAll();
        require_once("views/books/form.html");
    }

    public function actionEdit($id)
    {
        $book = $this->bookModel->getById($id);
        $book['authors'] = explode(',', $book['authors']);
        $book['authors'] = array_reverse($book['authors']);
//            echo '<pre>';
//            print_r($book['authors']);
//            echo '</pre>';
        $title = 'Редактирование книги';
        $errors = [];
        if(isset($_POST['name'])) {
            $name = htmlentities($_POST['name']);
            $year = htmlentities($_POST['year']);
            $price = htmlentities($_POST['price']);
            $genre = htmlentities($_POST['genre']);
            $authors = $_POST['authors'];
//                echo '<pre>';
//                print_r($authors);
//                echo '</pre>';
            // TODO: сделать проверку на регулярки -> если проверка на регулярку не проходит, то пушим в errors
            $data = array (
                'name' => $name,
                'year' => $year,
                'price' => $price,
                'genre' => $genre,
                'authors' => $authors
            );
            if ($book['book_name'] === $name && $book['book_year'] === $year && $book['book_price'] === $price && $book['authors'] === $authors && $book['genre'] === $genre) {
                header('Location: ' . FULL_SITE_ROOT . 'books');
            }

            if ($book['book_name'] !== $name || $book['book_year'] !== $year || $book['book_price'] !== $price || $book['authors'] !== $authors || $book['genre'] !== $genre) {
                $result = $this->bookModel->edit($data, $id);

                if ($result) {
                    header('Location: ' . FULL_SITE_ROOT . 'books');
                } else {
                    $errors[] = "Не удалось изменить данные в таблице";
                }
            }
        }
        $genres = $this->genreModel->getAll();
        $authors = $this->authorModel->getAll();
        require_once("views/books/form.html");
    }

    public function actionDelete($id)
    {
        $errors = [];
        // TODO: сделать проверку на то, что $id передан правильно
        $this->bookModel->remove($id);
        header('Location: ' . FULL_SITE_ROOT . 'books');
    }

}