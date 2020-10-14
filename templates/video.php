<?php if(!get_field('is_playlist')){ ?>
  <div>
    <div class="video-container">
      <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php the_field('video_id'); ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
    <p class="video-link">
      <a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></a>
    </p>
  </div>
<?php }  ?>