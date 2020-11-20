<?php
/**
 * Template file for Appearance > Utility CSS Classes page.
 *
 * @package Cartzilla
 */
?>
<div class="wrap cz-admin-container">
	<h1><?php esc_html_e( 'Utility CSS Classes', 'cartzilla' ); ?></h1>
	<div class="notice notice-info">
		<p>The collection of handy CSS classes like responsive margins, paddings, text and background utility classes, etc. to use inside <strong>Gutenberg Block Advanced (Additional CSS Class(es)) section.</strong> Since Cartzilla is based on Bootstrap framework it inherits all <a href="https://getbootstrap.com/docs/4.4/utilities/" target="_blank" rel="noopener">Bootstraps Utility classes</a> as well as providing its own classes. The most important CSS classes are listed below.</p>
	</div>
	<div class="cz-admin-box">
		<h2><?php esc_html_e( 'Spacing (margins and paddings)', 'cartzilla' ); ?></h2>
		<p><a href="https://getbootstrap.com/docs/4.4/utilities/spacing/" target="_blank" rel="noopener">Bootstrap Documentation</a></p>
		<p>The classes are named using the format <code>{property}{sides}-{size}</code> for <code>xs</code> and <code>{property}{sides}-{breakpoint}-{size}</code> for <code>sm, md, lg, and xl</code>.</p>
		<p>
			<strong>Where <em>property</em> is one of:</strong>
			<ul>
				<li><code>m</code> - for classes that set margin</li>
				<li><code>p</code> - for classes that set padding</li>
			</ul>
		</p>
		<p>
			<strong>Where <em>sides</em> is one of:</strong>
			<ul>
				<li><code>t</code> - for classes that set <code>margin-top</code> or <code>padding-top</code></li>
				<li><code>b</code> - for classes that set <code>margin-bottom</code> or <code>padding-bottom</code></li>
				<li><code>l</code> - for classes that set <code>margin-left</code> or <code>padding-left</code></li>
				<li><code>r</code> - for classes that set <code>margin-right</code> or <code>padding-right</code></li>
				<li><code>x</code> - for classes that set both <code>*-left</code> and <code>*-right</code></li>
				<li><code>y</code> - for classes that set both <code>*-top</code> and <code>*-bottom</code></li>
				<li>blank - for classes that set a <code>margin</code> or <code>padding</code> on all 4 sides of the element</li>
			</ul>
		</p>
		<p>
			<strong>Where <em>size</em> is one of:</strong>
			<strong>$spacer</strong> equals <strong>1rem = 16px</strong>
			<ul>
				<li><code>0</code> - for classes that eliminate the <code>margin</code> or <code>padding</code> by setting it to <code>0</code></li>
				<li><code>1</code> - (by default) for classes that set the <code>margin</code> or <code>padding</code> to <code>$spacer * .25</code></li>
				<li><code>2</code> - (by default) for classes that set the <code>margin</code> or <code>padding</code> to <code>$spacer * .5</code></li>
				<li><code>3</code> - (by default) for classes that set the <code>margin</code> or <code>padding</code> to <code>$spacer</code></li>
				<li><code>4</code> - (by default) for classes that set the <code>margin</code> or <code>padding</code> to <code>$spacer * 1.5</code></li>
				<li><code>5</code> - (by default) for classes that set the <code>margin</code> or <code>padding</code> to <code>$spacer * 3</code></li>
				<li><code>auto</code> - for classes that set the <code>margin</code> to auto</li>
			</ul>
		</p>
		<p>
			<strong>Additionally Cartzilla includes <code>grid-gutter</code> spacing classes that match grid gutter width:</strong>
			<ul>
				<li>Margins: <code>m-grid-gutter</code>, <code>mx-grid-gutter</code>, <code>my-grid-gutter</code></li>
				<li>Responsive margins: <code>m-{breakpoint}-grid-gutter</code>, <code>mx-{breakpoint}-grid-gutter</code>, <code>my-{breakpoint}-grid-gutter</code></li>
				<li>Paddings: <code>p-grid-gutter</code>, <code>px-grid-gutter</code>, <code>py-grid-gutter</code></li>
				<li>Responsive paddings: <code>p-{breakpoint}-grid-gutter</code>, <code>px-{breakpoint}-grid-gutter</code>, <code>py-{breakpoint}-grid-gutter</code></li>
			</ul>
		</p>
		<h2><?php esc_html_e( 'Display', 'cartzilla' ); ?></h2>
		<p><a href="https://getbootstrap.com/docs/4.4/utilities/display/" target="_blank" rel="noopener">Bootstrap Documentation</a></p>
		<h2><?php esc_html_e( 'Sizing', 'cartzilla' ); ?></h2>
		<p><a href="https://getbootstrap.com/docs/4.4/utilities/sizing/" target="_blank" rel="noopener">Bootstrap Documentation</a></p>
		<h2><?php esc_html_e( 'Borders', 'cartzilla' ); ?></h2>
		<p><a href="https://getbootstrap.com/docs/4.4/utilities/borders/" target="_blank" rel="noopener">Bootstrap Documentation</a></p>
		<h2><?php esc_html_e( 'Shadows', 'cartzilla' ); ?></h2>
		<p><a href="'https://getbootstrap.com/docs/4.4/utilities/shadows/" target="_blank" rel="noopener">Bootstrap Documentation</a></p>
		<strong>Additional Cartzilla classes:</strong>
		<ul><li><code>box-shadow-0</code> - to disable shadow on element</li></ul>
		<h2><?php esc_html_e( 'Position', 'cartzilla' ); ?></h2>
		<p><a href="https://getbootstrap.com/docs/4.4/utilities/position/" target="_blank" rel="noopener">Bootstrap Documentation</a></p>
		<h2><?php esc_html_e( 'Colors', 'cartzilla' ); ?></h2>
		<p><a href="https://getbootstrap.com/docs/4.4/utilities/colors/" target="_blank" rel="noopener">Bootstrap Documentation</a></p>
		<strong>Additional Cartzilla <code>background-color</code> classes:</strong>
		<ul>
			<li><code>bg-0</code> - disable background property on element</li>
			<li><code>bg-faded-primary</code></li>
			<li><code>bg-faded-secondary</code></li>
			<li><code>bg-faded-accent</code></li>
			<li><code>bg-faded-success</code></li>
			<li><code>bg-faded-danger</code></li>
			<li><code>bg-faded-info</code></li>
			<li><code>bg-faded-light</code></li>
		</ul>
		<strong>Additional Cartzilla other <code>background-{property}</code> classes:</strong>
		<ul>
			<li><code>bg-size-cover</code></li>
			<li><code>bg-position-center</code></li>
			<li><code>bg-position-center-y</code></li>
			<li><code>bg-position-center-x</code></li>
			<li><code>bg-position-right-top</code></li>
			<li><code>bg-position-right-center</code></li>
			<li><code>bg-no-repeat</code></li>
			<li><code>bg-repeat-x</code></li>
			<li><code>bg-repeat-y</code></li>
		</ul>
		<h2><?php esc_html_e( 'Opacity', 'cartzilla' ); ?></h2>
		<ul>
			<li><code>opacity-25</code> - 25% transparency</li>
			<li><code>opacity-50</code> - 50% transparency</li>
			<li><code>opacity-60</code> - 60% transparency</li>
			<li><code>opacity-70</code> - 70% transparency</li>
			<li><code>opacity-75</code> - 75% transparency</li>
			<li><code>opacity-80</code> - 80% transparency</li>
			<li><code>opacity-90</code> - 90% transparency</li>
			<li><code>opacity-100</code> - 100% transparency</li>
		</ul>
		<h2><?php esc_html_e( 'Text', 'cartzilla' ); ?></h2>
		<p><a href="https://getbootstrap.com/docs/4.4/utilities/text/" target="_blank" rel="noopener">Bootstrap Documentation</a></p>
		<strong>Additional Cartzilla classes:</strong>
		<ul>
			<li><code>text-shadow</code> - enables text shadow</li>
			<li><code>text-heading</code> - applies heading color to body element like paragraph, list, span, etc.</li>
		</ul>
		<h2><?php esc_html_e( 'Flex', 'cartzilla' ); ?></h2>
		<p><a href="https://getbootstrap.com/docs/4.4/utilities/flex/" target="_blank" rel="noopener">Bootstrap Documentation</a></p>
		<h2><?php esc_html_e( 'Vertical alignment', 'cartzilla' ); ?></h2>
		<p><a href="https://getbootstrap.com/docs/4.4/utilities/vertical-align/" target="_blank" rel="noopener">Bootstrap Documentation</a></p>
		<h2><?php esc_html_e( 'Visibility', 'cartzilla' ); ?></h2>
		<p><a href="https://getbootstrap.com/docs/4.4/utilities/visibility/" target="_blank" rel="noopener">Bootstrap Documentation</a></p>
	</div>
</div>
