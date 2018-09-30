<?php
include("Category.php");
include('db.php');
include("CategoryTree.php");
session_start();
$categories = new catDB();
/*
 * Get data from form.php and insert it into database
 */
if(isset($_POST['name']) && isset($_POST['parent_id'])) {
    $name = $_POST['name'];
    $p_id = $_POST['parent_id'];
    $categories->insert_category($p_id,$name);
}

/*
 * Get all categories from database
 */
$cat = $categories->getAllCategories()->get_result();
$categoriesArray = array();
while($row = mysqli_fetch_assoc($cat)){
    $categoriesArray[] = Category::create($row['id'], $row['parent_id'], $row['name']);
}

$_SESSION['categories'] = $categoriesArray;     //pass $categoriesArray to form.php

$x = buildTree($categoriesArray);

/*
 * prints $categoryTree->name recursively.
 */
function recursive_print($categoryTree) {
    if($categoryTree->name != "Root")
        echo '<li><h4>' . $categoryTree->name . '</li></h4>';
    foreach($categoryTree->subCats as $subCat) {
        echo '<ul>';
        recursive_print($subCat);
        echo '</ul>';
    }
}
/*
 * Prints $categoryTree->name iteratively.
 */
function iterative_print($categoryTree) {
    $stack = array(array($categoryTree));
    while (count($stack)) {
        $category = array_shift($stack[count($stack)-1]);
        if($category->name != "Root")
            echo '<li><h4>' . $category->name . '</li></h4>';
        echo '<ul>';
        $stack[] = $category->subCats;
        while (count($stack) && count($stack[count($stack)-1]) == 0) {
            echo '</ul>';
            array_pop($stack);
        }
    }
}
/*
 * Convert from object array to category tree
 * Needed for iterative and recursion functions
 * Example Format:
 * $x->add_sub_cat(new CategoryTree($categoriesArray[0]->name));                           //Category A
 * $x->add_sub_cat(new CategoryTree($categoriesArray[1]->name));                           //Category B
 * $x->add_sub_cat(new CategoryTree($categoriesArray[2]->name));                           //Category C
 * $x->subCats[1]->add_sub_cat(new CategoryTree($categoriesArray[3]->name));               //Sub-Cat F
 * $x->subCats[1]->add_sub_cat(new CategoryTree($categoriesArray[4]->name));               //Sub-Cat G
 * $x->subCats[2]->add_sub_cat(new CategoryTree($categoriesArray[5]->name));               //Sub-Cat H
 */
function buildTree($categoriesArray)
{
    $tree = new CategoryTree("Root");
    $registry = [0 => $tree]; // One entry: Root (parentId = 0)
    foreach ($categoriesArray as $c) {
        $catTree = new CategoryTree($c->name);
        $registry[$c->id] = $catTree;
        $registry[$c->parent_id]->add_sub_cat($catTree);
    }
    return $tree;
}
?>
<html>
<head>
    <title>Category Tree</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <style type="text/css">
        html,
        body {
            height: 100%;
        }
        #footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="col-lg-6">
        <h1>ITERATIVE PRINT</h1>
        <?php
        $start = microtime(true);
        iterative_print($x);
        $end = microtime(true);
        $time = ($end - $start) * 1000;
        echo("Function execution time: " . number_format($time,3) . " miliseconds.");
        ?>
    </div>
    <div class="col-lg-6">
        <h1>RECURSIVE PRINT</h1>
        <?php
        $start = microtime(true);
        recursive_print($x);
        $end = microtime(true);
        $time = ($end - $start) * 1000;
        echo("Function execution time: " . number_format($time,3) . " miliseconds.");
        ?>
    </div>
</div>

<div class="container">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-xs-4">
                </div>
                <div class="col-xs-4">
                    <a href="form.php" id="x" class="btn btn-info" role="button">Add new category</a>
                </div>
                <div class="col-xs-4">
                </div>
            </div>
        </div>
</div>
<div id="footer" class="page-footer fixed-bottom">
    <div class="footer-copyright text-right py-3">© 2018 Copyright:
        <a> Arnas Damasickis</a>
    </div>
</div>
</body>
</html>