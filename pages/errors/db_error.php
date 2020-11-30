<?php if( !defined ( "CORE" ) ) { die("error!"); } ?>

	<div id="notfound">
		<div class="notfound">
			<div class="notfound-404">
				<h1>505</h1>
			</div>
			<h2><?= $utils->translate($lang, "content", "message_1",APP_TEMPLATE) ?></h2>
			<p><?= $utils->translate($lang, "content","message_2",APP_TEMPLATE) ?></p>
			<a href="<?= HTTP.HOST ?>"><?= $utils->translate($lang, "content","message_3",APP_TEMPLATE) ?></a>
		</div>
	</div>
