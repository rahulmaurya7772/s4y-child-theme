<?php

remove_action('genesis_loop', 'genesis_do_loop');
add_action('genesis_loop', 'genesis_404');

function genesis_404()
{
echo genesis_html5() ? '<article class="entry">' : '<div class="post hentry">';
printf('<h1 class="entry-title">%s</h1>', apply_filters('genesis_404_entry_title', __('<b>404 Error Not Found</b>', 'genesis')));
echo '<div class="entry-content">';
echo apply_filters('genesis_404_entry_content', '<p>' . sprintf(__('The page you are looking for no longer exists. Perhaps you can return back to the site\'s <a href="%s"><b>Homepage</b></a> and see if you can find what you are looking for. Or, you can try finding it by using the search form below.', 'genesis') , trailingslashit(home_url())) . '</p>');
?>

<img src="https://sahu4you.com/wp-content/uploads/2018/06/Error-404-Page.png" alt="sahu 4 you">
<h4><?php
_e('Search more than 500+ Articles:', 'genesis'); ?></h4>

<form class="search-form" itemprop="potentialAction" itemscope="" itemtype="https://schema.org/SearchAction" method="get" action="" role="search"><meta itemprop="target" content="/?s={s}"><label class="search-form-label screen-reader-text" for="searchform-5bd4535c4560e9.20300117">Search...</label><input itemprop="query-input" type="search" name="s" id="searchform-5bd4535c4560e9.20300117" placeholder="Search ..."><input type="submit" value="Search"></form>

<script type="text/javascript" src="https://www.google.com/coop/cse/brand?form=cse-search-box&amp;lang=en"></script>

<div class="archive-page">
<br />
<h4><?php
_e('You might like reading these recent posts:', 'genesis'); ?></h4>
<ul>
<?php
wp_get_archives('type=postbypost&limit=10'); ?>
</ul>

</div><!-- end .archive-page-->
<?php
}

genesis();