<?php
if (!defined('ABSPATH'))
    die('No direct access allowed');

//24-04-2017
final class WOOF_EXT_BY_TEXT extends WOOF_EXT {

    public $type = 'by_html_type';
    public $html_type = 'by_text'; //your custom key here
    public $index = 'woof_text';
    public $html_type_dynamic_recount_behavior = 'none';

    public function __construct() {
	parent::__construct();
	$this->init();
    }

    public function get_ext_path() {
	return plugin_dir_path(__FILE__);
    }

    public function get_ext_link() {
	return plugin_dir_url(__FILE__);
    }

    public function woof_add_items_keys($keys) {
	$keys[] = $this->html_type;
	return $keys;
    }

    public function init() {
	add_filter('woof_add_items_keys', array($this, 'woof_add_items_keys'));
	add_filter('woof_get_request_data', array($this, 'woof_get_request_data'));
	add_action('woof_print_html_type_options_' . $this->html_type, array($this, 'woof_print_html_type_options'), 10, 1);
	add_action('woof_print_html_type_' . $this->html_type, array($this, 'print_html_type'), 10, 1);
	add_action('wp_head', array($this, 'wp_head'), 999);

	add_action('wp_ajax_woof_text_autocomplete', array($this, 'woof_text_autocomplete'));
	add_action('wp_ajax_nopriv_woof_text_autocomplete', array($this, 'woof_text_autocomplete'));

	self::$includes['js']['woof_' . $this->html_type . '_html_items'] = $this->get_ext_link() . 'js/' . $this->html_type . '.js';
	self::$includes['css']['woof_' . $this->html_type . '_html_items'] = $this->get_ext_link() . 'css/' . $this->html_type . '.css';
	self::$includes['js_init_functions'][$this->html_type] = 'woof_init_text'; //we have no init function in this case
	//***
	add_shortcode('woof_text_filter', array($this, 'woof_text_filter'));
    }

    public function woof_get_request_data($request) {
	if (isset($request['s'])) {
	    $request['woof_text'] = $request['s'];
	    //unset($request['s']);
	}

	return $request;
    }

    public function wp_head() {
	global $WOOF;
	//***
	//var_dump($WOOF->settings['by_text']);
	if (isset($WOOF->settings['by_text']['autocomplete']) AND $WOOF->settings['by_text']['autocomplete']) {
	    wp_enqueue_script('easy-autocomplete', WOOF_LINK . 'js/easy-autocomplete/jquery.easy-autocomplete.min.js', array('jquery'));
	    wp_enqueue_style('easy-autocomplete', WOOF_LINK . 'js/easy-autocomplete/easy-autocomplete.min.css');
	    wp_enqueue_style('easy-autocomplete-theme', WOOF_LINK . 'js/easy-autocomplete/easy-autocomplete.themes.min.css');
	}
	?>
	<style type="text/css">
	<?php
	if (isset($WOOF->settings['by_text']['image'])) {
	    if (!empty($WOOF->settings['by_text']['image'])) {
		?>
		    .woof_text_search_container .woof_text_search_go{
			background: url(<?php echo $WOOF->settings['by_text']['image'] ?>) !important;
		    }
		<?php
	    }
	}
	?>
	</style>
	<script type="text/javascript">
	    if (typeof woof_lang_custom == 'undefined') {
		var woof_lang_custom = {};//!!important
	    }
	     <?php $text_bytext = $_REQUEST['s']; ?>
	    woof_lang_custom.<?php echo $this->index ?> = "<?php _e($text_bytext, 'woocommerce-products-filter') ?>";
	   // woof_lang_custom.<?php echo $this->index ?> = "<?php _e('By text', 'woocommerce-products-filter') ?>";

	    var woof_text_autocomplete = 0;
	    var woof_text_autocomplete_items = 10;
	<?php if (isset($WOOF->settings['by_text']['autocomplete'])): ?>
	        woof_text_autocomplete =<?php echo (int) $WOOF->settings['by_text']['autocomplete']; ?>;
	        woof_text_autocomplete_items =<?php echo apply_filters('woof_text_autocomplete_items', 10) ?>;
	<?php endif; ?>

	    var woof_post_links_in_autocomplete = 0;
	<?php if (isset($WOOF->settings['by_text']['post_links_in_autocomplete'])): ?>
	        woof_post_links_in_autocomplete =<?php echo (int) $WOOF->settings['by_text']['post_links_in_autocomplete']; ?>;
	<?php endif; ?>

	    var how_to_open_links = 0;
	<?php if (isset($WOOF->settings['by_text']['how_to_open_links'])): ?>
	        how_to_open_links =<?php echo (int) $WOOF->settings['by_text']['how_to_open_links']; ?>;
	<?php endif; ?>

	</script>
	<?php
    }

    //shortcode
    public function woof_text_filter($args = array()) {
	global $WOOF;
	$args['loader_img'] = $this->get_ext_link() . 'img/loader.gif';
	return $WOOF->render_html($this->get_ext_path() . 'views' . DIRECTORY_SEPARATOR . 'shortcodes' . DIRECTORY_SEPARATOR . 'woof_text_filter.php', $args);
    }

    //settings page hook
    public function woof_print_html_type_options() {
	global $WOOF;
	echo $WOOF->render_html($this->get_ext_path() . 'views' . DIRECTORY_SEPARATOR . 'options.php', array(
	    'key' => $this->html_type,
	    "woof_settings" => get_option('woof_settings', array())
		)
	);
    }

    public function assemble_query_params(&$meta_query, $wp_query = NULL) {
	add_filter('posts_where', array($this, 'woof_post_text_filter'), 9999); //for searching by text
	return $meta_query;
    }

    public function woof_post_text_filter($where = '') {
	global $wp_query;
	global $WOOF;
	$request = $WOOF->get_request_data();

	//***
     /* Code to search by attributes */
	 if (isset($request['s']))
        {
            //uncomment it for cyrillic text search
            //return $where;
            $terms = get_terms( array(
                'taxonomy' => 'pa_modality',
                'hide_empty' => false,
                'search' => $request['s']
            ) ); 
            //echo '<pre>';print_r($terms);echo '</pre>';
            $mod = array();
            foreach ($terms as $value) {
                $mod[] = $value->term_id;
            }       

            $terms_author = get_terms( array(
                'taxonomy' => 'pa_authors_name',
                'hide_empty' => false,
                'search' => $request['s']
            ) ); 
           // echo '<pre>';print_r($terms_author);echo '</pre>';
            foreach ($terms_author as $value) {
                $mod[] = $value->term_id;
            }

            $terms_topic = get_terms( array(
                'taxonomy' => 'pa_topic_list',
                'hide_empty' => false,
                'search' => $request['s']
            ) ); 
            //echo '<pre>';print_r($terms_topic);echo '</pre>';
          
            foreach ($terms_topic as $value) {
                $mod[] = $value->term_id;
            }
             $mod = implode(",",$mod);
                # code...
            
        }
        /* Code to search by attributes */
	//***      


	if (defined('DOING_AJAX')) {
	    $conditions = (isset($wp_query->query_vars['post_type']) AND $wp_query->query_vars['post_type'] == 'product') OR isset($_REQUEST['woof_products_doing']);
	} else {
	    $conditions = isset($_REQUEST['woof_products_doing']);
	}
	//***
	//if ($conditions)
	{
	    if ($WOOF->is_isset_in_request_data('woof_text')) {
		$woof_text = wp_specialchars_decode(trim(urldecode($request['woof_text'])));
		$woof_text = trim(WOOF_HELPER::strtolower($woof_text));
		$woof_text = preg_replace('/\s+/', ' ', $woof_text);
		$woof_text = preg_quote($woof_text, '&');
		$woof_text = str_replace(' ', '?(.*)', $woof_text);
		//http://dev.mysql.com/doc/refman/5.7/en/regexp.html
		//***

		$search_by_full_word = false;

		if (isset($WOOF->settings['by_text']['search_by_full_word'])) {
		    $search_by_full_word = (int) $WOOF->settings['by_text']['search_by_full_word'];
		}

		if ($search_by_full_word) {
		    $woof_text = '[[:<:]]' . $woof_text . '[[:>:]]';
		}

		//***

		$behavior = 'title';
		if (isset($WOOF->settings['by_text']['behavior'])) {
		    $behavior = $WOOF->settings['by_text']['behavior'];
		}

		if (isset($_REQUEST['auto_search_by_behavior']) AND ! empty($_REQUEST['auto_search_by_behavior'])) {
		    $behavior = $_REQUEST['auto_search_by_behavior'];
		}

		$text_where = "";
		//***
		switch ($behavior) {
		    case 'content':
			$text_where .= " LOWER(post_content) REGEXP '{$woof_text}'";
			break;

		    case 'title_or_content':
			$text_where .= " ( LOWER(post_title) REGEXP '{$woof_text}' OR LOWER(post_content) REGEXP '{$woof_text}')";
			if(!empty($mod)){
                $text_where.= " OR (trel.term_taxonomy_id IN ($mod) AND hp_posts.post_status = 'publish') ";
            }
			break;

		    case 'title_and_content':
			$text_where .= " ( LOWER(post_title) REGEXP '{$woof_text}' AND LOWER(post_content) REGEXP '{$woof_text}')";
			break;

		    case 'excerpt':
			$text_where .= " LOWER(post_excerpt) REGEXP '{$woof_text}'";
			break;

		    case 'content_or_excerpt':
			$text_where .= " ( LOWER(post_excerpt) REGEXP '{$woof_text}' OR LOWER(post_content) REGEXP '{$woof_text}')";
			break;

		    case 'title_or_content_or_excerpt':
			$text_where .= "  (( LOWER(post_title) REGEXP '{$woof_text}') OR ( LOWER(post_excerpt) REGEXP '{$woof_text}') OR ( LOWER(post_content) REGEXP '{$woof_text}'))";
			break;

		    default:
			//only by title
			$text_where .= "  LOWER(post_title) REGEXP '{$woof_text}'";
			break;
		}
		//by SKU  *******************
		global $wpdb;
		$sku_where = "";
		if ($WOOF->settings['by_text']['sku_compatibility']) {
		    //***
		}
		//by SKU  *******************

		$where .= " AND ( " . $text_where . $sku_where . " )";
	    }
	}
	//***
	return $where;
    }

    //ajax
    public function woof_text_autocomplete() {
	$results = array();
	$args = array(
	    'nopaging' => true,
	    //'fields' => 'ids',
	    'post_type' => 'product',
	    'post_status' => array('publish'),
	    'orderby' => 'title',
	    'order' => 'ASC',
	    'max_num_pages' => intval($_REQUEST['auto_res_count']) > 0 ? intval($_REQUEST['auto_res_count']) : apply_filters('woof_text_autocomplete_items', 10)
	);

	if (class_exists('SitePress')) {
	    $args['lang'] = ICL_LANGUAGE_CODE;
	}

	//***

	$_GET['woof_text'] = $_REQUEST['phrase'];
	if (!empty($_REQUEST['auto_search_by'])) {
	    $_REQUEST['auto_search_by_behavior'] = $_REQUEST['auto_search_by'];
	}
	add_filter('posts_where', array($this, 'woof_post_text_filter'), 10);
	$query = new WP_Query($args);
	//+++
	//http://easyautocomplete.com/guide
	if ($query->have_posts()) {
	    include_once WOOF_PATH . 'lib' . DIRECTORY_SEPARATOR . 'aq_resizer.php';
	    $tmp = array();
	    foreach ($query->posts as $p) {
		if (!in_array($p->post_title, $tmp)) {
		    $tmp[] = $p->post_title;
		    $data = array(
			"name" => $p->post_title,
			"type" => "product"
		    );
		    if (has_post_thumbnail($p->ID)) {
			$img_src = wp_get_attachment_image_src(get_post_thumbnail_id($p->ID), 'single-post-thumbnail');
			$data['icon'] = woof_aq_resize($img_src[0], 100, 100, true);
		    } else {
			$data['icon'] = WOOF_LINK . 'img/not-found.jpg';
		    }
		    $data['link'] = get_post_permalink($p->ID);
		    $results[] = $data;
		}
	    }
	} else {
	    $results[] = array(
		"name" => __("Products not found!", 'woocommerce-products-filter'),
		"type" => "",
		"link" => "#",
		"icon" => WOOF_LINK . 'img/not-found.jpg'
	    );
	}

	die(json_encode($results));
    }

}

WOOF_EXT::$includes['html_type_objects']['by_text'] = new WOOF_EXT_BY_TEXT();
