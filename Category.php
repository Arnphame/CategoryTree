<?php
/**
 * Created by PhpStorm.
 * User: Arn
 * Date: 2018-09-27
 * Time: 19:12
 */

class Category
{
    public $id;
    public $parent_id;
    public $name;
    public function __construct($id, $parent_id, $name)
    {
        $this->id = $id;
        $this->parent_id = $parent_id;
        $this->name = $name;
    }
    public static function create($id, $parent_id, $name){
        if (is_numeric($id) && is_numeric($parent_id)){
            return new Category($id, $parent_id, $name);
        }
        else return NULL;
    }
}