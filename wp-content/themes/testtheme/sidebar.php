<aside class="sidebar">
<?php
    wp_reset_query();
    query_posts('page_id=29');
    the_post();
    ?>   
       <?php
            the_content();
            ?>
</aside>