<div class="article">
    <h3 class="authors">
        <?php
            $i = 1;
            foreach ($article->getAuthors() as $author) {
                echo '<a href="' . $url . '?search=' . $author . '&type=author">' . $author . '</a>';
                echo(sizeof($article->getAuthors()) > $i ? ', ' : '');
                $i++;
            }
        ?>
    </h3>
    <h4 class="title"><a href="<?= $article_link ?>"> <?php echo $article->getTitle(); ?> </a></h4>
    <h5 class="conference">
        <?= ($article->getConference() ? $article->getConference() . ', ' : '').$article->getDate(); ?>
    </h5>
    <?php if ($article->getShortContent()) : ?>
        <div class="short-content">
            <?= $article->getShortContent() ?> <a href="<?= $article_link ?>">Read more...</a>
        </div>
    <?php endif; ?>
    <div class="keywords">
        <?php if (sizeof($article_factory->getKeyWords($article)) > 0) :
            echo 'Keywords: ';
            $i = 1;
            foreach ($article_factory->getKeyWords($article) as $kw => $weight) {
                $link = '<a href="' . $url . '?search=' . $kw . '&type=keyword">';
                if ($weight > 2) {
                    echo '<strong>' . $link . $kw . '</a></strong>';
                } else {
                    echo $link . $kw . '</a>';
                }

                echo(sizeof($article_factory->getKeyWords($article)) > $i ? ', ' : '');
                $i++;
            }
        endif;
        ?>
    </div>


</div>