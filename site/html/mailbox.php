<?php

require_once 'inc/bootstrap.php';

require 'inc/head.php';

/*Supprime le message choisi*/
if(isset($_GET['delete'])) {
	$statement = $pdo->prepare('DELETE FROM `messages` WHERE `id` = :id');	
	$statement->execute([':id' => $_GET['delete']]);
	header('Location: ?');
	exit();
}

$success = 0;

/*Recuperation des messages pour l'utilisateur connecté*/
$messages = $pdo->prepare(<<<'SQL'
SELECT 
	`messages`.`id`, 
	`users`.`username` AS `from`, 
	`messages`.`subject`, 
	`messages`.`dateSent`, 
	`messages`.`body` 
FROM `messages` 
	LEFT JOIN `users` ON `messages`.`from` = `users`.`id`  
WHERE `messages`.`to` = :id
ORDER BY `dateSent` DESC
SQL
);
$messages->execute([':id' => $_SESSION['user']['userid']]);
?>

<h1>Mailbox</h1>
<div class="row">
	<div class="col">
		<!-- Affichage des messages -->
		<form method="post">
		<table class="table table-bordered table-hover table-sm">
			<thead>
				<tr>
					<th>From</th>
					<th>Subject</th>
					<th>Date</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($messages as $message): ?>
				<tr data-id="<?= htmlentities($message['id']) ?>">
					<div id="body-<?= htmlentities($message['id']) ?>" class="sr-only"><?= ($message['body']); ?></div>
					<td class="field-from" ><?= htmlentities($message['from']) ?></td>
					<td id="subject-<?= htmlentities($message['id']) ?>" class="field-subject" ><?= htmlentities($message['subject']) ?></td>
					<td class="field-date" ><?= htmlentities((new DateTime($message['dateSent']))->format("l, F jS Y H:i:s")) ?></td>
					<td class="field-action">
						<button type="button" class="btn btn-outline-primary btn-sm" onclick="
$('#modaleBody').html($('#body-<?= htmlentities($message['id']) ?>').html());
$('#modalTitle').html($('#subject-<?= htmlentities($message['id']) ?>').html());
$('#modalDate').html('<?= htmlentities((new DateTime($message['dateSent']))->format("l, F jS Y H:i:s")) ?>');
$('#modalFrom').html('<?= htmlentities($message['from']) ?>');
$('#modalReply').attr('href', 'send.php?replyto=<?= htmlentities($message['id']) ?>');
$('#modalDelete').attr('href', '?delete=<?= htmlentities($message['id']) ?>');
$('#exampleModal').modal();
">view</button>
						<a href="send.php?replyto=<?= htmlentities($message['id']) ?>" class="btn btn-outline-warning btn-sm">reply</a>
						<a href="?delete=<?= htmlentities($message['id']) ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure ?')">delete</a>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		</form>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span id="modalTitle">Modal title</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	From : <span id="modalFrom" ></span> <br />
	Date : <span id="modalDate" ></span>
      </div>
      <div class="modal-body" id="modaleBody">
        ...
      </div>
      <div class="modal-footer">
	<a id="modalReply" href="#" class="btn btn-outline-warning">reply</a>
	<a id="modalDelete" href="#" class="btn btn-outline-danger" onclick="return confirm('Are you sure ?')">delete</a>
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php

require 'inc/foot.php';




