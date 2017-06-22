<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>

    <link rel="stylesheet" href="search.css">
</head>
<body>

<form id="search-container" class="container input-group" method="get" action="index.php">
    <div class="col-lg-9">
        <input id="search" type="text" class="form-control" name="search" placeholder="Search for..." value="<?php echo $search ? $search : ''; ?>">
    </div>
    <div class="col-lg-2">
        <select id="type" class="form-control" name="type">
            <option value="keyword" <?php echo $type == "keyword" ? "selected" : ""; ?>>Keywords (articles)</option>
            <option value="author" <?php echo $type == "author" ? "selected" : ""; ?>>Author</option>
        </select>
    </div>
    <div class="col-lg-1">
        <span class="input-group-btn">
            <button class="btn btn-default" type="submit">Go!</button>
        </span>
    </div>
</form>

<div class="container">
    <?php if($search != "") :
        $res = sizeof($articles); ?>
        <br />
        <?php if($res > 0) : ?>
            <h2><?= $res ?> result<?= $res == 1 ? '' : 's'; ?> for '<?= $search ?>'</h2>
            <?php foreach($articles as $article):
                $article_link = $url.'?'.http_build_query(array('article_id'=>$article->getIndex()));
                include('_article.php');
            endforeach;
        else: ?>
            <h2>No results found for '<?= $search ?>'</h2>
        <?php endif;
    endif; ?>
</div>

</body>
</html>