<?php
require_once '../initial.php';
require_once DIR_ROOT . '/db/Plugin.php';
require_once DIR_ROOT . '/db/Social.php';

$social = new Social();
$allData = $social->loadAll();

//When edit plugin
$dataPost = $_GET;
@$file = $dataPost['file'];
$formtype = ($file == null) ? 'create' : 'edit'; //Create or Edit
if ($formtype == 'edit') {
    $social = new Social();
    $filePath = DIR_ROOT .  '/plugins/' . $file . '.php';

    $social->load($filePath);
    $dataPost = $social->toArray();
    if (!isset($dataPost['file'])) {
        $dataPost['file'] = $file;
    }
}
?>
<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Admin - Games</title>
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Font Awesome -->
<link rel="stylesheet" href="<?php echo PATH_ROOT ?>/plugins/fontawesome-free/css/all.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?php echo ASSET_ROOT ?>/css/adminlte.css">
<link rel="stylesheet" href="<?php echo ASSET_ROOT ?>/css/style.css">
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<!-- DataTables -->
<link rel="stylesheet" href="<?php echo PATH_ROOT ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo PATH_ROOT ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

</head>

<body class="hold-transition layout-top-nav">
<!-- wrapper -->
<div class="wrapper" id="mainContent">
<div class="content-wrapper">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Games</h1>
				</div>
			</div>
		</div>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<!-- Card -->
			<div class="card card-success">
				<div class="card-header">
					<?php if ($formtype == 'create') : ?>
						<h3 class="card-title">Create Plugin</h3>
					<?php elseif ($formtype == 'edit') : ?>
						<h3 class="card-title">Edit Plugin(<?= $file ?>.php)</h3>
					<?php endif ?>
				</div>
				<div class="card-body">
					<?php if ($formtype == 'create') : ?>
						<!-- Create Form -->
						<form action="" method="post" id="create-plugin">
							<div id="gameContainer">
								<div class="card-body">
									<div class="clear">
										<h4 class="">
											Enter Game
										</h4>
										<hr />
									</div>
									<div class="clear">
										<div id="field">
											<div id="field0">
												<div class="card">
													<div class="card-body">
														<div class="clear">
															<div class="form-group">
																<label for="game_name_0">Name</label>
																<input id="game_name_0" name="game_name[]" type="text" placeholder="" class="form-control input-md">
															</div>
															<div class="form-group">
																<label for="game_iframe_0">IFrame</label>
																<input id="game_iframe_0" name="game_iframe[]" type="text" placeholder="" class="form-control input-md">
															</div>
															<div class="form-group">
																<label for="preview_url_0">Preview URL</label>
																<input id="preview_url_0" name="preview_url[]" type="text" placeholder="" class="form-control input-md">
															</div>
															<div class="form-group">
																<label for="preview_src_0">Preview Image</label>
																<input type="file" id="preview_src_0" name="preview_src_0" class="input-file" accept=".jpg,.jpeg,.png,.gif,.bmp">
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<button type="button" id="add-more" name="add-more" class="btn btn-primary">Add More</button>
										</div>
									</div>
								</div>
							</div>

							<div class="btn-group">
								<a href="<?php echo PATH_ROOT; ?>/admin" class="btn btn-default">Cancel</a>
								<button type="submit" class="btn btn-primary">Create</button>
							</div>
						</form>
						<!-- ./Create Form -->
					<?php elseif ($formtype == 'edit') : ?>
						<!-- Edit Form -->
						<?php
						$data = $dataPost;
						@$message = $data['message'];
						@$type = $data['type'];
						@$game = $data['game'];
						@$network = $data['network'];
						@$id = $data['id'];
						@$iconid = $data['iconid'];
						@$actionName = $data['actionName'];
						@$visitLink = $data['visitLink'];
						@$shareLink = $data['shareLink'];
						@$shareTitle = $data['shareTitle'];
						@$delayTime = $data['delayTime'];
						@$filename = $data['filename'];

						if ($message) {
						?>
							<div class="alert alert-success" role="alert"><?php echo $message ?></div>
						<?php
						}
						?>
						<form action="" method="post" id="edit-plugin">
							<input type="hidden" name="file" value="<?php echo @$data['file'] ?>">
							<div class="card <?= ($type == 'play-then-share') ? '' : 'd-none' ?>" id="gameContainer">
								<div class="card-body">
									<div class="clear">
										<h4 class="">
											Enter Game
										</h4>
										<hr />
									</div>
									<div class="clear">
										<div id="field">
											<?php if ($type == 'play-then-share') : ?>
												<?php foreach ($game as $idx => $obj) : ?>
													<div id="field<?= $idx ?>">
														<div class="card">
															<div class="card-body">
																<div class="clear">
																	<div class="form-group">
																		<label for="game_name_<?= $idx ?>">Name</label>
																		<input id="game_name_<?= $idx ?>" name="game_name[]" type="text" placeholder="" class="form-control input-md" value="<?= $obj->name ?>">
																	</div>
																	<div class="form-group">
																		<label for="game_iframe_<?= $idx ?>">IFrame</label>
																		<input id="game_iframe_<?= $idx ?>" name="game_iframe[]" type="text" placeholder="" class="form-control input-md" value="<?= $obj->iframe ?>">
																	</div>
																	<div class="form-group">
																		<label for="preview_url_<?= $idx ?>">Preview URL</label>
																		<input id="preview_url_<?= $idx ?>" name="preview_url[]" type="text" placeholder="" class="form-control input-md" value="<?= $obj->url ?>">
																	</div>
																	<div class="form-group">
																		<label for="preview_src_<?= $idx ?>">Preview Image(You have to reset image)</label>
																		<input type="file" id="preview_src_<?= $idx ?>" name="preview_src_<?= $idx ?>" class="input-file" accept=".jpg,.jpeg,.png,.gif,.bmp" value="<?= $obj->image ?>">
																	</div>
																</div>
															</div>
														</div>
													</div>
													<?php if ($idx != count($game) - 1) : ?>
														<div class="form-group"><button id="remove<?= $idx ?>" class="btn btn-danger remove-me">Remove</button></div>
													<?php endif  ?>
												<?php endforeach ?>
											<?php else : ?>
												<div id="field0">
													<div class="card">
														<div class="card-body">
															<div class="clear">
																<div class="form-group">
																	<label for="game_name_0">Name</label>
																	<input id="game_name_0" name="game_name[]" type="text" placeholder="" class="form-control input-md">
																</div>
																<div class="form-group">
																	<label for="game_iframe_0">IFrame</label>
																	<input id="game_iframe_0" name="game_iframe[]" type="text" placeholder="" class="form-control input-md">
																</div>
																<div class="form-group">
																	<label for="preview_url_0">Preview URL</label>
																	<input id="preview_url_0" name="preview_url[]" type="text" placeholder="" class="form-control input-md">
																</div>
																<div class="form-group">
																	<label for="preview_src_0">Preview Image</label>
																	<input type="file" id="preview_src_0" name="preview_src_0" class="input-file" accept=".jpg,.jpeg,.png,.gif,.bmp">
																</div>
															</div>
														</div>
													</div>
												</div>
											<?php endif  ?>
										</div>
										<!-- Button -->
										<div class="form-group">
											<button type="button" id="add-more" name="add-more" class="btn btn-primary">Add More</button>
										</div>
									</div>
								</div>
							</div>
							<div class="btn-group">
								<a href="<?php echo PATH_ROOT; ?>/admin" class="btn btn-default">Cancel</a>
								<button type="submit" class="btn btn-primary">Update</button>
							</div>
						</form>
						<!-- ./Edit Form -->
					<?php endif ?>

				</div>


			</div>
			<!-- ./Card -->
			<!-- plugin list -->
			<div id="list-container">
				<div class="card">
					<div class="card-body">
						<div class="clear">
							<h4 class="card-title">All Games</h4>
						</div>
						<div class="clear">
							<?php
							@$message = $allData['message'];
							if ($message) {
							?>
								<div class="alert alert-success" role="alert"><?php echo $message ?></div>
							<?php
							}

							?>
							<br>
							<a href="<?php echo PATH_ROOT ?>/admin" class="btn btn-primary">Add</a>
							<button class="btn btn-danger" onclick="mutipleDelete()">Delete Selected</button>
							<hr>
							<table id="example1" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Select</th>
										<th>Name</th>
										<th>Image</th>
										<th>Iframe</th>
										<th style="width:15%">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if ($allData && count($allData) > 0) {
										foreach ($allData as $key => $data) {
									?>
											<tr>
												<td><input type="checkbox" class="delcheck" filename="<?= $data['filename'] ?>" /></td>
												<td>Name of game</td>
												<td><img width="200px" src="../games/corona/preview.jpg"></td>
												<td>http://localhost/promo/games/corona/</td>
												<td>
													<a href="?file=<?php echo $data['filename']; ?>" class="btn btn-success">Edit</a>
													<button class="btn btn-danger" onclick="deletePlugin(this)" ; delurl="admin_delete_func.php?file=<?php echo $data['filename']; ?>&t=<?php echo time() ?>" filename="<?php echo htmlentities($data['filename']); ?>">
														Delete
													</button>
												</td>
											</tr>
									<?php
										}
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>
			<!-- ./plugin list -->
		</div>
	</section>
	<!-- /.Main content -->
</div>
<footer class="main-footer">
	<div class="float-right d-none d-sm-block">
		<b>Version</b> 3.0
	</div>
	<strong>Copyright &copy; 2020 <a href="https://suite.social">Social Suite</a>.</strong> All rights reserved.
</footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo PATH_ROOT ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo PATH_ROOT ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="<?php echo PATH_ROOT ?>/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo ASSET_ROOT ?>/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo ASSET_ROOT ?>/js/demo.js"></script>

<!-- DataTables -->
<script src="<?php echo PATH_ROOT ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo PATH_ROOT ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo PATH_ROOT ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo PATH_ROOT ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script type="text/javascript">
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

//Reload content
function reloadContent(type, filename) {
	if (type == 'create') var hash = '';
	else if (type == 'edit') var hash = '?file=' + filename;
	$.ajax({
		url: "index.php" + hash,
		cache: false,
		context: document.body
	}).done(function(data) {
		var mainContent = $(data).find("#mainContent");
		$("#mainContent").html(mainContent.html());
	});
}

//load and list all plugins
function loadAllPlugins() {
	$.ajax({
		url: "index.php",
		cache: false,
		context: document.body
	}).done(function(data) {
		var newList = $(data).find("#list-container");
		$("#list-container").html(newList.html());
		$('#mydatatable').DataTable();
	});
}

// When creat new plugin form submits
$("#create-plugin").submit(function(e) {

	e.preventDefault(); // avoid to execute the actual submit of the form.

	var form = $(this);
	var url = 'admin_add_func.php';
	var fd = new FormData(this);
	$.ajax({
		type: "POST",
		contentType: false,
		processData: false,
		url: url,
		data: fd, // serializes the form's elements.

		success: function(data) {
			loadAllPlugins();
			var success = data.success;
			var message = data.message;
			if (success) {
				$("#create-plugin").trigger("reset");
			}
			alert('Created Plugin successfully.'); // show response from the php script.                   
		}
	});

});

// When edit plugin form submits
$("#edit-plugin").submit(function(e) {

	e.preventDefault(); // avoid to execute the actual submit of the form.

	var form = $(this);
	var url = 'admin_edit_func.php';
	var fd = new FormData(this);

	$.ajax({
		type: "POST",
		// dataType: "json",
		contentType: false,
		processData: false,
		url: url,
		data: fd, // serializes the form's elements.
		// data: form.serialize(), // serializes the form's elements.
		success: function(data) {
			loadAllPlugins();
			var success = data.success;
			var message = data.message;
			if (success) {
				$("#edit-plugin").trigger("reset");
				// $('#pictureContainer').addClass('d-none')
				// $('#urlContainer').removeClass('d-none')
			}
			// alert(message); // show response from the php script.
			alert('Updated Plugin successfully.'); // show response from the php script.
			// window.location.href = "/socialsuite";
		}
	});
});

//When change plugin type
$('#type').on('change', function() {
	var pluginType = $(this).val()
	if (pluginType == 'play-then-share') {
		$('#gameContainer').removeClass('d-none')
	} else {
		$('#gameContainer').addClass('d-none')
	}
})

//add more button click in play-then-share
var next = 0;
$("#add-more").click(function(e) {
	e.preventDefault();
	var addto = "#field" + next;
	var addRemove = "#field" + (next);
	next = next + 1;
	var newIn =
		'<div id="field' + next + '" name="field' + next + '">' +
		'<div class="card">' +
		'<div class="card-body">' +
		'<div class="clear">' +
		'<div class="form-group"> ' +
		'<label for="game_name_' + next + '">Name</label>' +
		'<input id="game_name_' + next + '" name="game_name[]" type="text" placeholder="" class="form-control input-md"> ' +
		'</div>' +
		'<div class="form-group"> ' +
		'<label for="game_iframe_' + next + '">IFrame</label>' +
		'<input id="game_iframe_' + next + '" name="game_iframe[]" type="text" placeholder="" class="form-control input-md"> ' +
		'</div>' +
		'<div class="form-group"> ' +
		'<label for="preview_url_' + next + '">Preview URL</label>' +
		'<input id="preview_url_' + next + '" name="preview_url[]" type="text" placeholder="" class="form-control input-md"> ' +
		'</div>' +
		'<div class="form-group">\n' +
		'<label for="preview_src_' + next + '">Preview Image</label>\n' +
		'<input type="file" id="preview_src_' + next + '" name="preview_src' + next + '" class="input-file" accept=".jpg,.jpeg,.png,.gif,.bmp">\n' +
		'<div id="file_name_' + next + '"></div>\n' +
		'</div>' +
		'</div>' +
		'</div>' +
		'</div>' +
		'</div>';
	var newInput = $(newIn);
	var removeBtn = '<div class="form-group"><button id="remove' + (next - 1) + '" class="btn btn-danger remove-me" >Remove</button></div>';
	var removeButton = $(removeBtn);
	$(addto).after(newInput);
	$(addRemove).after(removeButton);
	$("#field" + next).attr('data-source', $(addto).attr('data-source'));
	$("#count").val(next);
	setRemoveGameButton();

});
setRemoveGameButton();

function setRemoveGameButton() {
	$('.remove-me').click(function(e) {
		e.preventDefault();
		var fieldNum = this.id.charAt(this.id.length - 1);
		var fieldID = "#field" + fieldNum;
		$(this).remove();
		$(fieldID).remove();
	});
}
//delete plugin button - plugin list
function deletePlugin(button) {
	var filename = $(button).attr('filename');
	var delurl = $(button).attr('delurl');
	if (confirm('Do you want to delete ' + filename + '?')) {
		$.ajax({
			type: "POST",
			url: 'admin_delete_func.php',
			data: {
				type: "one",
				filename: filename,
			},
			success: function(data) {
				console.log(data);
				loadAllPlugins();
			}
		});
	}
};

//Delete selected
function mutipleDelete() {
	var delfiles = [];
	$("input.delcheck:checked").each(function() {
		var filename = $(this).attr('filename');
		delfiles.push(filename);
	});
	if (confirm('Do you want to delete selected ' + delfiles.length + 'files?')) {
		$.ajax({
			type: "POST",
			url: 'admin_delete_func.php',
			data: {
				type: "multiple",
				filename: delfiles,
			},
			success: function(data) {
				console.log(data);
				loadAllPlugins();
			}
		});
	}
}
</script>

</body>

</html>