<!DOCTYPE HTML>
<html>
	<head>
		<title>emphatic :: <?=$title;?></title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="<?php if(isset($meta)) echo $meta; ?>" />

		<script src="<?=BASE_URL;?>/static/js/jquery.min.js"></script>
		<script src="<?=BASE_URL;?>/static/js/jquery.form.js"></script>
		<script src="<?=BASE_URL;?>/static/js/jquery.validate.min.js"></script>
		<script src="<?=BASE_URL;?>/static/js/jquery.scrollgress.min.js"></script>
		<script src="<?=BASE_URL;?>/static/js/jquery.scrollex.min.js"></script>
		<!--[if lte IE 8]><script src="<?=BASE_URL;?>/static/js/html5shiv.js"></script><![endif]-->
		<script src="<?=BASE_URL;?>/static/js/jquery.scrolly.min.js"></script>
		<script src="<?=BASE_URL;?>/static/js/skel.min.js"></script>
		<script src="<?=BASE_URL;?>/static/js/skel-layers.min.js"></script>
		<script src="<?=BASE_URL;?>/static/js/xinit.js"></script>
		<noscript>
			<link rel="stylesheet" href="<?=BASE_URL;?>/static/css/skel.css" />
			<link rel="stylesheet" href="<?=BASE_URL;?>/static/css/style.css" />
			<link rel="stylesheet" href="<?=BASE_URL;?>/static/css/style-xlarge.css" />
		</noscript>
	</head>
	<body id="top" class="blog-page">


		<!-- Header -->
			<header id="header" class="skel-layers-fixed">
				<h1><a href="#">emphatic</a></h1>
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
				<div class="inner">
					<h2><?=$title;?></h2>
					<p><?php if(isset($created)) echo $created;?></p>
				</div>
			</section>


	

			<?php #you can include other files easily #include(VIEWS . '/includes/include.html'); ?>




	<div class="color-bg">
		<div class="container">
		<!-- Main -->
			<div id="main" class="inner">

				<!-- Intro -->
					<div class="row">
						<section class="3u 6u(medium) 12u$(small)">

								<div class="blog-archive">
									
									<?php
										blogposts('blog-posts','blog-posts');
										echo 'arg = ' . arg(3);
									?>
									

								</div>

						</section>
						<section class="9u 12u$(medium)">
							
							<h2><?=$title;?></h2>
							
								<?=$body;?>
								<p class="date-created"><?php if(isset($created)) echo $created;?></p>

						</section>
					</div>

				<hr class="major" />

				<!-- Content -->
					<div id="content">
						<?php section('blog-footer') ;?>
					</div>



					<div class="row">
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

						<section class="8u$ 6u$(medium) 12u$(small)">
								<h3>Accumsan montes viverra</h3>
								<p>Nunc lacinia ante nunc ac lobortis. Interdum adipiscing gravida odio porttitor sem non mi integer non faucibus ornare mi ut ante amet placerat aliquet. Volutpat eu sed ante lacinia sapien lorem accumsan varius montes viverra nibh in adipiscing blandit tempus accumsan.</p>
							
						</section>
				</div><!-- /.row -->



			</div><!-- /#main -->
		</div><!-- /.container -->
	</div><!-- /.color-bg -->
</body>