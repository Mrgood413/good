<?php
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');

class CategoryController
{
    private $categoryModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }
    public function list()
    {
        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/list.php';
    }
    public function add()
    {
        include_once 'app/views/category/add.php';
    }
    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $result = $this->categoryModel->addCategory($name, $description);
            if ($result) {
                header('Location:  /Category');
                exit;
            } else {
                echo "Đã xảy ra lỗi khi thêm danh mục.";
            }
        }
    }
    public function edit($id)
    {
        $category = $this->categoryModel->getCategoryById($id);
        if ($category) {
            include 'app/views/category/edit.php';
        } else {
            echo "Không tìm thấy danh mục.";
        }
    }
    public function update()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];

        $update = $this->categoryModel->updateCategory($id, $name, $description);
        
        if ($update) {
            header('Location:  /Category/list');
            exit;
        } else {
            $errors[] = "Đã xảy ra lỗi khi cập nhật danh mục.";
            include 'app/views/category/edit.php';
        }
    }
}

    public function delete($id)
    {
        if ($this->categoryModel->deleteCategory($id)) {
            header('Location:  /Category/list');
            exit;
        } else {
            echo "Đã xảy ra lỗi khi xóa danh mục.";
        }
    }
}
?>
