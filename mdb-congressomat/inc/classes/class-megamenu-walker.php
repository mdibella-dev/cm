<?php
/**
 * ....
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/



class MegaMenu_Walker extends Walker_Nav_Menu
{

    public function start_lvl( &$output, $depth = 0, $args = array() )
    {
        if( $depth == 0 ) :
            $output .= '<div class="megamenu-wrapper"><ul class="megamenu-content">';
        else :
            $output .= '<ul>';
        endif;
    }

    public function end_lvl( &$output, $depth = 0, $args = array() )
    {
        if( $depth == 0 ) :
            $output .= '</ul></div>';
        else :
            $output .= '</ul>';
        endif;
    }

    public function start_el( &$output, $item, $depth = 0, $args = array(), $current_object_id = 0 )
    {
        $title   = apply_filters( 'the_title', $item->title, $item->ID );
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $output .= '<li'.$class_names .'>';

        switch( $classes[0] ):
            case 'header':
                $output .= '<h4>' . $title . '</h4>';
            break;

            default:
                // Attribute generieren/filtern
                $atts = array();
        		$atts['title']  = !empty( $item->attr_title ) ? $item->attr_title : '';
        		$atts['target'] = !empty( $item->target )     ? $item->target     : '';
        		$atts['rel']    = !empty( $item->xfn )        ? $item->xfn        : '';
        		$atts['href']   = !empty( $item->url )        ? $item->url        : '';
                $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

                $attributes = '';
        		foreach( $atts as $attr => $value ) :
        			if( !empty( $value ) ) :
        				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
        				$attributes .= ' ' . $attr . '="' . $value . '"';
        			endif;
        		endforeach;

                // Link aufbauen
                $item_output  = $args->before;
        		$item_output .= '<a'. $attributes .'>';
        		$item_output .= $args->link_before . $title . $args->link_after;
        		$item_output .= '</a>';
        		$item_output .= $args->after;

                $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
            break;
        endswitch;
    }

    public function end_el( &$output, $item, $depth = 0, $args = array() )
    {
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        switch( $classes[0] ):
            case 'header':
                $output .= '</li>';
            break;

            default;
                $output .= '</li>';
            break;
        endswitch;
    }
}
