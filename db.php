<?php
include_once 'config.php';
class catDB
{
    private $database;

    public function __construct()
    {
        $this->database = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        if (mysqli_connect_errno()) {
            echo "Error: Could not connect to database.";
            exit;
        }
    }

    public function insert_category($parent_id, $name)
    {
        $prepare = $this->database->prepare("INSERT INTO categories (parent_id, name) VALUES (?,?)");
        $prepare->bind_param("is",$parent_id,$name);
        if($prepare->execute()){
            return $prepare;
        }
        else return false;
    }
    public function getAllCategories()
    {
        $prepare = $this->database->prepare("SELECT id, parent_id, name FROM categories");
        $prepare->execute() or die(mysqli_connect_errno() . "Cannot get matches");
        if($prepare) {
            $prepare->execute();
            return $prepare;
        }
        else return false;
    }
}
?>