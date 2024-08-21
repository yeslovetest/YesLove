<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0.2
 */

namespace radiustheme\cirkle;
use radiustheme\cirkle\RDTheme;

?>

	<?php 
	if ( class_exists( 'BuddyPress' ) && class_exists( 'bbPress' ) ) {
		if ( is_buddypress() || is_bbpress() ) { ?>
				</div>
			</div>
	<?php } 
	} ?>

	<?php get_template_part( 'template-parts/footer/footer', RDTheme::$footer_style ); ?>
</div>
<?php wp_footer(); ?>

<script>
	console.log('phew!');
	// Wait for the document to be fully loaded
document.addEventListener("DOMContentLoaded", function() {
    // Change the placeholder text
    var statusBox = document.querySelector(".page-id-0 #whats-new");
	var statusBoxClient = document.querySelector(".page-id-5 #whats-new");
    
    if (statusBox) {
        statusBox.placeholder = "Share content on Mental Health in the context of romantic relationships!";
    }
	
	if (statusBoxClient) {
        statusBoxClient.placeholder = "Have you ever been in a romantic relationship affected by a mood or a personality disorder? Why not share your story to help others? Have a question? Ask!";
    }
});
</script>
</body>
</html>