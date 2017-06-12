<div class="article">
    <h3 class="authors">
        <?php
        $i = 1;
        foreach ($article->getAuthors() as $author) {
            echo '<a href="#TODO">' . $author . '</a>';

            echo (sizeof($article->getAuthors()) > $i ? ', ' : '');
            $i++;
        } ?>
    </h3>
    <h4 class="title"><a href="#readmore"> <?php echo $article->getTitle(); ?> </a></h4>
    <h5 class="conference">
        <?php
            if($article->getConference() != ''){
                echo ($article->getConference() ? $article->getConference() . ', ' : '') . $article->getDate();
            }else{
                echo $article->getDate();
            }
        ?>
    </h5>
    <div class="short-content">
        <?php echo $article->getShortContent(); ?> <a href="#readmore">Read more...</a>
    </div>
    <div class="keywords">
        <?php
            echo 'Keywords: ';
            $i = 1;
            foreach($article->getKeyWords() as $kw => $weight){
                if($weight > 2){
                    echo '<strong>' . $kw . '</strong>';
                }else{
                    echo $kw;
                }

                echo (sizeof($article->getKeyWords()) > $i ? ', ' : '');
                $i++;
            }
        ?>
    </div>



</div>