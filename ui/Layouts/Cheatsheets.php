<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="msapplication-TileImage" content="/assets/images/favicons/mstile-144x144.png">
    <meta name="msapplication-TileColor" content="#b91d47">
    <meta name="theme-color" content="#ffffff">

    <link rel="apple-touch-icon" sizes="57x57" href="/assets/images/favicons/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/assets/images/favicons/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/assets/images/favicons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/images/favicons/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/assets/images/favicons/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/assets/images/favicons/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/assets/images/favicons/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/assets/images/favicons/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicons/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="/assets/images/favicons/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/assets/images/favicons/favicon-194x194.png" sizes="194x194">
    <link rel="icon" type="image/png" href="/assets/images/favicons/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="/assets/images/favicons/android-chrome-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="/assets/images/favicons/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/assets/images/favicons/manifest.json">

    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <link href="//fonts.googleapis.com/css?family=Iceland:400,700|Droid+Sans:400,700|Droid+Serif:400italic,700italic" rel="stylesheet" type="text/css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/assets/css/styles.css" rel="stylesheet" type="text/css">

    <!--[if gte IE 9]> <style type="text/css"> .gradient { filter: none; } </style> <![endif]-->

    <title><?= $this->title ?></title>
</head>
<body>
<header role="banner">
    <a href="/"><h1>The<br>ShadowLab <small>by Dashifen</small></h1></a>

    <nav role="navigation" class="menu mainmenu gradient">
        <h2 class="visuallyhidden">Main Menu</h2>
		
		<?php if ($this->isAuthenticated) { ?>
			<ul>
				<li>
					<a href="/cheatsheets/combat">Combat</a>
					<ul class="submenu">
						<li><a href="/cheatsheets/combat/called-shots">Called Shots</a></li>
						<li><a href="/cheatsheets/combat/called-shots-ammo">Called Shots: Ammo</a></li>
						<li><a href="/cheatsheets/combat/called-shots-location">Called Shots: Locations</a></li>
						<li><a href="/cheatsheets/combat/combat-actions">Combat Actions</a></li>
						<li><a href="/cheatsheets/combat/martial-arts-styles">Martial Arts Styles</a></li>
						<li><a href="/cheatsheets/combat/martial-arts-techniques">Martial Arts Techniques</a></li>
					</ul>
				</li>
				<li>
					<a href="/cheatsheets/magic">Magic</a>
					<ul class="submenu">
						<li><a href="/cheatsheets/magic/adept-powers">Adept Powers</a></li>
						<li><a href="/cheatsheets/magic/adept-ways">Adept Ways</a></li>
						<li><a href="/cheatsheets/magic/mentor-spirits">Mentor Spirits</a></li>
						<li><a href="/cheatsheets/magic/metamagics">Metamagics</a></li>
						<li><a href="/cheatsheets/magic/spells">Spells</a></li>
						<li><a href="/cheatsheets/magic/spirits">Spirits</a></li>
						<li><a href="/cheatsheets/magic/spirit-powers">Spirit Powers</a></li>
						<li><a href="/cheatsheets/magic/traditions">Traditions</a></li>
					</ul>
				</li>
				<li>
					<a href="/cheatsheets/matrix">Matrix</a>
					<ul class="submenu">
						<li><a href="/cheatsheets/matrix/complex-forms">Complex Forms</a></li>
						<li><a href="/cheatsheets/matrix/intrusion-countermeasures">Intrusion Countermeasures</a></li>
						<li><a href="/cheatsheets/matrix/matrix-actions">Matrix Actions</a></li>
						<li><a href="/cheatsheets/matrix/programs">Programs</a></li>
						<li><a href="/cheatsheets/matrix/sprite-database">Sprite Database</a></li>
						<li><a href="/cheatsheets/matrix/sprite-powers">Sprit Powers</a></li>
					</ul>
				</li>
				<li>
					<a href="/cheatsheets/other">Other</a>
					<ul class="submenu">
						<li><a href="/cheatsheets/other/qualities">Qualities</a></li>
					</ul>
				</li>
                <li>
                    <a href="/logout">Log Out</a>
                </li>
			</ul>
		<?php } else { ?>
            <ul>
                <li><a href="/">Log In</a></li>
            </ul>
        <?php } ?>

    </nav>
</header>

<main role="main">
    <h2><?= empty($this->heading) ? $this->title : $this->heading ?></h2>
    <?= $this->getContent() ?>
	
	<br class="clearfix">
</main>

<footer role="contentinfo">
    <p><a href="http://www.topps.com/">The Topps Company, Inc.</a> has sole ownership of the names, logo, artwork,
        marks, photographs, sounds, audio, video and/or any proprietary material used in connection with the game
        <a href="http://www.shadowrun.com/">Shadowrun</a>. <a href="http://www.topps.com/">The Topps Company, Inc.</a>
        has granted permission to <em>The ShadowLab by Dashifen</em> to use such names, logos, artwork, marks and/or
        any proprietary materials for promotional and informational purposes on its website but does not endorse, and is
        not affiliated with <em>The ShadowLab by Dashifen</em> in any official capacity whatsoever.</p>

    <p>Content not owned by <a href="http://www.topps.com/">The Topps Company, Inc.</a> and all
        programming is copyright &copy; 2013-<?=date("Y")?> <a href="http://dashifen.com">David Dashifen Kees</a>.</p>
</footer>

<script type="text/javascript" src="/Assets/js/3rd-party/jquery.purl.min.js"></script>
<script type="text/javascript" src="/Assets/js/3rd-party/jquery.class.min.js"></script>
<script type="text/javascript" src="/assets/js/utilities/max/searchbar.js"></script>
<script type-"text/javascript" src="/assets/js/utilities/summarize.min.js"></script>
<script type-"text/javascript" src="/assets/js/globals.min.js"></script>

</body>
</html>