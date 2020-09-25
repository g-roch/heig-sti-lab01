<?php 
require_once 'inc/bootstrap.php';

require 'inc/head.php';

$error = false;
$errmsg = '';

?>
<h1>MailBox</h1>
<div class="row">
	<div class="mx-auto col-3">
		<form method="post">
			<div class="form-group">
				<label for="to">To</label>
				<select class="form-control" id="to"></select>	
			</div>
			<div class="form-group">
				<label for="subject">Subject</label>
				<input type="text" class="form-control" id="subject">
			</div>
			<div class="form-group">
				<label for="body">Body</label>
				<textarea class="form-control" id="body" rows="3"></textarea>
			</div>
			<button type="submit" class="btn btn-primary">Send</button>
		</form>
	</div>
</div>

<?php

require 'inc/foot.php';


