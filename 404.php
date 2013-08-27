<?php get_header(); ?>
   <div id="content" class="container">
     <h2 class="center">Error 404 - Not Found</h2>
   </div>

   <div id="sidebar" class="span4">
   	<?php $page_id = 5409; ?>
   	<?php $parent_page = get_page($page_id);//$parent_id); ?>
   	<?php dynamic_sidebar('sidebar'); ?>
   </div>
<?php get_footer(); ?>