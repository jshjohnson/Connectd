<?php 
	require_once("../config.php");  
	require_once(ROOT_PATH . "core/init.php");

	$pageTitle    = "Terms & Conditions";
	$pageType     = "Page";
	$section      = "Blue";

	$general->loggedOutProtect();

	include_once(ROOT_PATH . "includes/header.inc.php"); ?>
	<section>
		<div class="section-heading color-blue">
			<div class="container">
				<div class="grid text-center">
					<div class="grid__cell unit-1-1--bp2 unit-3-4--bp1">				
						<blockquote class="intro-quote text-center">
							Terms &amp; Conditions
						</blockquote>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="footer--push color-navy">
		<div class="grid text-center">
			<div class="grid__cell unit-1-2--bp3 unit-2-3--bp1 content-overlay">
				<p>If you continue to browse and use this website you are agreeing to comply with and be bound by the following terms and conditions of use, which together with our privacy policy govern [business name]’s relationship with you in relation to this website. </p>
				<p>The term “Connectd” or “us” or “we” refers to the owner of the website. The term “you” refers to the user or viewer of our website.</p>
				<p>The use of this website is subject to the following terms of use:</p>
				<ul>
					<li>The content of the pages of this website is for your general information and use only. It is subject to change without notice.</li>
					<li>Neither we nor any third parties provide any warranty or guarantee as to the accuracy, timeliness, performance, completeness or suitability of the information and materials found or offered on this website for any particular purpose. You acknowledge that such information and materials may contain inaccuracies or errors and we expressly exclude liability for any such inaccuracies or errors to the fullest extent permitted by law.</li>
					<li>Your use of any information or materials on this website is entirely at your own risk, for which we shall not be liable. It shall be your own responsibility to ensure that any products, services or information available through this website meet your specific requirements.</li>
					<li>This website contains material which is owned by or licensed to us. This material includes, but is not limited to, the design, layout, look, appearance and graphics. Reproduction is prohibited other than in accordance with the copyright notice, which forms part of these terms and conditions.</li>
					<li>All trademarks reproduced in this website, which are not the property of, or licensed to the operator, are acknowledged on the website.
					<li>Unauthorised use of this website may give to a claim for damages and/or be a criminal offence.</li>
					<li>From time to time this website may also include links to other websites. These links are provided for your convenience to provide further information. They do not signify that we endorse the website(s). We have no responsibility for the content of the linked website(s).</li>
					<li>You may not create a link to this website from another website or document without [business name]’s prior written consent. </li>
					<li>Your use of this website and any dispute arising out of such use of the website is subject to the laws of England and Wales.</li>
				</ul>
			</div>
		</div>
	</section>
<?php include_once(ROOT_PATH . "includes/footer.inc.php"); ?>