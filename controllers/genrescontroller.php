<?php

    require_once("models/genre.php");

    class GenresController
    {
        private $genreModel;
        public $isAuthorized;

        public function __construct()
        {
            $this->genreModel = new Genre();
            $userModel = new User();
            $this->isAuthorized = $userModel->checkIfUserAuthorized();
        }

        public function actionIndex()
        {
            $genres = $this->genreModel->getAll();
            $title = 'Жанры';
            require_once("views/genres/table.html");
        }

        public function actionAdd()
        {
            $title = 'Добавление жанра';
            $errors = [];
            if(isset($_POST['genre'])) {
                $genre = htmlentities($_POST['genre']);
                // TODO: сделать проверку на регулярки -> если проверка на регулярку не проходит, то пушим в errors
                // TODO: проверки на то, что значение есть в таблице
                if(empty($errors)) {
                    $this->genreModel->insert($genre);
                    header('Location: ' . FULL_SITE_ROOT . 'genres');
                }
            }
            require_once("views/genres/form.html");
        }

        public function actionEdit($id)
        {
            $title = 'Редактирование жанра';
            $errors = [];
            $genre = $this->genreModel->getById($id);
            if(isset($_POST['genre'])) {
                $name = htmlentities($_POST['genre']);
                // TODO: сделать проверку на регулярки -> если проверка на регулярку не проходит, то пушим в errors
                if(empty($errors)) {
                    if($genre['genre_name'] === $name) {
                        header('Location: ' . FULL_SITE_ROOT . 'genres');
                    }
                    if($genre['genre_name'] !== $name) {
                        // TODO: проверки на то, что значение есть в таблице
                        $result = $this->genreModel->edit($name, $id);
                        if ($result) {
                            header('Location: ' . FULL_SITE_ROOT . 'genres');
                        } else {
                            $errors[] = "Не удалось изменить данные в таблице";
                        }
                    }
                }
            }
            require_once("views/genres/form.html");
        }

        public function actionDelete($id)
        {
            $errors = [];
            // TODO: сделать проверку на то, что $id передан правильно
            $this->genreModel->remove($id);
            header('Location: ' . FULL_SITE_ROOT . 'genres');
        }
    }
