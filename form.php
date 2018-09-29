<?php
session_start();
$categoriesArray = $_SESSION['categories'];
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
</html>
<body>
<br>
<br>
<div class="container">
<form class="form-inline" action="index.php" method="post">
    <label for="name">Name</label>
    <input name="name" type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="inlineFormInput" placeholder="Category Name">
    <div class="form-group">
        <label for="parent">Parent</label>
        <select class="form-control" name="parent_id">
            <option value="0">I am parent</option>
        <?php
        foreach($categoriesArray as $cat) {
            $cat = get_object_vars($cat);
            echo '<option value=' . $cat['id'] . '>' . $cat['name'] . " (My ID: " . $cat['id'] . ", My PID: " . $cat['parent_id'] . ")" . '</option>';
        }
        ?>
    </select>
    </div>
    <br>
    <br>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
</body>
</html>