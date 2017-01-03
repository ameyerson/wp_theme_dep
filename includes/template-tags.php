<?php

if ( ! function_exists( 'ameye_excerpt_more' ) && ! is_admin() ) {

	function ameye_excerpt_more( $more ) {

		global $post;
		return '<a class="moretag" href="'. get_permalink($post->ID) . '"> ' .  __( 'Read More', 'ameye-theme' ) . '</a>';

	}
	add_filter( 'excerpt_more', 'ameye_excerpt_more' );
}

/**
 * Post Navigation
 * Previous and next post link
**/

if ( ! function_exists( 'get_ameye_post_navigation' ) && ! is_admin() ) {

	function get_ameye_post_navigation( $args = array() ) {

		$args = wp_parse_args( $args, array(
		        'prev_text'          => '%title',
		        'next_text'          => '%title',
		        'wrapper_class'		 =>  'pager',
		        'screen_reader_text' => __( 'Post navigation', 'ameye-theme' ),
		) );

		$navigation = '';
	    $previous   = get_previous_post_link( '%link', $args['prev_text'] );
	    $next       = get_next_post_link( '%link', $args['next_text'] );

	 
	    // Only add markup if there's somewhere to navigate to.
	    if ( $previous || $next ) {
	        $navigation = '<nav><h2 class="screen-reader-text hidden">'. $args['screen_reader_text'] . '</h2><ul class="' . $args['wrapper_class'] . '">';
	        if ($previous) {
	        	$navigation .= '<li>' . $previous . '</li>';
	        }
	        if ($next) {
	        	$navigation .= '<li>' . $next . '</li>';
	        }
	        $navigation .= '</ul></nav>';
	    }
	 
	    return $navigation;
	}

}
if ( ! function_exists( 'ameye_post_navigation' ) && ! is_admin() ) {

	function ameye_post_navigation( $args = array() ) {

	 	echo get_ameye_post_navigation( $args );

	}
}

/**
 * Post Meta
 * 
**/
if ( ! function_exists( 'ameye_post_meta' ) && ! is_admin() ) {

	function ameye_post_meta( ) {

		$meta_markup = '<div>';
		$meta_markup .= 'by <a href="' . get_author_posts_url( get_the_author_meta( 'ID' )) . '">' . get_the_author() . '</a>'; 
		$meta_markup .= ' on <span class= "date">' . get_the_time('l F d, Y') . '</span><br/>';

		$categories_list = get_the_category_list(', ' );
		$tags_list = get_the_tag_list('', ' ', '');

		if ( $categories_list ) {
			$meta_markup .= __('Posted in', 'ameye-theme') . ': ' . $categories_list;
		}

		if ($categories_list && $tags_list) {
			$meta_markup .= '<span class="hidden-xs"> | </span><br class="visible-xs">';
		}

		if ( $tags_list ) {
			$meta_markup .= __('Tagged with ', 'ameye-theme') . ': ' . $tags_list;
		}
		$meta_markup .= '</div>';

		echo $meta_markup;

	}
}
/**
 * Pagination
 * 
**/




/**
 * Breadcrumbs
 * 
**/

if ( ! function_exists( 'get_ameye_breadcrumbs' ) && ! is_admin() ) {

	function get_ameye_breadcrumbs( $args = array() ) {

		$args = wp_parse_args( $args, array(
		        'breadcrumb_class'	=>  'breadcrumb',
		        'active_class'		=> 	'active',
		        'home_text' 		=> __('Home', 'ameye-theme' ),
		        'category_text' 	=> __('Archives for %s', 'ameye-theme'),
		        'tag_text' 			=> __('Posts tagged %s', 'ameye-theme'),
		        'author_text' 		=> __('Posted by %s', 'ameye-theme'),
		        'search_text' 		=> __('Search results for \'%s\'', 'ameye-theme'),
		        'paged_text' 		=> __('Page %s', 'ameye-theme'),
		        '404_text' 			=> __('Error 404', 'ameye-theme'),
		        'link_structure'	=> '<li><a href="%1$s">%2$s</a></li>',
		        'current_structure'	=> '<li>%s</li>'
		        
		) );

		// Get the query & post information
		global $post;

		// Do not display on the homepage
		if ( !is_front_page() ) {

			// Build the breadcrumbs
			$markup = '<ol class="' . $args['breadcrumb_class'] . '">';

			//Home page
			$markup .= '<li><a href="' . get_home_url() . '">' . $args['home_text'] . '</a></li>';

			//category archive
			if ( is_category() ) {

				$cat = get_queried_object();

				if ($cat->parent != 0) {
					$parent_cats = get_category_parents($cat->parent, TRUE, '');
					$parent_cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', '<li><a$1>$2</a></li>', $parent_cats);
					$markup .= $parent_cats;
				}
				if ( get_query_var('paged') ) {
					$markup .= sprintf($args['link_structure'], get_category_link($cat->term_id), $cat->name) . sprintf($args['current_structure'], sprintf($args['paged_text'], get_query_var('paged')));
				} else {
					$markup .= sprintf($args['current_structure'], sprintf($args['category_text'], single_cat_title('', false)));
				}
			//tag archives
			} else if ( is_tag() ) {
				$tag = get_queried_object();

				if ( get_query_var('paged') ) {
					$markup .= sprintf($args['link_structure'], get_tag_link($tag->term_id), $tag->name) . sprintf($args['current_structure'], sprintf($args['paged_text'], get_query_var('paged')));
				} else {
					$markup .= sprintf($args['current_structure'], sprintf($args['tag_text'], $tag->name));
				}
			//author
			} elseif ( is_author() ) {
				$author = get_queried_object();
				if ( get_query_var('paged') ) {
					$markup .= sprintf($args['link_structure'], get_author_posts_url($author->ID), $author->user_nicename) . sprintf($args['current_structure'], sprintf($args['paged_text'], get_query_var('paged')));
				} else {
					$markup .= sprintf($args['current_structure'], sprintf($args['author_text'], $author->user_nicename));
				}
			//404
			} elseif ( is_404() ) {
				$markup .= sprintf($args['current_structure'], $args['404_text']);
			//search
			} else if ( is_search() ) {
				$markup .= sprintf($args['current_structure'], sprintf($args['search_text'], get_search_query()));
			//dates
			} else if ( is_day() ) {
				$markup .= sprintf($args['link_structure'], get_year_link(get_the_time('Y')), get_the_time('Y'));
				$markup .= sprintf($args['link_structure'], get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F'));
				$markup .= sprintf($args['current_structure'], get_the_time('d'));
			} else if ( is_month() ) {
				$markup .= sprintf($args['link_structure'], get_year_link(get_the_time('Y')), get_the_time('Y'));
				$markup .= sprintf($args['current_structure'], get_the_time('F'));
			} else if ( is_year() ) {
				$markup .= sprintf($args['current_structure'], get_the_time('Y'));
			//single
			} else if ( is_single() && !is_attachment() ) {

				if ( get_post_type() != 'post' ) {
					//custom post type single
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					$markup .= sprintf($args['link_structure'], home_url('/'). $slug['slug'] . '/', $post_type->label);
					$markup .= sprintf($args['current_structure'], get_the_title());

				} else {
					//single post
					if ( get_option( 'show_on_front' ) == 'page' ) {
						if (get_option('page_for_posts' )) {
							$markup .= sprintf($args['link_structure'],get_permalink( get_option('page_for_posts' )), get_the_title(get_option('page_for_posts' )));
						}
					}

					$markup .= sprintf($args['current_structure'], get_the_title());
				}
			} else if ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
				//custom post type archive
				$post_type = get_post_type_object(get_post_type());
				if ( get_query_var('paged') ) {
					$markup .= sprintf($args['link_structure'], get_post_type_archive_link($post_type->name), $post_type->label) . sprintf($args['current_structure'], sprintf($args['paged_text'], get_query_var('paged')));
				} else {
					$markup .= sprintf($args['current_structure'], $post_type->label);
				}
			//index page
			}  else if (is_home()) {
				if ( get_query_var('paged') ) {
					$markup .= sprintf($args['link_structure'],get_permalink( get_option('page_for_posts' )), get_the_title(get_option('page_for_posts' ))) . sprintf($args['current_structure'], sprintf($args['paged_text'], get_query_var('paged')));
				} else {
					$markup .= sprintf($args['current_structure'], get_the_title(get_option('page_for_posts' )));
				}
			} else if ( is_page() && !($post->post_parent) ) {
				$markup .= sprintf($args['current_structure'], get_the_title());

			} else if ( is_page() && $post->post_parent ) {

				if ($parent_id != get_option('page_on_front')) {

					$breadcrumbs = array();
					$parent_id = $post->post_parent;
					while ($parent_id) {
						$page = get_page($parent_id);
						if ($parent_id != get_option('page_on_front')) {
							$breadcrumbs[] = sprintf($args['link_structure'], get_permalink($page->ID), get_the_title($page->ID));
						}
						$parent_id = $page->post_parent;
					}
					$breadcrumbs = array_reverse($breadcrumbs);
					for ($i = 0; $i < count($breadcrumbs); $i++) {
						$markup .= $breadcrumbs[$i];
					}
				}

				$markup .= sprintf($args['current_structure'], get_the_title());

			}	

			$markup .= '</ol>';
			return $markup;
		}
	}

}

if ( ! function_exists( 'ameye_breadcrumbs' ) && ! is_admin() ) {

	function ameye_breadcrumbs( $args = array() ) {

	 	echo get_ameye_breadcrumbs( $args );

	}
}
