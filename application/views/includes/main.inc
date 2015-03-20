<!DOCTYPE html>
<html>
<head>
<title>Nanite fw :: <?=$title;?></title>

<script src="<?=BASE_URL . '/static/js/jquery.min.js';?>"></script>
<script src="<?=BASE_URL . '/static/js/jquery.form.js';?>"></script>
<script src="<?=BASE_URL . '/static/js/jquery.validate.min.js';?>"></script>
<script src="<?=BASE_URL . '/static/js/app.js';?>"></script>
</head>
<body>
	<h1><?=$title;?></h1>

	<?php getnav(); ?>
	
	<?=$body;?>

	<?php include(VIEWS . '/includes/include.html'); ?>



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
	
</body>
</html>