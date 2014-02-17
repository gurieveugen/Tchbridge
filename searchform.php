<?php $sq = get_search_query() ? get_search_query() : 'Search'; ?>
<form action="<?php bloginfo('url'); ?>" method="get" class="search-form">
	<fieldset>
		<input type="text" name="s" value="" placeholder="<?php echo $sq; ?>" class="text" />
		<button class="btn-search btn"><span>Search</span></button>
	</fieldset>
</form>