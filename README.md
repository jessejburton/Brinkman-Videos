# Brinkman Videos Shortcode

Current Version: 1.0

## 1. Description
Adds a shortcode for displaying comments from videos using the YouTube API.

## 2. History
Originally also added a video shortcode and template but there is now a
single-video.php file that can just be copied in to the theme
(or ideally a child theme) folder.

## 3. Usage
### Video Post Types
1) Install Advanced Custom Fields and Custom Post Type UI plugins.
2) Setup the post types and fields as outlined in section 4.
3) Copy the single-video.php file to your active theme folder.
4) New create a video post and then visit the page to see the
   playable video with tabs for showing the lyrics and info below.

### Videos Shortcode
1) Use the shortcode `[brinkman-videos /]` to display the videos on a page
| Attribute | Required   | Default | Details                                                             |
|-----------|------------|---------|---------------------------------------------------------------------|
| show      | optional   | -       | Selects only the videos tagged with a specific show i.e. "Featured" |
| max_posts | optional   | 3       | Maximum number of videos to display                                 |

### Comments Shortcode
1) Use the shortcode `[brinkman-comments /]` to display comments from YouTube
| Attribute | Required   | Default | Details                                                             |
|-----------|------------|---------|---------------------------------------------------------------------|
| max_posts | optional   | 1       | Maximum number of comments to display (I believe this is stuck at 1 because of a bug)|


## 4. Custom Post Type
The custom post type has been added using the [Custom Post Type UI plugin](https://en-ca.wordpress.org/plugins/custom-post-type-ui/), additional fields have been added via the [Advanced Custom Fields plugin](https://en-ca.wordpress.org/plugins/advanced-custom-fields/)

#### Custom Post Type
##### Video
Post Type Slug    : video
Plural Label      : Videos
Singular Label    : Video
Show in REST API  : true
Has Archive       : true

Support
- Title
- Featured Image
- Custom Fields
- Page Attributes

Taxonomies
- Shows

#### Advanced Custom Fields
##### Additional Video Information
Rules
- Show this field group of Post Type is equal to Video

Style
- Standard (WP metabox)

##### Fields
###### Lyrics
Field Name        : lyrics
Field Type        : Wysiwyg Editor

###### More
Field Name        : more
Field Type        : Wysiwyg Editor