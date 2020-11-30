<?php if( !defined ( "CORE" ) ) { die("error!"); } ?>

	<div id="notfound">
		<div class="notfound">
			<div class="notfound-404">
				<h1>404 </h1>
			</div>
			<h2><?= $utils->translate($lang, "content", "message_1") ?></h2>
			<p><?= $utils->translate($lang, "content","message_2") ?></p>
			<a href="<?= HTTP.HOST ?>"><?= $utils->translate($lang, "content","message_3") ?></a>
		</div>
	</div>