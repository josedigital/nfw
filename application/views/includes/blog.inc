<!DOCTYPE HTML>
<html>
	<head>
		<title>Nanite fw :: <?=$title;?></title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />

		<script src="<?=BASE_URL;?>/static/js/jquery.min.js"></script>
		<script src="<?=BASE_URL;?>/static/js/jquery.form.js"></script>
		<script src="<?=BASE_URL;?>/static/js/jquery.validate.min.js"></script>
		<script src="<?=BASE_URL;?>/static/js/app.js"></script>
		<!--[if lte IE 8]><script src="<?=BASE_URL;?>/static/js/html5shiv.js"></script><![endif]-->
		<script src="<?=BASE_URL;?>/static/js/jquery.scrolly.min.js"></script>
		<script src="<?=BASE_URL;?>/static/js/skel.min.js"></script>
		<script src="<?=BASE_URL;?>/static/js/skel-layers.min.js"></script>
		<script src="<?=BASE_URL;?>/static/js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="<?=BASE_URL;?>/static/css/skel.css" />
			<link rel="stylesheet" href="<?=BASE_URL;?>/static/css/style.css" />
			<link rel="stylesheet" href="<?=BASE_URL;?>/static/css/style-xlarge.css" />
		</noscript>
	</head>
	<body id="top">


		<!-- Header -->
			<header id="header" class="skel-layers-fixed">
				<h1><a href="#">nfw</a></h1>
				<nav id="nav">
					<ul>
						<li><a href="<?=BASE_URL;?>">Home</a></li>
						<li><a href="<?=BASE_URL;?>/new-page/">New Page</a></li>
						<li><a href="<?=BASE_URL;?>/markdown/">Markdown</a></li>
						<li><a href="<?=BASE_URL;?>/bbb/">Test Page</a></li>
						<li><a href="<?=BASE_URL;?>/contact/">Contact</a></li>
					</ul>
				</nav>
			</header>




		<!-- Banner -->
			<section id="banner">
				<h2>nfw</h2>
				<p>A simple starting point for projects based on Skel.</p>
				<ul class="actions">
					<li><a href="#content" class="button special">Content</a></li>
					<li><a href="#elements" class="button">Elements</a></li>
					<li><a href="#grid" class="button alt">Grid System</a></li>
				</ul>
			</section>


	
	

			<?php #you can include other files easily #include(VIEWS . '/includes/include.html'); ?>





		<!-- Main -->
			<div id="main" class="container">

				<!-- Intro -->
					<div class="row">
						<section class="3u 6u(medium) 12u$(small)">

								<div class="blog-archive">
									<ul id="blog-posts">
									<?php
										// create new iterator for each directory
										$blogposts = new DirectoryIterator(VIEWS . '/blog');
										while($blogposts->valid()) 
										{
											if(!$blogposts->isDir()) 
											{
												$page = pathinfo($blogposts->getFilename(), PATHINFO_FILENAME);
												$pagename = explode('_',$page);
												echo '<li><a href="' . BASE_URL . '/blog/' . $pagename[1] . '/">' . $pagename[1] . '</a></li>';
											}
											$blogposts->next();
										}
									?>
									</ul>

								</div>

						</section>
						<section class="9u 12u$(medium)">
							
							<h2><?=$title;?></h2>
							<?=$body;?>

						</section>
					</div>

				<hr class="major" />

				<!-- Content -->
					<h2 id="content">Sample Content</h2>
					<p>Praesent ac adipiscing ullamcorper semper ut amet ac risus. Lorem sapien ut odio odio nunc. Ac adipiscing nibh porttitor erat risus justo adipiscing adipiscing amet placerat accumsan. Vis. Faucibus odio magna tempus adipiscing a non. In mi primis arcu ut non accumsan vivamus ac blandit adipiscing adipiscing arcu metus praesent turpis eu ac lacinia nunc ac commodo gravida adipiscing eget accumsan ac nunc adipiscing adipiscing.</p>
					<div class="row">
						<div class="6u 12u$(small)">
							<h3>Sem turpis amet semper</h3>
							<p>Nunc lacinia ante nunc ac lobortis. Interdum adipiscing gravida odio porttitor sem non mi integer non faucibus ornare mi ut ante amet placerat aliquet. Volutpat commodo eu sed ante lacinia. Sapien a lorem in integer ornare praesent commodo adipiscing arcu in massa commodo lorem accumsan at odio massa ac ac. Semper adipiscing varius montes viverra nibh in adipiscing blandit tempus accumsan.</p>
						</div>
						<div class="6u$ 12u$(small)">
							<h3>Magna odio tempus commodo</h3>
							<p>In arcu accumsan arcu adipiscing accumsan orci ac. Felis id enim aliquet. Accumsan ac integer lobortis commodo ornare aliquet accumsan erat tempus amet porttitor. Ante commodo blandit adipiscing integer semper orci eget. Faucibus commodo adipiscing mi eu nullam accumsan morbi arcu ornare odio mi adipiscing nascetur lacus ac interdum morbi accumsan vis mi accumsan ac praesent.</p>
						</div>
						<!-- Break -->
						<div class="4u 12u$(medium)">
							<h3>Interdum sapien gravida</h3>
							<p>Nunc lacinia ante nunc ac lobortis. Interdum adipiscing gravida odio porttitor sem non mi integer non faucibus ornare mi ut ante amet placerat aliquet. Volutpat eu sed ante lacinia sapien lorem accumsan varius montes viverra nibh in adipiscing blandit tempus accumsan.</p>
						</div>
						<div class="4u 12u$(medium)">
							<h3>Faucibus consequat lorem</h3>
							<p>Nunc lacinia ante nunc ac lobortis. Interdum adipiscing gravida odio porttitor sem non mi integer non faucibus ornare mi ut ante amet placerat aliquet. Volutpat eu sed ante lacinia sapien lorem accumsan varius montes viverra nibh in adipiscing blandit tempus accumsan.</p>
						</div>
						<div class="4u$ 12u$(medium)">
							<h3>Accumsan montes viverra</h3>
							<p>Nunc lacinia ante nunc ac lobortis. Interdum adipiscing gravida odio porttitor sem non mi integer non faucibus ornare mi ut ante amet placerat aliquet. Volutpat eu sed ante lacinia sapien lorem accumsan varius montes viverra nibh in adipiscing blandit tempus accumsan.</p>
						</div>
					</div>


					<section class="4u 6u(medium) 12u$(small)">
					<header class="major">
						<h3>Get in Touch</h3>
					</header>

					<form method="post" action="<?=BASE_URL;?>/formsprocessor/" id="contact-form">
						<div class="row uniform 50%">
							<div class="12u name">
								<input type="text" name="name" id="name" value="" placeholder="Name" required />
							</div>
							<div class="12u lastname">
								<input type="text" name="lastname" id="lastname" value="" placeholder="Last Name" />
							</div>
							<div class="12u$ email">
								<input type="email" name="email" id="email" value="" placeholder="Email" required />
							</div>
							<div class="12u$">
								<div class="select-wrapper">
									<select name="subject" id="subject">
										<option value="">- Subject -</option>
										<option value="Design">Design</option>
										<option value="Freelance Work">Freelance Work</option>
										<option value="In-house Work">In-house Work</option>
										<option value="General Inquiry">General Inquiry</option>
									</select>
								</div>
							</div>
							<div class="12u$">
								<textarea name="message" id="message" placeholder="Enter your message" rows="6" required></textarea>
							</div>
							<div class="12u$">
								<ul class="actions">
									<li><input name="contactsubmit" type="submit" value="Send Message" class="special" /></li>
									<!-- <li><input type="reset" value="Reset" /></li> -->
								</ul>
							</div>
						</div>
					</form>
					<div id="success" style="display:none"></div>
				</section>



			</div><!-- /#main -->
	
</body>