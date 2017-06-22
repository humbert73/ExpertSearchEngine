<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $article->getTitle() ?></title>
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
    <div class="article">
        <h3 class="authors">
            <?php
            $i = 1;
            foreach ($article->getAuthors() as $author) {
                echo $author;
                echo(sizeof($article->getAuthors()) > $i ? ', ' : '');
                $i++;
            }
            ?>
        </h3>
        <h4 class="title"><?php echo $article->getTitle(); ?> </h4>
        <h5 class="conference">
            <?= ($article->getConference() ? $article->getConference() . ', ' : '') . $article->getDate(); ?>
        </h5>
        <?php if ($article->getContent()) : ?>
            <div class="short-content">
                <?= $article->getContent() ?>
            </div>
        <?php endif; ?>
        <div class="keywords">
            <?php if (sizeof($article_factory->getKeyWords($article)) > 0) :
                echo 'Keywords: ';
                $i = 1;
                foreach ($article_factory->getKeyWords($article) as $kw => $weight) {
                    if ($weight > 2) {
                        echo '<strong>' . $kw . '</strong>';
                    } else {
                        echo $kw;
                    }

                    echo(sizeof($article_factory->getKeyWords($article)) > $i ? ', ' : '');
                    $i++;
                }
            endif;
            ?>
        </div>
    </div>
    <br />
    <a href="<?= $url ?>"><button class="btn btn-primary">
        Back to search engine
    </button></a>
</body>