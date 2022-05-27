<?php

class Book
{

    private $connect;

    public function __construct()
    {
        $this->connect = DB::getConnection();
    }

    public function getAll()
    {
        $query = "
            SELECT `book_id`, `book_name`, `book_price`, `book_year`,
            `genre_name`, GROUP_CONCAT(`author_fio`) AS `authors`
            FROM `books` 
            LEFT JOIN `genres` ON `book_genre_id` = `genre_id`
            LEFT JOIN `books_authors` ON `book_author_book_id` = `book_id`
            LEFT JOIN `authors` ON `book_author_author_id` = `author_id`
            WHERE `book_is_deleted` = 0
            GROUP BY `book_id`
            ";
        $result = mysqli_query($this->connect, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function add($data)
    {
        $query = "
            INSERT INTO `books` 
                SET `book_name` = '$data[name]',
                    `book_price` = $data[price],
                    `book_year` = $data[year],
                    `book_genre_id` = $data[genre]
                ";
        mysqli_query($this->connect, $query);
        $bookId = mysqli_insert_id($this->connect);
        $query = "INSERT INTO `books_authors` (`book_author_book_id`, `book_author_author_id`) VALUES ";
        foreach ($data['authors'] as $author) {
            $query .= "($bookId, $author), ";
        }
        $query = rtrim($query, ", ");
        return mysqli_query($this->connect, $query);
    }

    public function getById($id)
    {
        $query = "SELECT `book_name`, `book_price`, `book_genre_id`, `genre_name`, `book_year`, 
                      GROUP_CONCAT(`book_author_author_id`) AS `authors`
                      FROM `books`
                      LEFT JOIN `books_authors` ON `book_author_book_id` = `book_id`
                      LEFT JOIN `genres` ON `book_genre_id` = `genre_id`  
                      WHERE `book_id` = $id
                      GROUP BY `book_id`
                  ";
        $result = mysqli_query($this->connect, $query);
        return mysqli_fetch_assoc($result);
    }

    public function edit($data, $id)
    {
        $query = "UPDATE `books`
                      SET `book_name` = '$data[name]',
                          `book_price` = $data[price],
                          `book_year` = $data[year],
                          `book_genre_id` = $data[genre]
                      WHERE `book_id` = $id";
        mysqli_query($this->connect, $query);

        $query = "DELETE FROM `books_authors`
                        WHERE `book_author_book_id` = $id";
        mysqli_query($this->connect, $query);

        $query = "INSERT INTO `books_authors` (`book_author_book_id`, `book_author_author_id`) VALUES ";
        foreach ($data['authors'] as $author) {
            $query .= "($id, $author), ";
        }
        $query = rtrim($query, ", ");

        return mysqli_query($this->connect, $query);
    }

    public function remove($id)
    {
        $query = "UPDATE `books`
                      SET `book_is_deleted` = 1
                      WHERE `book_id` = $id";
        return mysqli_query($this->connect, $query);
    }

}
