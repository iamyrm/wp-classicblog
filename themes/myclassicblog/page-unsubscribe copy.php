<?php
/**
 * Template Name: Unsubscribe Page
 */
get_header();
?>

<div class="container">
    <div class="unsubscribe-content">
        <?php
        // Handle unsubscribe logic here (same as above)
        if(isset($_GET['email']) && !empty($_GET['email'])) {
            $email = sanitize_email($_GET['email']);
            
            if(is_email($email)) {
                global $wpdb;
                $table_name = $wpdb->prefix . 'blog_subscriber';
                
                $exists = $wpdb->get_var($wpdb->prepare(
                    "SELECT id FROM $table_name WHERE email = %s",
                    $email
                ));
                
                if($exists) {
                    $wpdb->update(
                        $table_name,
                        array('status' => 'unsubscribed'),
                        array('email' => $email),
                        array('%s'),
                        array('%s')
                    );
                    ?>
                    <h2>Successfully Unsubscribed</h2>
                    <p>Your email has been removed from our mailing list.</p>
                    <?php
                } else {
                    ?>
                    <h2>Email Not Found</h2>
                    <p>This email is not in our subscription list.</p>
                    <?php
                }
            }
        } else {
            ?>
            <h2>Unsubscribe from Newsletter</h2>
            <p>Enter your email address to unsubscribe:</p>
            <form method="get" action="">
                <input type="email" name="email" placeholder="Your email address" required>
                <input type="submit" value="Unsubscribe">
            </form>
            <?php
        }
        ?>
    </div>
</div>

<?php get_footer(); ?>