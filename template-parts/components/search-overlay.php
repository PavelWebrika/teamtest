<?php
/**
 * Search overlay — markup only. All results are rendered by JS.
 *
 * Included once in header.php just before </header>.
 *
 * @package SelectaTheme
 */

wp_enqueue_style( 'selecta-search-overlay' );
?>
<div
	id="search-overlay"
	class="search-overlay"
	role="dialog"
	aria-modal="true"
	aria-label="<?php esc_attr_e( 'Product search', 'selecta-theme' ); ?>"
	hidden
>
	<div class="search-overlay__backdrop" aria-hidden="true"></div>

	<div class="search-overlay__panel">
		<div class="search-overlay__header">
			<div class="search-overlay__bar">
				<span class="search-overlay__bar-icon" aria-hidden="true">
					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" aria-hidden="true" focusable="false">
						<circle cx="8.5" cy="8.5" r="6" stroke="currentColor" stroke-width="1.5"/>
						<line x1="13" y1="13" x2="18" y2="18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
					</svg>
				</span>

				<input
					id="search-input"
					class="search-overlay__input"
					type="search"
					autocomplete="off"
					spellcheck="false"
					placeholder="<?php esc_attr_e( 'Търсене...', 'selecta-theme' ); ?>"
					aria-label="<?php esc_attr_e( 'Search products', 'selecta-theme' ); ?>"
				>

				<button
					id="search-close"
					class="search-overlay__close"
					type="button"
					aria-label="<?php esc_attr_e( 'Close search', 'selecta-theme' ); ?>"
				>
					<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true" focusable="false">
						<line x1="1" y1="1" x2="13" y2="13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
						<line x1="13" y1="1" x2="1" y2="13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
					</svg>
				</button>
			</div>
		</div>

		<div class="search-overlay__body">
			<p id="search-count" class="search-overlay__count" hidden></p>

			<p id="search-loading" class="search-overlay__loading" hidden>
				<?php esc_html_e( 'Търсене...', 'selecta-theme' ); ?>
			</p>

			<div id="search-results-wrap" class="search-overlay__results-wrap">
				<ul
					id="search-results"
					class="search-overlay__results"
					aria-live="polite"
					aria-atomic="false"
				></ul>

				<p id="search-no-results" class="search-overlay__empty" hidden>
					<span class="search-overlay__empty-icon" aria-hidden="true">
						<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none" aria-hidden="true" focusable="false">
							<circle cx="16" cy="16" r="15" stroke="#d4d9db" stroke-width="1.5"/>
							<text x="16" y="21" text-anchor="middle" font-size="16" fill="#d4d9db" font-family="sans-serif">?</text>
						</svg>
					</span>
					<span class="search-overlay__empty-title"><?php esc_html_e( 'Няма намерени продукти', 'selecta-theme' ); ?></span>
					<span class="search-overlay__empty-hint"><?php esc_html_e( 'Опитайте с други ключови думи или разгледайте каталога ни.', 'selecta-theme' ); ?></span>
				</p>
			</div>
		</div>
	</div>

	<template id="selecta-search-star-template" aria-hidden="true"><?php
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- hardcoded theme SVG
		echo selecta_get_svg( 'star2' );
	?></template>
</div>
