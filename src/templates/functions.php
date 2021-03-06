<?php
/*
 *  Author: Nate Vandervis | @natewich
 *  URL: html5blank.com | @html5blank
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

// Load any external files you have here

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if (!isset($content_width))
{
    $content_width = 900;
}

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    add_image_size('large', 700, '', true); // Large Thumbnail
    add_image_size('medium', 250, '', true); // Medium Thumbnail
    add_image_size('small', 120, '', true); // Small Thumbnail
    add_image_size('custom-size', 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail('custom-size');

    // Add Support for Custom Backgrounds - Uncomment below if you're going to use
    /*add_theme_support('custom-background', array(
	'default-color' => 'FFF',
	'default-image' => get_template_directory_uri() . '/img/bg.jpg'
    ));*/

    // Add Support for Custom Header - Uncomment below if you're going to use
    /*add_theme_support('custom-header', array(
	'default-image'			=> get_template_directory_uri() . '/img/headers/default.jpg',
	'header-text'			=> false,
	'default-text-color'		=> '000',
	'width'				=> 1000,
	'height'			=> 198,
	'random-default'		=> false,
	'wp-head-callback'		=> $wphead_cb,
	'admin-head-callback'		=> $adminhead_cb,
	'admin-preview-callback'	=> $adminpreview_cb
    ));*/

    // Enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Localisation Support
    load_theme_textdomain('html5blank', get_template_directory() . '/languages');
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// HTML5 Blank navigation
function html5blank_nav()
{
	wp_nav_menu(
	array(
		'theme_location'  => 'header-menu',
		'menu'            => '',
		'container'       => false,
		'container_class' => false,
		'container_id'    => '',
		'menu_class'      => '',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => '',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '%3$s',
		'depth'           => 0,
		'walker'          => ''
		)
	);
}

// Load HTML5 Blank scripts (header.php)
function html5blank_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {

    	// wp_register_script('conditionizr', get_template_directory_uri() . '/js/lib/conditionizr-4.3.0.min.js', array(), '4.3.0'); // Conditionizr
      //   wp_enqueue_script('conditionizr'); // Enqueue it!
      //
      //   wp_register_script('modernizr', get_template_directory_uri() . '/js/lib/modernizr-2.7.1.min.js', array(), '2.7.1'); // Modernizr
      //   wp_enqueue_script('modernizr'); // Enqueue it!

        wp_register_script('html5blankscripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_enqueue_script('html5blankscripts'); // Enqueue it!
    }
}

// Load HTML5 Blank conditional scripts
function html5blank_conditional_scripts()
{
    if (is_page('pagenamehere')) {
        wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0'); // Conditional script(s)
        wp_enqueue_script('scriptname'); // Enqueue it!
    }
}

// Load HTML5 Blank styles
function html5blank_styles()
{
    //wp_register_style('normalize', get_template_directory_uri() . '/normalize.css', array(), '1.0', 'all');
    //wp_enqueue_style('normalize'); // Enqueue it!

    wp_register_style('html5blank', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
    wp_enqueue_style('html5blank'); // Enqueue it!
}

// Register HTML5 Blank Navigation
function register_html5_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        'header-menu' => __('Header Menu', 'html5blank'), // Main Navigation
        'sidebar-menu' => __('Sidebar Menu', 'html5blank'), // Sidebar Navigation
        'extra-menu' => __('Extra Menu', 'html5blank') // Extra Navigation if needed (duplicate as many as you need!)
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// If Dynamic Sidebar Exists
if (function_exists('register_sidebar'))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        'name' => __('Widget Area 1', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-1',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        'name' => __('Widget Area 2', 'html5blank'),
        'description' => __('Description for this widget-area...', 'html5blank'),
        'id' => 'widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt('html5wp_custom_post');
function html5wp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Custom View Article link to Post
function html5_blank_view_article($more)
{
    global $post;
    return '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . __('View Article', 'html5blank') . '</a>';
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove 'text/css' from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}

// Custom Comments Callback
function html5blankcomments($comment, $args, $depth)
{
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
	<?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
	</div>
<?php if ($comment->comment_approved == '0') : ?>
	<em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
			printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)'),'  ','' );
		?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php }

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'html5blank_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'html5blank_conditional_scripts'); // Add Conditional Page Scripts
add_action('get_header', 'enable_threaded_comments'); // Enable Threaded Comments
add_action('wp_enqueue_scripts', 'html5blank_styles'); // Add Theme Stylesheet
add_action('init', 'register_html5_menu'); // Add HTML5 Blank Menu
add_action('init', 'create_post_type_banners'); // Add our Banners Post Type
add_action('init', 'create_post_type_shows'); // Add our Shows Post Type
add_action('init', 'create_post_type_music'); // Add our Music Post Type
add_action('init', 'create_post_type_videos'); // Add our Videos Post Type
add_action('widgets_init', 'my_remove_recent_comments_style'); // Remove inline Recent Comment Styles from wp_head()
add_action('init', 'html5wp_pagination'); // Add our HTML5 Pagination

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters
add_filter('avatar_defaults', 'html5blankgravatar'); // Custom Gravatar in Settings > Discussion
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args'); // Remove surrounding <div> from WP Navigation
// add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter('page_css_class', 'my_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('excerpt_more', 'html5_blank_view_article'); // Add 'View Article' button instead of [...] for Excerpts
add_filter('show_admin_bar', 'remove_admin_bar'); // Remove Admin bar
add_filter('style_loader_tag', 'html5_style_remove'); // Remove 'text/css' from enqueued stylesheet
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode('html5_shortcode_demo', 'html5_shortcode_demo'); // You can place [html5_shortcode_demo] in Pages, Posts now.
add_shortcode('html5_shortcode_demo_2', 'html5_shortcode_demo_2'); // Place [html5_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here's the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

// Banners Custom Post Type
function create_post_type_banners()
{
    register_taxonomy_for_object_type('category', 'banners'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'banners');
    register_post_type('banners', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Banners', 'banners'),
            'singular_name' => __('Banner', 'banners'),
            'add_new' => __('Add Banner', 'banners'),
            'add_new_item' => __('Add New Banner', 'banners'),
            'edit' => __('Edit', 'banners'),
            'edit_item' => __('Edit Banner', 'banners'),
            'new_item' => __('New Banner', 'banners'),
            'view' => __('View Banner', 'banners'),
            'view_item' => __('View Banner', 'banners'),
            'search_items' => __('Search Banners', 'banners'),
            'not_found' => __('No Banners found', 'banners'),
            'not_found_in_trash' => __('No Banners found in Trash', 'banners')
        ),
        'public' => true,
        'has_archive' => false,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
        'query_var' => false,
        'hierarchical' => false, // Allows your posts to behave like Hierarchy Pages
        'supports' => array(
            'title',
            'thumbnail'
        ),
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            'post_tag',
            'category'
        ) // Add Category and Post Tags support
    ));
}

// Shows Custom Post Type
function create_post_type_shows()
{
    register_taxonomy_for_object_type('category', 'shows'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'shows');
    register_post_type('shows', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Shows', 'shows'),
            'singular_name' => __('Show', 'shows'),
            'add_new' => __('Add Show', 'shows'),
            'add_new_item' => __('Add New Show', 'shows'),
            'edit' => __('Edit', 'shows'),
            'edit_item' => __('Edit Show', 'shows'),
            'new_item' => __('New Show', 'shows'),
            'view' => __('View Show', 'shows'),
            'view_item' => __('View Show', 'shows'),
            'search_items' => __('Search Shows', 'shows'),
            'not_found' => __('No Shows found', 'shows'),
            'not_found_in_trash' => __('No Shows found in Trash', 'shows')
        ),
        'public' => true,
        'has_archive' => false,
        'publicly_queryable' => false,
        'query_var' => false,
        'hierarchical' => false,
        'supports' => array(
            'title',
            'thumbnail'
        ),
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            'post_tag',
            'category'
        ) // Add Category and Post Tags support
    ));
}

function show_meta_box_markup($object)
{
    wp_nonce_field(basename(__FILE__), "meta-box-nonce");

    ?>

        <style>
          .slow-jams-custom{
          }
          .slow-jams-custom label{
            display: block;
            width: 100%;
          }
          .slow-jams-custom input{
            display: block;
            max-width: 500px;
            width: 100%;
            padding: 8px 10px;
            max-height: 50px;
            border-radius: 3px;
          }
        </style>

        <div class="slow-jams-custom">
            <label for="show-date">Show date:</label>
            <input name="show-date" type="text" placeholder="Aug 25, 2017" value="<?php echo get_post_meta($object->ID, "show-date", true); ?>">

            <br/>

            <label for="show-venue">Show venue:</label>
            <input name="show-venue" type="text" placeholder="Goodwill Social Club or whatever..." value="<?php echo get_post_meta($object->ID, "show-venue", true); ?>">

            <br />

            <label for="show-city">Show city:</label>
            <input name="show-city" type="text" placeholder="Winnipeg, MB or New York, USA, or whatever..." value="<?php echo get_post_meta($object->ID, "show-city", true); ?>">

            <br />

            <label for="show-link">Show link:</label>
            <input name="show-link" type="text" placeholder="Something like this --> https://slowjams.co" value="<?php echo get_post_meta($object->ID, "show-link", true); ?>">


        </div>
    <?php
}

function add_show_meta_box()
{
    add_meta_box("shows-meta-box", "Show info", "show_meta_box_markup", "shows", "normal", "high", "show_in_rest", null);
}

add_action("add_meta_boxes", "add_show_meta_box");

function save_show_meta_box($post_id, $post, $update)
{
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "shows";
    if($slug != $post->post_type)
        return $post_id;

    $show_date = "";
    $show_venue = "";
    $show_city = "";
    $show_link = "";

    if(isset($_POST["show-date"]))
    {
        $show_date = $_POST["show-date"];
    }
    update_post_meta($post_id, "show-date", $show_date);

    if(isset($_POST["show-venue"]))
    {
        $show_venue = $_POST["show-venue"];
    }
    update_post_meta($post_id, "show-venue", $show_venue);

    if(isset($_POST["show-city"]))
    {
        $show_city = $_POST["show-city"];
    }
    update_post_meta($post_id, "show-city", $show_city);

    if(isset($_POST["show-link"]))
    {
        $show_link = $_POST["show-link"];
    }
    update_post_meta($post_id, "show-link", $show_link);


}

add_action("save_post", "save_show_meta_box", 10, 3);

function remove_shows_field_meta_box()
{
    remove_meta_box("postcustom", "shows", "normal");
}

add_action("do_meta_boxes", "remove_shows_field_meta_box");




// Music Custom Post Type
function create_post_type_music()
{
    register_taxonomy_for_object_type('category', 'music'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'music');
    register_post_type('music', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Music', 'music'),
            'singular_name' => __('Music', 'music'),
            'add_new' => __('Add Music', 'music'),
            'add_new_item' => __('Add New Music', 'music'),
            'edit' => __('Edit', 'music'),
            'edit_item' => __('Edit Music', 'music'),
            'new_item' => __('New Music', 'music'),
            'view' => __('View Music', 'music'),
            'view_item' => __('View Music', 'music'),
            'search_items' => __('Search Music', 'music'),
            'not_found' => __('No Music found', 'music'),
            'not_found_in_trash' => __('No Music found in Trash', 'music')
        ),
        'public' => true,
        'has_archive' => false,
        'publicly_queryable' => false,
        'query_var' => false,
        'hierarchical' => false,
        'supports' => array(
            'title',
            'thumbnail'
        ),
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            'post_tag',
            'category'
        ) // Add Category and Post Tags support
    ));
}


function music_meta_box_markup($object)
{
    wp_nonce_field(basename(__FILE__), "meta-box-nonce");

    ?>

        <style>
          .slow-jams-custom{
          }
          .slow-jams-custom label{
            display: block;
            width: 100%;
          }
          .slow-jams-custom input{
            display: block;
            max-width: 500px;
            width: 100%;
            padding: 8px 10px;
            max-height: 50px;
            border-radius: 3px;
          }
        </style>

        <div class="slow-jams-custom">
            <label for="music-embed">Music embed link:</label>
            <input name="music-embed" type="text" placeholder="https://bandcamp.com/EmbeddedPlayer ..." value="<?php echo get_post_meta($object->ID, "music-embed", true); ?>">

            <br />

            <label for="music-link">Music page link:</label>
            <input name="music-link" type="text" placeholder="http://silencekitwpg.bandcamp.com/album/started-as-a-whisper" value="<?php echo get_post_meta($object->ID, "music-link", true); ?>">
        </div>
    <?php
}

function add_music_meta_box()
{
    add_meta_box("music-meta-box", "Music info", "music_meta_box_markup", "music", "normal", "high", "show_in_rest", null);
}

add_action("add_meta_boxes", "add_music_meta_box");

function save_music_meta_box($post_id, $post, $update)
{
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "music";
    if($slug != $post->post_type)
        return $post_id;

    $music_embed = "";
    $music_link = "";

    if(isset($_POST["music-embed"]))
    {
        $music_embed = $_POST["music-embed"];
    }
    update_post_meta($post_id, "music-embed", $music_embed);

    if(isset($_POST["music-link"]))
    {
        $music_link = $_POST["music-link"];
    }
    update_post_meta($post_id, "music-link", $music_link);

}

add_action("save_post", "save_music_meta_box", 10, 3);

function remove_music_field_meta_box()
{
    remove_meta_box("postcustom", "music", "normal");
}

add_action("do_meta_boxes", "remove_music_field_meta_box");



// Videos Custom Post Type
function create_post_type_videos()
{
    register_taxonomy_for_object_type('category', 'videos'); // Register Taxonomies for Category
    register_taxonomy_for_object_type('post_tag', 'videos');
    register_post_type('videos', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Videos', 'videos'),
            'singular_name' => __('Video', 'videos'),
            'add_new' => __('Add Video', 'videos'),
            'add_new_item' => __('Add New Video', 'videos'),
            'edit' => __('Edit', 'videos'),
            'edit_item' => __('Edit Video', 'videos'),
            'new_item' => __('New Video', 'videos'),
            'view' => __('View Videos', 'videos'),
            'view_item' => __('View Video', 'videos'),
            'search_items' => __('Search Videos', 'videos'),
            'not_found' => __('No Videos found', 'videos'),
            'not_found_in_trash' => __('No Videos found in Trash', 'videos')
        ),
        'public' => true,
        'has_archive' => false,
        'publicly_queryable' => false,
        'query_var' => false,
        'hierarchical' => false,
        'supports' => array(
            'title',
            'thumbnail'
        ),
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            'post_tag',
            'category'
        ) // Add Category and Post Tags support
    ));
}


function videos_meta_box_markup($object)
{
    wp_nonce_field(basename(__FILE__), "meta-box-nonce");

    ?>

        <style>
          .slow-jams-custom{
          }
          .slow-jams-custom label{
            display: block;
            width: 100%;
          }
          .slow-jams-custom input{
            display: block;
            max-width: 500px;
            width: 100%;
            padding: 8px 10px;
            max-height: 50px;
            border-radius: 3px;
          }
        </style>

        <div class="slow-jams-custom">
            <label for="video-embed">Video embed link:</label>
            <input name="video-embed" type="text" placeholder="https://www.youtube.com/embed/fhYYdeAC3BI" value="<?php echo get_post_meta($object->ID, "video-embed", true); ?>">
        </div>
    <?php
}

function add_videos_meta_box()
{
    add_meta_box("videos-meta-box", "Video info", "videos_meta_box_markup", "videos", "normal", "high", "show_in_rest", null);
}

add_action("add_meta_boxes", "add_videos_meta_box");

function save_videos_meta_box($post_id, $post, $update)
{
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "videos";
    if($slug != $post->post_type)
        return $post_id;

    $video_embed = "";

    if(isset($_POST["video-embed"]))
    {
        $video_embed = $_POST["video-embed"];
    }
    update_post_meta($post_id, "video-embed", $video_embed);

}

add_action("save_post", "save_videos_meta_box", 10, 3);

function remove_videos_field_meta_box()
{
    remove_meta_box("postcustom", "videos", "normal");
}

add_action("do_meta_boxes", "remove_videos_field_meta_box");


/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function html5_shortcode_demo($atts, $content = null)
{
    return '<div class="shortcode-demo">' . do_shortcode($content) . '</div>'; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function html5_shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    return '<h2>' . $content . '</h2>';
}


/*-------------------------------------*\
	Nav Walker to strip <li> from wp_nav_menu()
\*------------------------------------*/

class Nav_Footer_Walker extends Walker_Nav_Menu {
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent\n";
	}
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent\n";
	}
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$class_names = $value = '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
		$output .= $indent . '';
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$item_output = $args->before;
		$item_output .= '<a '. $class_names .''. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "\n";
	}
}

?>
