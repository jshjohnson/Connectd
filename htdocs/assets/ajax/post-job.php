<?php
	require("../../config.php"); 
	require(ROOT_PATH . "core/init.php"); 
	 
	include_once(ROOT_PATH . "includes/post.php");
?>
<section class='overlay'>
	<div class='overlay__inner'>
		<a href="" class="cancel-trigger"><i class="icon--cancel"></i></a>
		<h2 class='overlay__title'>Post a job</h2>
		<form method="post" action="<?= BASE_URL; ?>inc/post.php">
			<input type="text" name="firstname" required placeholder="Job title">
			<div class="float-left field-1-2">
				<label for="">Start date:</label>
				<input type="date" name="startdate" required placeholder="Start date" value="">
			</div>
			<div class="float-right field-1-2">
				<label for="">Deadline:</label>
				<input type="date" name="deadline" required placeholder="Deadline" value="">
			</div>
			<div class="float-left field-1-2">
				<input type="text" name="budget" required placeholder="Minimum budget" value="">
			</div>
			<div class="float-right field-1-2">
				<div class="select-container select-container--alt">
					<select name="jobcategory" class="zero-top">
						<option value="">Select a category..</option>
						<option value="Web Design">Web Design</option>
						<option value="Graphic Design">Graphic Design</option>
						<option value="UX Design">UX Design</option>
						<option value="UI Design">UI Design</option>
						<option value="App Design">App Design</option>
						<option value="Illustration">Illustration</option>
						<option value="Web Development">Web Development</option>
						<option value="App Development">App Development</option>
					</select>
				</div>
			</div>			
			<textarea name="jobdescription" cols='30' rows='15' placeholder='Write anything here that you think the freelancer will need to know about your project. The more detailed, the better!'></textarea>
			<div class="btn-container">
            	<input class="btn--green" type="submit" value="Submit job">						
			</div>
		</form> 
	</div>
</section>