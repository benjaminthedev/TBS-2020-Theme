<?php
$permalink = get_permalink();
$parser = new Dokan_WXR_Parser();

?>

<?php do_action( 'dokan_dashboard_wrap_start' ); ?>

<div class="dokan-dashboard-wrap">
	<?php

        /**
         *  dokan_dashboard_content_before hook
         *  dokan_tools_content_before hook
         *
         *  @hooked get_dashboard_side_navigation
         *
         *  @since 2.4
         */
        do_action( 'dokan_dashboard_content_before' );
        do_action( 'dokan_tools_content_before' );
    ?>

	<div class="dokan-dashboard-content dokan-withdraw-content">
		<?php

            /**
             *  dokan_tools_content_inside_before hook
             *
             *  @since 2.4
             */
            do_action( 'dokan_tools_content_inside_before' );
        ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<header class="dokan-dashboard-header">
			    <h1 class="entry-title"><?php esc_html_e( 'Tools', 'cartzilla' ); ?></h1>
			</header><!-- .-->

			<div id="tab-container">
				<ul class="nav nav-tabs nav-justified align-items-end" role="tablist">
                    <?php if ( current_user_can( 'dokan_import_product' ) ): ?>
                        <li class="text-center flex-grow-1">
                            <a href="#import" class="nav-link px-2 active" data-toggle="tab" role="tab">
                                <?php esc_html_e( 'Import', 'cartzilla' ); ?>
                            </a>
                        </li>
                    <?php endif ?>

                    <?php if ( current_user_can( 'dokan_export_product' ) ): ?>
                        <li class="text-center flex-grow-1">
                            <a href="#export" class="nav-link px-2" data-toggle="tab" role="tab">
                                <?php esc_html_e( 'Export', 'cartzilla' ); ?>
                            </a>
                        </li>
                    <?php endif ?>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
                    <?php if ( current_user_can( 'dokan_import_product' ) ): ?>
    				  	<div class="import_div tab-pane active" id="import" role="tabpanel">
                            <header class="dokan-import-export-header">
    					    	<h1 class="entry-title"><?php esc_html_e( 'Import XML', 'cartzilla' ); ?></h1>
    					    </header>

    						<?php

    						if( isset( $_POST['import_xml'] ) ) {
    							if( empty( $_FILES['import'] ) ) {
    								echo esc_html__( "Please select a xml file", 'cartzilla' );
    							}else {
    								Dokan_Product_Importer::init()->import( $_FILES['import']['tmp_name'] );
    							}
    						}

    						?>
    					    <p><?php esc_html_e( 'Click Browse button and choose a XML file that you want to import.', 'cartzilla' ); ?></p>
    					    <form method='post' enctype='multipart/form-data' action="">
    				        	<p><input type='file' name='import' /></p>
    				        	<p><input type='submit' name='import_xml' value='<?php esc_html_e( 'Import', 'cartzilla' ); ?>' class="btn btn-danger" /></p>

    					    </form>
                            <hr>
                            <header class="dokan-import-export-header">
    					    	<h1 class="entry-title"><?php esc_html_e( 'Import CSV', 'cartzilla' ); ?></h1>
    					    </header>
                            <a href="<?php echo dokan_get_navigation_url( 'tools/csv-import' ) ?>" class="dokan-btn dokan-btn-theme">
                                <?php esc_html_e( 'Import CSV', 'cartzilla' ) ?>
                            </a>

    				  	</div>
                    <?php endif ?>
                    <?php if ( current_user_can( 'dokan_export_product' ) ): ?>
                        <div class="export_div tab-pane" id="export" role="tabpanel">
                            <header class="dokan-import-export-header">
                                    <h1 class="entry-title"><?php esc_html_e( 'Export XML', 'cartzilla' ); ?></h1>
                            </header>


                            <p><?php esc_html_e( 'Chose your type of product and click export button to export all data in XML form', 'cartzilla' ); ?></p>

                            <form action="" method="POST">
                                <p><input type="radio" name="content" value="all" id="export_all" checked="checked"> <label for="export_all"><?php esc_html_e( 'All', 'cartzilla' ); ?></label></p>
                                <p><input type="radio" name="content" value="product" id="export_product"> <label for="export_product"><?php esc_html_e( 'Product', 'cartzilla' ); ?></label></p>
                                <p><input type="radio" name="content" value="product_variation" id="export_variation_product"> <label for="export_variation_product"><?php esc_html_e( 'Variation', 'cartzilla' ); ?></label></p>
                                <p><input type="submit" name="export_xml" value="Export" class="btn btn-danger"></p>
                            </form>
                            <hr>
                            <header class="dokan-import-export-header">
                                <h1 class="entry-title"><?php esc_html_e( 'Export CSV', 'cartzilla' ); ?></h1>
                            </header>
                            <a href="<?php echo dokan_get_navigation_url( 'tools/csv-export' ) ?>" class="dokan-btn dokan-btn-theme">
                                <?php esc_html_e( 'Export CSV', 'cartzilla' ) ?>
                            </a>

                        </div>
                    <?php endif ?>

				</div>
			</div>

		</article>

		<?php

            /**
             *  dokan_tools_content_inside_after hook
             *
             *  @since 2.4
             */
            do_action( 'dokan_tools_content_inside_after' );
        ?>

    </div><!-- .dokan-dashboard-content -->

	 <?php
        /**
         *  dokan_dashboard_content_after hook
         *  dokan_tools_content_after hook
         *
         *  @since 2.4
         */
        do_action( 'dokan_dashboard_content_after' );
        do_action( 'dokan_tools_content_after' );
    ?>

</div><!-- .dokan-dashboard-wrap -->

<?php do_action( 'dokan_dashboard_wrap_end' ); ?>