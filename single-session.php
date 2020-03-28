<?php
/**
 * Einzelseite eines Programmpunkts
 *
 * @author  Marco Di Bella <mdb@marcodibella.de>
 * @package congressomat
 **/

get_header();
?>

    <main id="main">
        <article>

            <?php
            if( have_posts() ) :
                // Beginn der Ausgabenpufferung
                ob_start();

                while( have_posts() ) :
                    the_post();
            ?>

            <div class="wp-block-group section-wrapper mb-0 mt-0 has-black-10-background-color has-background">
                <div class="wp-block-group__inner-container">

                    <div class="session-details">

                        <div class="article">
                            <h2 class="has-text-align-left">
                            </h2>

                            <?php

                            // Ausführliche Beschreibung vorhanden?
                            echo apply_filters( 'the_content', get_field( 'programmpunkt-beschreibung', get_the_ID() ) );
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            endwhile;

            // Ausgabenpuffer sichern; Pufferung beenden
            $output_buffer = ob_get_contents();
            ob_end_clean();

            // Ausgabe
            echo $output_buffer;
        endif;
        ?>

        </article>
    </main>

<?php
get_footer();
