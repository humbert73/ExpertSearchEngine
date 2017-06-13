<div class="article">
    <h3 class="authors">
        <?= implode(', ', $article->getAuthors()) ?>
    </h3>
    <h4 class="title"><?php echo $article->getTitle(); ?></h4>
    <h5 class="conference">
        <?= ($article->getConference() ? $article->getConference().', ' : '').$article->getDate(); ?>
    </h5>
    <div class="content"><?= $article->getContent() ?></div>
</div>