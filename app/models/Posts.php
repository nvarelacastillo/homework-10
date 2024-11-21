<?php

namespace app\models;

use app\models\Model;

class Posts extends Model {

    public function getAllPosts() {
        $query = "select * from posts";
        return $this->fetchAll($query);
    }

    public function getPostById($id) {
        $query = "select * from posts where id = :id";
        return $this->fetch($query, [':id' => $id]);
    }

    public function addPost($data) {
        $query = "insert into posts (title, info) values (:title, :info)";
        return $this->query($query, [
            ':title' => $data['title'],
            ':info' => $data['info'],
        ]);
    }

    public function editPost($id, $data) {
        $query = "update posts set title = :title, info = :info where id = :id";
        return $this->query($query, [
            ':title' => $data['title'],
            ':info' => $data['info'],
            ':id' => $id
        ]);
    }

    public function deletePost($id) {
        $query = "delete from posts where id = :id";
        return $this->query($query, [':id' => $id]);
    }

}

