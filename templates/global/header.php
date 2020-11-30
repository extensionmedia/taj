<html xmlns="http://www.w3.org/1999/xhtml" dir="<?= $dir ?>" lang="<?= ($lang=="")? "fr" : $lang ?>">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
	
	<title><?= $utils->translate($lang,"topbar","name") . " : " . $utils->translate($lang,"topbar","description") ?></title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" integrity="sha384-OHBBOqpYHNsIqQy8hL1U+8OXf9hH6QRxi0+EODezv82DfnZoV7qoHAZDwMwEJvSw" crossorigin="anonymous">

	<link rel="icon" type="image/png" href="<?= HTTP.HOST ?>templates/global/images/logo.png" />
	
	<link href="<?= HTTP.HOST ?>templates/global/css/api/Ycss-1.1.1.css" rel="stylesheet">
	<link href="<?= HTTP.HOST ?>templates/global/css/api/sweetalert2.min.css" rel="stylesheet">
	<link href="<?= HTTP.HOST ?>templates/<?= APP_TEMPLATE ?>/css/app.css" rel="stylesheet">
	<link href="<?= HTTP.HOST ?>templates/<?= APP_TEMPLATE ?>/css/list.css" rel="stylesheet">

</head>
<body>
