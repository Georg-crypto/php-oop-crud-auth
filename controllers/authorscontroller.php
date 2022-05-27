<?php

    class AuthorsController
    {
        private $authorModel;
        public $isAuthorized;

        public function __construct()
        {
            $this->authorModel = new Author();
            $userModel = new User();
            $this->isAuthorized = $userModel->checkIfUserAuthorized();
        }

        public function actionIndex($page = 1)
        {
            $total = $this->authorModel->getTotal();
            $limit = 2;
            $currentPage = $page;
            $index = 'page=';
            $offset = ($page - 1) * $limit;
            $pagination = new Pagination($total, $currentPage, $limit, $index);
            $authors = $this->authorModel->getAllPaginated($limit, $offset);
            $title = 'Авторы';
            require_once("views/authors/table.html");
        }

        public function actionAdd()
        {
            $title = 'Добавление автора';
            $errors = [];
            if(isset($_POST['fio'])) {
                $fio = htmlentities($_POST['fio']);
                // TODO: сделать проверку на регулярки -> если проверка на регулярку не проходит, то пушим в errors
                // TODO: проверки на то, что значение есть в таблице
                if(empty($errors)) {
                    $this->authorModel->insert($fio);
                    header('Location: ' . FULL_SITE_ROOT . 'authors');
                }
            }
            require_once("views/authors/form.html");
        }

        public function actionEdit($id)
        {
            $title = 'Редактирование автора';
            $errors = [];
            $author = $this->authorModel->getById($id);
            if(isset($_POST['fio'])) {
                $fio = htmlentities($_POST['fio']);
                // TODO: сделать проверку на регулярки -> если проверка на регулярку не проходит, то пушим в errors
                if(empty($errors)) {
                    if($author['author_fio'] === $fio) {
                        header('Location: ' . FULL_SITE_ROOT . 'authors');
                    }
                    if($author['author_fio'] !== $fio) {
                        // TODO: проверки на то, что значение есть в таблице
                        $result = $this->authorModel->edit($fio, $id);
                        if ($result) {
                            header('Location: ' . FULL_SITE_ROOT . 'authors');
                        } else {
                            $errors[] = "Не удалось изменить данные в таблице";
                        }
                    }
                }
            }
            require_once("views/authors/form.html");
        }

        public function actionDelete($id)
        {
            $errors = [];
            // TODO: сделать проверку на то, что $id передан правильно
            $this->authorModel->remove($id);
            header('Location: ' . FULL_SITE_ROOT . 'authors');
        }

    }
