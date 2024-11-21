<?php

namespace app\controllers;

use app\models\Posts;

class PostsController
{
    public function validatePost($inputData) {
        $errors = [];
        $title = $inputData['title'];
        $info = $inputData['info'];

        if ($title) {
            $title = htmlspecialchars($title, ENT_QUOTES | ENT_HTML5, 'UTF-8', true);
            if (strlen($title) < 2) {
                $errors['titleShort'] = 'title is too short';
            }
        } else {
            $errors['requiredTitle'] = 'title is required';
        }

        if ($info) {
            $info = htmlspecialchars($info, ENT_QUOTES | ENT_HTML5, 'UTF-8', true);
            if (strlen($info) < 5) {
                $errors['infoShort'] = 'info is too short';
            }
        } else {
            $errors['requiredInfo'] = 'info is required';
        }

        if (count($errors)) {
            http_response_code(400);
            echo json_encode($errors);
            exit();
        }
        return [
            'title' => $title,
            'info' => $info,
        ];
    }

    public function getAllPosts() {
        $postsModel = new Posts();
        header("Content-Type: application/json");
        $posts = $postsModel->getAllPosts();

        echo json_encode($posts);
        exit();
    }

    public function getPostByID($id) {
        $postsModel = new Posts();
        header("Content-Type: application/json");
        $post = $postsModel->getPostById($id);
        echo json_encode($post);
        exit();
    }

    public function savePost() {
        $inputData = [
            'title' => $_POST['title'] ? $_POST['title'] : false,
            'info' => $_POST['info'] ? $_POST['info'] : false,
        ];
        $postData = $this->validatePost($inputData);

        $post = new Posts();
        $post->addPost(
            [
                'title' => $postData['title'],
                'info' => $postData['info'],
            ]
        );

        http_response_code(200);
        echo json_encode([
            'success' => true
        ]);
        exit();
    }

    public function editPost($id) {
        if (!$id) {
            http_response_code(404);
            exit();
        }

        parse_str(file_get_contents('php://input'), $_PUT);

        $inputData = [
            'title' => $_PUT['title'] ? $_PUT['title'] : false,
            'info' => $_PUT['info'] ? $_PUT['info'] : false,
        ];
        $postData = $this->validatePost($inputData);

        $post = new Posts();
        $post->editPost(
            $id,
            [
                'title' => $postData['title'],
                'info' => $postData['info'],
            ]
        );

        http_response_code(200);
        echo json_encode([
            'success' => true
        ]);
        exit();
    }

    public function deletePost($id) {
        if (!$id) {
            http_response_code(404);
            exit();
        }

        $post = new Posts();
        $post->deletePost($id);

        http_response_code(200);
        echo json_encode([
            'success' => true
        ]);
        exit();
    }

    public function postsView() {
        include '../public/assets/views/posts/posts-view.html';
        exit();
    }

    public function postsAddView() {
        include '../public/assets/views/posts/posts-add.html';
        exit();
    }

    public function postsDeleteView() {
        include '../public/assets/views/posts/posts-delete.html';
        exit();
    }

    public function postsUpdateView() {
        include '../public/assets/views/posts/posts-update.html';
        exit();
    }
}

