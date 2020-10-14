<?php
  $video_id = get_field('video_id');
  $is_playlist = get_field('is_playlist');
  if(!$is_playlist){
    $url = "https://www.googleapis.com/youtube/v3/commentThreads?videoId=" . $video_id . "&key=AIzaSyBILBNSmiFPtWIm04HJeLTbMzABafgrcbk&part=snippet";
    $comment_data = get_data_from_youtube($url);

    function dateDifference($date1, $date2){
      $dateDiff = date_diff($date1, $date2);

      $days = $dateDiff->format('%a');

      switch( $days ){
        case $days > 730:
          return $dateDiff->format('%y') . ' years ago';
        break;
        case $days > 365:
          return $dateDiff->format('%y') . ' year ago';
        break;
        case $days < 365 && $days > 60:
          return $dateDiff->format('%m') . ' months ago';
        break;
        case $days < 365 && $days > 30:
          return $dateDiff->format('%m') . ' month ago';
        break;
        case $days < 30 && $days > 1:
          return $dateDiff->format('%a') . ' days ago';
        break;
        case $days === 1:
          return $dateDiff->format('%a') . ' day ago';
        break;
      }
    }
  ?>

      <?php
        foreach ($comment_data["items"] as &$comment) {
          $comment_text = $comment["snippet"]["topLevelComment"]["snippet"]["textDisplay"];
          $comment_id = $comment["id"];
          $comment_author_name = $comment["snippet"]["topLevelComment"]["snippet"]["authorDisplayName"];
          $comment_author_uri = $comment["snippet"]["topLevelComment"]["snippet"]["authorChannelUrl"];
          $comment_author_image = $comment["snippet"]["topLevelComment"]["snippet"]["authorProfileImageUrl"];
          $comment_likes = $comment["snippet"]["topLevelComment"]["snippet"]["likeCount"];
          $comment_published_at = date_create($comment["snippet"]["topLevelComment"]["snippet"]["publishedAt"]);
          $date_now = date_create(date("Y-m-d H:i:s"));

          // Only display the shorter text comments
          if(strlen($comment_text) < 100){
            ?>
              <div class="comment" data-videoid="<?php echo $video_id; ?>">
                <div class="comment-author-image">
                  <img
                    src="<?php echo $comment_author_image; ?>"
                    alt="<?php echo $comment_author_name; ?>" />
                </div>
                <div class="comment-content">
                  <div class="comment-author">
                    <a class="comment-author-link" href="<?php echo $comment_author_uri; ?>" target="_blank">
                      <?php echo $comment_author_name; ?>
                    </a>
                    <span class="comment-date">
                      <?php echo dateDifference($date_now, $comment_published_at); ?>
                    </span>
                  </div>
                  <div class="comment-text">
                    <a href="https://www.youtube.com/watch?v=<?php echo $video_id; ?>&lc=<?php echo $comment_id; ?>" target="_blank">
                      <?php echo $comment_text; ?>
                    </a>
                  </div>
                </div>

              </div>
            <?php
          }
        }
      ?>
<?php }

