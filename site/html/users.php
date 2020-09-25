<?php

require_once 'inc/bootstrap.php';

require 'inc/head.php';

if(!ADMIN) {
	require 'inc/foot.php';
	exit();
}

if(isset($_GET['delete'])) {
	$statement = $pdo->prepare('DELETE FROM `users` WHERE `id` = :id');
	$statement->execute([':id' => $_GET['delete']]);
	header('Location: ?');
	exit();
}


function alert($message) {
?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
	<strong>Error</strong> <?= $message ?>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<?php
}

$success = 0;

foreach($_POST as $id => $value) {
	if($id === 'new') {
		if(isset(
			$value['username'],
			$value['password'],
			$value['confirm-password']
		) && $value['username'] != '' && $value['password'] != ''
		) {
			if($value['password'] !== $value['confirm-password']) {
				alert("Password and confirm for <strong>new</strong> user don't match");
				continue;
			}
			$isadmin = isset($value['isadmin']) && $value['isadmin'] == 'on' || $value['isadmin'] == 'true';
			$isactive = isset($value['isactive']) && $value['isactive'] == 'on' || $value['isactive'] == 'true';
			$statement = $pdo->prepare('INSERT INTO `users` (`username`, `password`, `isAdmin`, `isActive`) VALUES (:username, :password, :isAdmin, :isActive)');
			if($statement->execute([
				':username' => $value['username'],
				':password' => password_hash($value['password'], PASSWORD_DEFAULT),
				':isAdmin' => $isadmin,
				':isActive' => $isactive,
			])) {
				++$success;
				continue;
			} else {
				alert("Database update failed for <strong>new</strong> user");
				continue;
			}
		}
	} elseif(is_int($id)) {
		if(isset(
			$value['username'],
			$value['password'],
			$value['confirm-password']
		) && $value['username'] != ''
		) {
			if($value['password'] !== $value['confirm-password']) {
				alert("Password and confirm for <strong>$id</strong> user don't match");
				continue;
			}
			$isadmin = isset($value['isadmin']) && $value['isadmin'] == 'on' || $value['isadmin'] == 'true';
			$isactive = isset($value['isactive']) && $value['isactive'] == 'on' || $value['isactive'] == 'true';
			$statement = $pdo->prepare('UPDATE `users` SET `username` = :username, '. ($value['password'] != '' ? '`password` = :password,' : '') . '`isAdmin` = :isAdmin, `isActive` = :isActive WHERE `id` = :id');
			$data = [
				':username' => $value['username'],
				':isAdmin' => $isadmin,
				':isActive' => $isactive,
				':id' => $id,
			];
			if($value['password'] != '') 
				$data[':password'] = password_hash($value['password'], PASSWORD_DEFAULT);
			if($statement->execute($data)) {
				++$success;
				continue;
			} else {
				alert("Database update failed for <strong>$id</strong> user");
				continue;
			}
		} else {
			alert("Missing entry for <strong>$id</strong> user");
			continue;
		}
	}
}

?>

<script>
	function edit_input(td, id, name) {
		value = td.text();
		td.html('<input type="text" />');
		input = td.children('input')
		input.attr('name', id+'['+name+']');
		input.attr('value', value);
		return input
	}
	function edit_password(td, id, name) {
		value = td.text();
		td.html('<input type="password" /><input type="password" />');
		password = td.children('input:first-child')
		confirm = td.children('input:last-child')
		password.attr('name', id+'['+name+']');
		password.attr('autocomplete', 'new-password');
		password.attr('placeholder', 'new password');
		confirm.attr('name', id+'[confirm-'+name+']');
		confirm.attr('autocomplete', 'new-password');
		confirm.attr('placeholder', 'confirm');
	}
	function edit_checkbox(td, id, name) {
		value = td.text();
		td.html('<input type="checkbox" />');
		input = td.children('input')
		input.attr('name', id+'['+name+']');
		input.attr('value', 'true');
		if(value == 'yes') {
			input.attr('checked', 'checked');
		}
		return input;
	}
	function edit_submit(td) {
		td.html('<button class="btn btn-outline-warning btn-sm" type="submit">save</button>');
	}
	function edit_row(me) {
		row = $(me).parent().parent();
		id = row.children('.field-id').text();
		edit_input(row.children('.field-username'), id, 'username');
		edit_password(row.children('.field-password'), id, 'password');
		edit_checkbox(row.children('.field-admin'), id, 'isadmin');
		edit_checkbox(row.children('.field-active'), id, 'isactive');
		edit_submit(row.children('.field-action'));
	}
</script>

<div class="row">
	<div class="col">
		<form method="post">
		<table class="table table-bordered table-hover table-sm">
			<thead>
				<tr>
					<th>#</th>
					<th>Username</th>
					<th>Password</th>
					<th>Admin</th>
					<th>Active</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($pdo->query("SELECT * FROM `users`") as $user): ?>
				<tr>
					<td class="field-id"><?= htmlentities($user['id']) ?></td>
					<td class="field-username"><?= htmlentities($user['username']) ?></td>
					<td class="field-password"><?= empty($user['password']) ? '' : '···' ?></td>
					<td class="field-admin"><?= $user['isAdmin'] ? 'yes' : 'no' ?></td>
					<td class="field-active"><?= $user['isActive'] ? 'yes' : 'no' ?></td>
					<td class="field-action">
						<button type="button" class="btn btn-outline-primary btn-sm" onclick="edit_row(this)">edit</button>
						<a href="?delete=<?= htmlentities($user['id']) ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure ?')">delete</a>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
			<tfoot>
				<tr>
					<td>-</td>
					<td><input type="text" name="new[username]" placeholder="username" /></td>
					<td><input type="password" name="new[password]" autocomplete="new-password" placeholder="password" />
					    <input type="password" name="new[confirm-password]" autocomplete="new-password" placeholder="confirm password" /></td>
					<td><input type="checkbox" name="new[isadmin]" /> admin</td>
					<td><input type="checkbox" name="new[isactive]" checked="checked" /> active</td>
					<td><button type="submit" class="btn btn-outline-warning btn-sm">save</button></td>
				</tr>
			</tfoot>
		</table>
		</form>
	</div>
</div>

<?php

require 'inc/foot.php';




