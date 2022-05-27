<?php

    class Author
    {

        private $connect;

        public function __construct()
        {
            $this->connect = DB::getConnection();
        }

        public function getAll()
        {
            $query = "SELECT * FROM `authors` WHERE `author_is_deleted` = 0";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function getAllPaginated($limit, $offset)
        {
            $query = "SELECT * FROM `authors` 
                      WHERE `author_is_deleted` = 0
                      LIMIT $offset, $limit";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function insert($fio)
        {
            $query = "INSERT INTO `authors` SET `author_fio` = '$fio'";
            return mysqli_query($this->connect, $query);
        }

        public function getById($id)
        {
            $query = "SELECT `author_fio`
                      FROM `authors`
                      WHERE `author_id` = $id";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_assoc($result);
        }

        public function edit($fio, $id)
        {
            $query = "UPDATE `authors`
                      SET `author_fio` = '$fio'
                      WHERE `author_id` = $id";
            return mysqli_query($this->connect, $query);
        }

        public function remove($id)
        {
            $query = "UPDATE `authors`
                      SET `author_is_deleted` = 1
                      WHERE `author_id` = $id";
            return mysqli_query($this->connect, $query);
        }

        public function getTotal()
        {
            $query = "
                SELECT COUNT(*) AS `count`
                    FROM `authors`
                    WHERE `author_is_deleted` = 0;
            ";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_assoc($result)['count'];
        }
    }
