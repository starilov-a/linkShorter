<?php

namespace App;

class BD
{
    private $host;
    private $base;
    private $user;
    private $password;

    private $connection;

    public function __construct($host, $base, $user, $password) {
        $this->host = $host;
        $this->base = $base;
        $this->user = $user;
        $this->password = $password;

        $this->connection = $this->openConnect();
    }

    private function openConnect() {
        try{
            $connection = new \mysqli($this->host, $this->user, $this->password, $this->base);
            if($connection->connect_errno)
                throw new \RuntimeException('Ошибка при подключении к БД: '.$connection->connect_errno);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        return $connection;
    }

    private function query($sql) {
        $item = [];
        if ($result = $this->connection->query($sql)){
            if($result->num_rows > 0)
                while($row = mysqli_fetch_assoc($result))
                    $item[] = $row;
        }


        return $item;
    }

    public function getLinks($filter = []) {
        $filterString = '';
        if(!empty($filter))
            foreach ($filter as $title => $value)
                $filterString = 'WHERE links.'.$title.' = \''.$value.'\'';

        return $this->query('SELECT * FROM links '.$filterString.' ORDER BY links.created_at DESC');
    }

    public function addLinks($longUrl, $shortUrl) {
        $this->connection->query('INSERT INTO links (long_link, short_link, created_at) VALUES (\''.$longUrl.'\',\''.$shortUrl.'\',\''.date("Y-m-d").'\')');
    }
}