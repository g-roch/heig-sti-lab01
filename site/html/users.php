<?php

require_once 'inc/bootstrap.php';

require 'inc/head.php';

/*Vérifie que l'utilisateur est administrateur*/
if(!ADMIN) {
	require 'inc/foot.php';
	exit();
}

/*Suppression de l'utilisateur selectionne*/
if(isset($_GET['delete'])) {
    /* TODO: GRH vuln: injection SQL */
	$statement = $pdo->query("DELETE FROM `users` WHERE `id` = $_GET[delete]");
	header('Location: ?');
	exit();
}

/*Affichage d'un message d'alerte*/
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

// Vérification du token CSRF
if (isset($_POST['csrf'], $_SESSION['token']))
    if ($_SESSION['token'] !== $_POST['csrf']) {
        // New token
        $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
    } else {

        //Traitement des modifications demandés par l'utilisateur
        foreach ($_POST as $id => $value) {

            //Ajout d'un nouvel enregistrement
            if ($id === 'new') {
                if (isset(
                        $value['username'],
                        $value['password'],
                        $value['confirm-password']
                    ) && $value['username'] != '' && $value['password'] != ''
                ) {
                    if ($value['password'] !== $value['confirm-password']) {
                        alert("Password and confirm for <strong>new</strong> user don't match");
                        continue;
                    }
                    $isadmin = isset($value['isadmin']) && ($value['isadmin'] == 'on' || $value['isadmin'] == 'true');
                    $isactive = isset($value['isactive']) && ($value['isactive'] == 'on' || $value['isactive'] == 'true');
                    /* TODO: GRH vuln: injection SQL */
                    if ($pdo->query("INSERT INTO `users` (`username`, `password`, `isAdmin`, `isActive`) VALUES ('$value[username]', '" . password_hash($value['password'], PASSWORD_DEFAULT) . "', '$isadmin', '$isactive')")) {
                        ++$success;
                        continue;
                    } else {
                        alert("Database update failed for <strong>new</strong> user");
                        continue;
                    }
                }
                //Modification de l'existant
            } elseif (is_int($id)) {
                if (isset(
                    $value['password'],
                    $value['confirm-password']
                )) {
                    if ($value['password'] !== $value['confirm-password']) {
                        alert("Password and confirm for <strong>$id</strong> user don't match");
                        continue;
                    }
                    $isadmin = isset($value['isadmin']) && ($value['isadmin'] == 'on' || $value['isadmin'] == 'true');
                    $isactive = isset($value['isactive']) && ($value['isactive'] == 'on' || $value['isactive'] == 'true');
                    /* TODO: GRH vuln: injection SQL */
                    $statement = $pdo->query('UPDATE `users` SET ' . ($value['password'] != '' ? '`password` = "' . password_hash($value['password'], PASSWORD_DEFAULT) . '",' : '') . "`isAdmin` = '$isadmin', `isActive` = '$isactive' WHERE `id` = $id");
                    if ($statement) {
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
    }
?>

<script>
	//Fonctions permettant de modifier une ligne du tableau en formulaire d'édition
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
		//edit_input(row.children('.field-username'), id, 'username');
		edit_password(row.children('.field-password'), id, 'password');
		edit_checkbox(row.children('.field-admin'), id, 'isadmin');
		edit_checkbox(row.children('.field-active'), id, 'isactive');
		edit_submit(row.children('.field-action'));
	}
</script>

<h1>Users list</h1>

<div class="row">
	<div class="col">
		<!-- Affichage de la liste des utilisateurs  -->
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
			<tfoot><!--Formulaire d'ajout d'un nouvel utilisateur-->
				<tr>
					<td>-</td>
					<td><input type="text" name="new[username]" placeholder="username" /></td>
					<td><input type="password" name="new[password]" autocomplete="new-password" placeholder="password" />
					    <input type="password" name="new[confirm-password]" autocomplete="new-password" placeholder="confirm password" /></td>
					<td><input type="checkbox" name="new[isadmin]" /> admin</td>
					<td><input type="checkbox" name="new[isactive]" checked="checked" /> active</td>
                    <?php
                    // New token
                    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
                    ?>
                    <input type="hidden" name="csrf" value="<?= htmlentities($_SESSION['token']) ?>" />
					<td><button type="submit" class="btn btn-outline-warning btn-sm">save</button></td>
				</tr>
			</tfoot>
		</table>
		</form>
	</div>
</div>

<?php

require 'inc/foot.php';




