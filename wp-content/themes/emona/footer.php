  <?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && (is_cart() || is_checkout() || is_account_page()) ): ?>
      </div>
  <?php endif; ?>

  <?php get_sidebar( 'footer' ); ?>
  <div class="copyright">
    <div class="container">
      <?php 
      global $options_data; 
      echo $options_data['copyright_text']; ?>
    </div>
  </div>
  </footer>
  <?php global $anps_parallax_slug;
  if (count($anps_parallax_slug)>0) : ?>
  <script>
      jQuery(function($) {
          <?php for($i=0;$i<count($anps_parallax_slug);$i++) : ?>
              $("#<?php echo $anps_parallax_slug[$i]; ?>").parallax("50%", 0.6);
          <?php endfor; ?>
      });
  </script>
  <?php endif;?>
  <?php  if(isset($options_data['preloader']) && $options_data['preloader']=="on") : ?>
  <script>
    jQuery(function ($) {
      $("body").queryLoader2({
        backgroundColor: "#fff",
        barColor: "333",
          barHeight: 0,
        percentage: true,
          onComplete : function() {
            $(".site-wrapper, .colorpicker").css("opacity", "1");
          }
      });
    });
  </script>
  <?php endif; ?>
</div>
<input type="hidden" id="theme-path" value="<?php echo get_template_directory_uri(); ?>" />
<?php wp_footer(); ?>
</body>
</html>