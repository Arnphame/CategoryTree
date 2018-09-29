<?php
/**
 * Created by PhpStorm.
 * User: Arn
 * Date: 2018-09-29
 * Time: 09:37
 */

class CategoryTree
{
    public $name;
    public $subCats = array();

    public function __construct($name = "") {
        $this->name = $name;
    }

    public function add_sub_cat($subCat) {
        array_push($this->subCats, $subCat);
    }
}