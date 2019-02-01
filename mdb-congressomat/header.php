<?php
/**
 * Template für den Kopfbereich einer Seite
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package mdb-congressomat
 **/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<title><?php wp_title( '', true ); ?></title>
<meta charset="<?php bloginfo( 'charset' ); ?>"/>
<meta name="author" content="<?php echo get_the_author_meta( 'display_name', $post->post_author ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="geo.region" content="DE-NW" />
<meta name="geo.placename" content="K&ouml;ln" />
<meta name="geo.position" content="50.957827;7.017787"/>
<meta name="ICBM" content="50.957827, 7.017787" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header id="header">
<div id="header-wrapper">
<div>
<button id="logo" type="button">
<svg viewBox="0 0 397.05 62.99"><defs><style>.a{fill:#cc1517;}.b{fill:none;}.c{fill:#b2b2b2;}</style></defs><path class="a" d="M55.09,67.76V66.15c2.7,0,4.54-.35,5.53-1.07,1.36-1,2.05-2.95,2.05-5.82V20.42c0-2.88-.69-4.82-2.05-5.82q-1.48-1.06-5.53-1.07V11.92H77.93v1.61c-2.72,0-4.58.36-5.57,1.06-1.34,1-2,2.92-2,5.81V37.3H95V20.4q0-4.29-2-5.81c-1-.7-2.84-1.06-5.53-1.06V11.92h22.84v1.61c-2.73,0-4.58.36-5.58,1.07q-2,1.46-2,5.82V59.26c0,2.91.67,4.84,2,5.82,1,.72,2.85,1.07,5.58,1.07v1.61H87.4V66.15c2.69,0,4.54-.35,5.53-1.06q2-1.52,2-5.82V40.64H70.36V59.27c0,2.9.66,4.84,2,5.82q1.48,1.06,5.57,1.06v1.61Z" transform="translate(-12.41 -11.05)"/><path class="a" d="M157.79,62.7v3.59a47.92,47.92,0,0,1-15.53,2.21q-12.58,0-19.35-8.56-6.3-8.07-6.3-22,0-12.73,4.91-19.26,5.74-7.62,18.83-7.63A65.11,65.11,0,0,1,157,13.41l.81,13.24h-2.25Q152.63,14.4,140.23,14.4q-15.1,0-15.1,23,0,27.4,21.43,27.41a32.45,32.45,0,0,0,11.23-2.09" transform="translate(-12.41 -11.05)"/><path class="b" d="M33.7,34.45c-1.5-.15-3,2.81-3.21,4a5.44,5.44,0,0,0,1.93,4.82,17.66,17.66,0,0,0,1.7,1.41V34.57A1.5,1.5,0,0,0,33.7,34.45Z" transform="translate(-12.41 -11.05)"/><path class="b" d="M43.09,41c-.28-.26-.57-.5-.87-.74v9.19C45.62,47.56,46.11,43.88,43.09,41Z" transform="translate(-12.41 -11.05)"/><path class="b" d="M43,57a5.47,5.47,0,0,0-.85-1.39,49.32,49.32,0,0,1-.5,6C43.14,60.75,44,59.31,43,57Z" transform="translate(-12.41 -11.05)"/><path class="b" d="M33.23,27.56a4.53,4.53,0,0,0,.89,1.57v-5A3.24,3.24,0,0,0,33.23,27.56Z" transform="translate(-12.41 -11.05)"/><path class="a" d="M42.45,18.26a5.64,5.64,0,0,1,1.62-3.43q1.4-1.17,5.18-1.17V12H27.09v1.68q3.73,0,5.13,1.17a6.18,6.18,0,0,1,1.75,4A11.54,11.54,0,0,1,42.45,18.26Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M28.48,60.56c-.63.83,2.58,3.75,3,4.08a9,9,0,0,0,1.66.92,27.52,27.52,0,0,0,.6-3.76C31.69,61,28.9,60,28.48,60.56Z" transform="translate(-12.41 -11.05)"/><path class="a" d="M34.12,50.12v3.27q0,5-.35,8.41a27.52,27.52,0,0,1-.6,3.76,13.16,13.16,0,0,1-.48,1.55q-1.44,3.42-5.82,3.42-2.73,0-4.7-3.83c-1.32-2.54-3.08-3.82-5.28-3.82q-4.48,0-4.48,3.86,0,3.49,4.16,5.55A20,20,0,0,0,25.28,74q11.13,0,14.8-6.92c.13-.26.25-.55.38-.84a20.61,20.61,0,0,0,1.23-4.68,49.32,49.32,0,0,0,.5-6C40.31,53.29,36.57,51.55,34.12,50.12Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M44.07,51.41c4.21-2,7.34-6.37,4.45-11.28-1.42-2.4-3.84-4.06-6.3-5.53v5.7c.3.24.59.48.87.74,3,2.84,2.53,6.52-.87,8.45l-.31.18c-2.48-1.75-5.33-3.1-7.79-4.94a17.66,17.66,0,0,1-1.7-1.41,5.44,5.44,0,0,1-1.93-4.82c.18-1.24,1.71-4.2,3.21-4a1.5,1.5,0,0,1,.42.12V29.13a4.53,4.53,0,0,1-.89-1.57,3.24,3.24,0,0,1,.89-3.42,5.34,5.34,0,0,1,2.16-1.23,10.92,10.92,0,0,1,5.94.19c.47.13.93.27,1.37.43s.91.52,1.26.51c.64,0,.95-.51,1.5-.45s1.33,1,1.61,1.13c-.82-1,.54-.37.61-.69a4.5,4.5,0,0,1-2.24-.85c2.26-2.62-1.6-4.14-3.48-4.8l-.4-.12a11.54,11.54,0,0,0-8.48.57,2,2,0,0,0-.22.09c-5.69,2.68-7.33,9.36-2.2,13.79-3.55,1.66-6.26,4.63-5.31,9.08.83,3.86,4.09,5.91,7,7.81.26.17.55.35.86.52,2.45,1.43,6.19,3.17,8.07,5.5A5.47,5.47,0,0,1,43,57c.94,2.3.1,3.74-1.35,4.59a20.61,20.61,0,0,1-1.23,4.68,8.85,8.85,0,0,0,6.81-4.75A8.09,8.09,0,0,0,44.07,51.41Z" transform="translate(-12.41 -11.05)"/><path class="a" d="M42.22,34.6V23.1a10.92,10.92,0,0,0-5.94-.19,5.34,5.34,0,0,0-2.16,1.23v5h0v5.43h0V44.73c2.46,1.84,5.31,3.19,7.79,4.94l.31-.18V40.3h0V34.59Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M188.16,18.91A5.83,5.83,0,0,1,186,23.78a9.77,9.77,0,0,1-6.1,1.69h-2.38v8.05H174.9V12.82h5.48Q188.15,12.82,188.16,18.91Zm-10.65,4.32h2.08a7.73,7.73,0,0,0,4.47-1A3.66,3.66,0,0,0,185.45,19a3.52,3.52,0,0,0-1.29-3,6.6,6.6,0,0,0-4-1h-2.63Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M199.26,20h-3.93V33.52h-2.54V20h-2.72V18.77l2.72-.88V17A6.34,6.34,0,0,1,194,12.75a4.83,4.83,0,0,1,3.82-1.42,9.29,9.29,0,0,1,3,.53l-.68,2a7.51,7.51,0,0,0-2.31-.43,2.19,2.19,0,0,0-1.91.85,4.56,4.56,0,0,0-.63,2.69v1h3.93Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M204.62,33.52h-2.55v-22h2.55Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M216.16,33.81a7.15,7.15,0,0,1-5.48-2.12,8.15,8.15,0,0,1-2-5.83,9,9,0,0,1,1.85-5.95,6.2,6.2,0,0,1,5-2.22,6,6,0,0,1,4.67,1.89A7.27,7.27,0,0,1,222,24.7v1.55H211.32a6,6,0,0,0,1.35,4,4.7,4.7,0,0,0,3.61,1.37,11.9,11.9,0,0,0,2.36-.22,13.3,13.3,0,0,0,2.62-.85V32.8a12.06,12.06,0,0,1-2.42.78A13.94,13.94,0,0,1,216.16,33.81Zm-.63-14A3.72,3.72,0,0,0,212.64,21a5.47,5.47,0,0,0-1.26,3.27h7.91a5,5,0,0,0-1-3.31A3.43,3.43,0,0,0,215.53,19.77Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M236.29,33.38l.08-1.91h-.11a5.41,5.41,0,0,1-4.82,2.34,5.7,5.7,0,0,1-4.71-2.11A9.25,9.25,0,0,1,225,25.78a9.31,9.31,0,0,1,1.71-5.92,5.6,5.6,0,0,1,4.66-2.17A5.71,5.71,0,0,1,236.29,20h.15l.34-2.06h2v15.8a6.82,6.82,0,0,1-1.7,5c-1.12,1.12-2.88,1.68-5.26,1.68a13.65,13.65,0,0,1-5.59-1V37.15A12.05,12.05,0,0,0,232,38.37a4.23,4.23,0,0,0,3.13-1.16A4.38,4.38,0,0,0,236.29,34Zm-4.46-1.65a4.27,4.27,0,0,0,3.42-1.27,6.3,6.3,0,0,0,1.06-4.07v-.61a7.52,7.52,0,0,0-1.07-4.53,4.08,4.08,0,0,0-3.47-1.42,3.46,3.46,0,0,0-3,1.55,7.71,7.71,0,0,0-1.07,4.43,7.71,7.71,0,0,0,1,4.4A3.52,3.52,0,0,0,231.83,31.73Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M250.36,33.81a7.19,7.19,0,0,1-5.49-2.12,8.19,8.19,0,0,1-2-5.83,9,9,0,0,1,1.86-5.95,6.2,6.2,0,0,1,5-2.22,6,6,0,0,1,4.67,1.89,7.23,7.23,0,0,1,1.75,5.12v1.55H245.52a6,6,0,0,0,1.34,4,4.71,4.71,0,0,0,3.61,1.37,12.07,12.07,0,0,0,2.37-.22,13.51,13.51,0,0,0,2.62-.85V32.8a12.27,12.27,0,0,1-2.42.78A13.94,13.94,0,0,1,250.36,33.81Zm-.64-14A3.73,3.73,0,0,0,246.83,21a5.6,5.6,0,0,0-1.26,3.27h7.92a5,5,0,0,0-1-3.31A3.43,3.43,0,0,0,249.72,19.77Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M267.27,20h-3.92V33.52H260.8V20h-2.72V18.77l2.72-.88V17A6.29,6.29,0,0,1,262,12.75a4.8,4.8,0,0,1,3.81-1.42,9.29,9.29,0,0,1,3,.53l-.68,2a7.51,7.51,0,0,0-2.31-.43,2.19,2.19,0,0,0-1.91.85,4.56,4.56,0,0,0-.62,2.69v1h3.92Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M283.6,25.72a8.6,8.6,0,0,1-1.93,6,6.81,6.81,0,0,1-5.32,2.14,7,7,0,0,1-3.74-1A6.4,6.4,0,0,1,270.1,30a9.77,9.77,0,0,1-.88-4.28,8.52,8.52,0,0,1,1.9-5.91,6.78,6.78,0,0,1,5.32-2.12,6.66,6.66,0,0,1,5.22,2.16A8.48,8.48,0,0,1,283.6,25.72Zm-11.74,0A7.3,7.3,0,0,0,273,30.18a4.55,4.55,0,0,0,6.79,0A7.3,7.3,0,0,0,281,25.72a7,7,0,0,0-1.17-4.41,4.12,4.12,0,0,0-3.42-1.48Q271.86,19.83,271.86,25.72Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M294.88,17.69a9,9,0,0,1,1.83.17l-.31,2.35a7.68,7.68,0,0,0-1.69-.19,4.12,4.12,0,0,0-2.29.68,4.63,4.63,0,0,0-1.65,1.87,6,6,0,0,0-.59,2.66v8.29h-2.55V18h2.1l.28,2.84h.11a6.69,6.69,0,0,1,2.11-2.33A4.76,4.76,0,0,1,294.88,17.69Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M304.81,31.73a9.08,9.08,0,0,0,1.16-.1,5,5,0,0,0,1-.23v2a5.18,5.18,0,0,1-1.09.31,7.66,7.66,0,0,1-1.51.15q-4.56,0-4.56-4.8V20h-2.2V18.74l2.23-1,1-3.31h1.51V18h4.49v2h-4.49v9A3,3,0,0,0,303,31,2.23,2.23,0,0,0,304.81,31.73Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M317.44,17.72a5.68,5.68,0,0,1,4.74,2.12,9.28,9.28,0,0,1,1.67,5.91,9.19,9.19,0,0,1-1.7,5.95,5.7,5.7,0,0,1-4.71,2.11,6.65,6.65,0,0,1-2.81-.57,5,5,0,0,1-2-1.68h-.19c-.3,1.13-.47,1.78-.53,2h-1.83v-22h2.55v5.35c0,1.07,0,2.14-.14,3.2h.14A5.44,5.44,0,0,1,317.44,17.72ZM317,19.83a4,4,0,0,0-3.37,1.33,7.58,7.58,0,0,0-1,4.5v.12a7.68,7.68,0,0,0,1,4.55,4,4,0,0,0,3.41,1.37,3.48,3.48,0,0,0,3.12-1.54,7.92,7.92,0,0,0,1-4.44,7.82,7.82,0,0,0-1-4.42A3.62,3.62,0,0,0,317,19.83Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M327.72,13.77a1.54,1.54,0,0,1,.43-1.23,1.51,1.51,0,0,1,2.56,1.23,1.54,1.54,0,0,1-.45,1.23,1.59,1.59,0,0,1-2.11,0A1.57,1.57,0,0,1,327.72,13.77Zm2.75,19.75h-2.55V18h2.55Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M337.94,33.52h-2.55v-22h2.55Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M348.38,33.81a5.66,5.66,0,0,1-4.7-2.1A9.26,9.26,0,0,1,342,25.78a9.42,9.42,0,0,1,1.67-6,5.69,5.69,0,0,1,4.73-2.14,5.61,5.61,0,0,1,4.81,2.3h.18c0-.19-.06-.57-.11-1.14s-.07-1-.07-1.16v-6.2h2.55v22h-2l-.39-2.08h-.11A5.48,5.48,0,0,1,348.38,33.81Zm.41-2.11a4.17,4.17,0,0,0,3.39-1.27,6.45,6.45,0,0,0,1.07-4.16v-.46c0-2.16-.36-3.71-1.08-4.63a4.08,4.08,0,0,0-3.41-1.38,3.48,3.48,0,0,0-3,1.57,7.8,7.8,0,0,0-1.08,4.46,7.49,7.49,0,0,0,1.07,4.38A3.56,3.56,0,0,0,348.79,31.7Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M363.12,18V28a4,4,0,0,0,.84,2.79,3.38,3.38,0,0,0,2.61.92,4.28,4.28,0,0,0,3.49-1.33,6.82,6.82,0,0,0,1.09-4.29V18h2.56V33.52h-2.1l-.36-2.05h-.13a4.56,4.56,0,0,1-2,1.73,6.89,6.89,0,0,1-3,.61A5.94,5.94,0,0,1,362,32.46a5.71,5.71,0,0,1-1.42-4.3V18Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M389.23,33.52V23.58a4.1,4.1,0,0,0-.84-2.82,3.42,3.42,0,0,0-2.64-.93,4.22,4.22,0,0,0-3.48,1.33,6.83,6.83,0,0,0-1.08,4.31v8.05h-2.55V18h2.05l.38,2.12h.14a4.89,4.89,0,0,1,2-1.78,6.52,6.52,0,0,1,2.87-.63,5.8,5.8,0,0,1,4.25,1.39,5.89,5.89,0,0,1,1.39,4.32V33.52Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M406.94,33.38l.09-1.91h-.12a5.38,5.38,0,0,1-4.81,2.34,5.7,5.7,0,0,1-4.71-2.11,9.19,9.19,0,0,1-1.69-5.92,9.31,9.31,0,0,1,1.71-5.92,5.59,5.59,0,0,1,4.66-2.17A5.68,5.68,0,0,1,406.94,20h.16l.34-2.06h2v15.8a6.81,6.81,0,0,1-1.69,5q-1.69,1.68-5.26,1.68a13.65,13.65,0,0,1-5.59-1V37.15a12,12,0,0,0,5.73,1.22,4.25,4.25,0,0,0,3.14-1.16A4.38,4.38,0,0,0,406.94,34Zm-4.46-1.65a4.24,4.24,0,0,0,3.42-1.27A6.24,6.24,0,0,0,407,26.39v-.61a7.59,7.59,0,0,0-1.07-4.53,4.08,4.08,0,0,0-3.47-1.42,3.48,3.48,0,0,0-3,1.55,7.79,7.79,0,0,0-1.07,4.43,7.79,7.79,0,0,0,1,4.4A3.53,3.53,0,0,0,402.48,31.73Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M180.06,68.61a5.69,5.69,0,0,1-4.71-2.1,9.32,9.32,0,0,1-1.67-5.93,9.42,9.42,0,0,1,1.68-5.95,6.24,6.24,0,0,1,9.54.16h.18c0-.19-.06-.57-.11-1.14s-.07-1-.07-1.16v-6.2h2.55v22h-2.06L185,66.24h-.11A5.49,5.49,0,0,1,180.06,68.61Zm.41-2.11a4.19,4.19,0,0,0,3.39-1.27,6.45,6.45,0,0,0,1.07-4.16v-.46c0-2.16-.36-3.71-1.09-4.63a4,4,0,0,0-3.4-1.38,3.51,3.51,0,0,0-3.05,1.57,7.89,7.89,0,0,0-1.07,4.47A7.4,7.4,0,0,0,177.39,65,3.56,3.56,0,0,0,180.47,66.5Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M199,68.61a7.15,7.15,0,0,1-5.48-2.12,8.15,8.15,0,0,1-2-5.83,9,9,0,0,1,1.85-5.95,6.2,6.2,0,0,1,5-2.22,6.07,6.07,0,0,1,4.68,1.89,7.27,7.27,0,0,1,1.74,5.12v1.55H194.16a6,6,0,0,0,1.34,4,4.72,4.72,0,0,0,3.62,1.37,12,12,0,0,0,2.36-.22,13.3,13.3,0,0,0,2.62-.85V67.6a12.27,12.27,0,0,1-2.42.78A13.94,13.94,0,0,1,199,68.61Zm-.64-14a3.69,3.69,0,0,0-2.88,1.18A5.47,5.47,0,0,0,194.22,59h7.91a5,5,0,0,0-1-3.31A3.47,3.47,0,0,0,198.36,54.57Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M218.87,64a3.94,3.94,0,0,1-1.63,3.38,7.59,7.59,0,0,1-4.57,1.2,10.37,10.37,0,0,1-4.89-1V65.31a11.3,11.3,0,0,0,4.94,1.24,4.91,4.91,0,0,0,2.81-.62,1.94,1.94,0,0,0,.87-1.67,1.91,1.91,0,0,0-.84-1.56,13.49,13.49,0,0,0-3-1.46,16.71,16.71,0,0,1-3.09-1.45,4.08,4.08,0,0,1-1.31-1.35,3.7,3.7,0,0,1-.42-1.83,3.49,3.49,0,0,1,1.56-3,7.25,7.25,0,0,1,4.28-1.11,11.82,11.82,0,0,1,4.95,1l-.86,2a11.25,11.25,0,0,0-4.26-1,4.62,4.62,0,0,0-2.41.51,1.53,1.53,0,0,0-.82,1.38,1.72,1.72,0,0,0,.71,1.41,15.18,15.18,0,0,0,3.3,1.55,14.75,14.75,0,0,1,2.86,1.34,4.32,4.32,0,0,1,1.37,1.4A3.8,3.8,0,0,1,218.87,64Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M248.79,68.32h-2.63l-4-13.56a37.52,37.52,0,0,1-1.05-4.09,29.19,29.19,0,0,1-1,4.17l-3.91,13.48h-2.63l-5.48-20.7h2.72L234,60.27a39.47,39.47,0,0,1,1,4.93,36,36,0,0,1,1.11-5.09l3.65-12.49h2.69l3.81,12.59a36.77,36.77,0,0,1,1.13,5,37.55,37.55,0,0,1,1-5l3.2-12.62h2.72Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M263.47,68.61A7.15,7.15,0,0,1,258,66.49a8.15,8.15,0,0,1-2-5.83,9,9,0,0,1,1.85-5.95,6.2,6.2,0,0,1,5-2.22,6.05,6.05,0,0,1,4.68,1.89,7.27,7.27,0,0,1,1.74,5.12v1.55H258.63a6,6,0,0,0,1.35,4,4.7,4.7,0,0,0,3.61,1.37,11.9,11.9,0,0,0,2.36-.22,13.3,13.3,0,0,0,2.62-.85V67.6a12.27,12.27,0,0,1-2.42.78A13.94,13.94,0,0,1,263.47,68.61Zm-.63-14A3.72,3.72,0,0,0,260,55.75,5.47,5.47,0,0,0,258.69,59h7.91a5,5,0,0,0-1-3.31A3.43,3.43,0,0,0,262.84,54.57Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M283.34,64a3.94,3.94,0,0,1-1.63,3.38,7.57,7.57,0,0,1-4.57,1.2,10.37,10.37,0,0,1-4.89-1V65.31a11.3,11.3,0,0,0,4.94,1.24,4.91,4.91,0,0,0,2.81-.62,2,2,0,0,0,.88-1.67A1.9,1.9,0,0,0,280,62.7a13.49,13.49,0,0,0-3-1.46A17,17,0,0,1,274,59.79a4.08,4.08,0,0,1-1.31-1.35,3.7,3.7,0,0,1-.42-1.83,3.49,3.49,0,0,1,1.56-3,7.27,7.27,0,0,1,4.28-1.11,11.79,11.79,0,0,1,4.95,1l-.86,2a11.25,11.25,0,0,0-4.26-1,4.62,4.62,0,0,0-2.41.51,1.53,1.53,0,0,0-.82,1.38,1.75,1.75,0,0,0,.71,1.41,15.18,15.18,0,0,0,3.3,1.55,14.47,14.47,0,0,1,2.86,1.34,4.32,4.32,0,0,1,1.37,1.4A3.8,3.8,0,0,1,283.34,64Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M292.3,66.53a8.94,8.94,0,0,0,1.16-.1,5.13,5.13,0,0,0,1-.23v2a5.3,5.3,0,0,1-1.1.31,7.58,7.58,0,0,1-1.51.15c-3,0-4.55-1.6-4.55-4.8V54.76h-2.2V53.54l2.22-1,1-3.31h1.52v3.57h4.49v2h-4.49v9a3,3,0,0,0,.64,2.06A2.26,2.26,0,0,0,292.3,66.53Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M304.18,68.61a7.15,7.15,0,0,1-5.48-2.12,8.15,8.15,0,0,1-2-5.83,9,9,0,0,1,1.85-5.95,6.2,6.2,0,0,1,5-2.22,6.05,6.05,0,0,1,4.68,1.89A7.27,7.27,0,0,1,310,59.5v1.55H299.34a6,6,0,0,0,1.35,4,4.7,4.7,0,0,0,3.61,1.37,11.9,11.9,0,0,0,2.36-.22,13.3,13.3,0,0,0,2.62-.85V67.6a12.06,12.06,0,0,1-2.42.78A13.94,13.94,0,0,1,304.18,68.61Zm-.63-14a3.72,3.72,0,0,0-2.89,1.18A5.47,5.47,0,0,0,299.4,59h7.91a5,5,0,0,0-1-3.31A3.43,3.43,0,0,0,303.55,54.57Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M324.52,68.32V58.38a4.1,4.1,0,0,0-.84-2.82,3.43,3.43,0,0,0-2.65-.93A4.21,4.21,0,0,0,317.56,56a6.83,6.83,0,0,0-1.08,4.31v8h-2.55V52.78H316l.38,2.12h.14a4.83,4.83,0,0,1,2-1.78,6.49,6.49,0,0,1,2.87-.63,5.8,5.8,0,0,1,4.25,1.39A5.89,5.89,0,0,1,327,58.2V68.32Z" transform="translate(-12.41 -11.05)"/><path class="c" d="M342,64a4,4,0,0,1-1.63,3.38,7.61,7.61,0,0,1-4.58,1.2,10.36,10.36,0,0,1-4.88-1V65.31a11.3,11.3,0,0,0,4.94,1.24,4.91,4.91,0,0,0,2.81-.62,1.94,1.94,0,0,0,.87-1.67,1.91,1.91,0,0,0-.84-1.56,13.49,13.49,0,0,0-3-1.46,16.39,16.39,0,0,1-3.09-1.45,4,4,0,0,1-1.31-1.35,3.7,3.7,0,0,1-.42-1.83,3.49,3.49,0,0,1,1.56-3,7.25,7.25,0,0,1,4.28-1.11,11.82,11.82,0,0,1,4.95,1l-.86,2a11.25,11.25,0,0,0-4.26-1,4.62,4.62,0,0,0-2.41.51,1.53,1.53,0,0,0-.82,1.38,1.72,1.72,0,0,0,.71,1.41,15.27,15.27,0,0,0,3.29,1.55,14.61,14.61,0,0,1,2.87,1.34,4.32,4.32,0,0,1,1.37,1.4A3.8,3.8,0,0,1,342,64Z" transform="translate(-12.41 -11.05)"/></svg>
</button>
</div>
<div>
<nav id="primary" class="megamenu">
<?php
// Hauptmenü
if( has_nav_menu( 'primary' ) ) :
	wp_nav_menu( array(
				 'menu'       	  => ' ',
                 'menu_class'     => '',
        		 'theme_location' => 'primary',
        		 'container'  	  => FALSE,
			 	 'walker'         => new MegaMenu_Walker() ) );
endif;
?>
</nav>
</div>
</div>
</header>
<?php
// Breadcrumb
if( function_exists('yoast_breadcrumb') ) :
	yoast_breadcrumb( '<nav id="breadcrumb">','</nav>' );
endif;
?>
