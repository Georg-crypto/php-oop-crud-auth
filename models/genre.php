<?php

    class Genre
    {
        private $connect;

        public function __construct()
        {
            $this->connect = DB::getConnection();
        }

        public function getAll()
        {
            $query = "SELECT * FROM `genres` WHERE `genre_is_deleted` = 0";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

        public function insert($genre)
        {
            $query = "INSERT INTO `genres` SET `genre_name` = '$genre'";
            return mysqli_query($this->connect, $query);
        }

        public function getById($id)
        {
            $query = "SELECT `genre_name`
                      FROM `genres`
                      WHERE `genre_id` = $id";
            $result = mysqli_query($this->connect, $query);
            return mysqli_fetch_assoc($result);
        }

        public function edit($name, $id)
        {
            $query = "UPDATE `genres`
                      SET `genre_name` = '$name'
                      WHERE `genre_id` = $id";
            return mysqli_query($this->connect, $query);
        }

        public function remove($id)
        {
            $query = "UPDATE `genres`
                      SET `genre_is_deleted` = 1
                      WHERE `genre_id` = $id";
            return mysqli_query($this->connect, $query);
        }
    }
