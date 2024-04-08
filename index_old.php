<?php
	include_once('templates/layout/header.php'); 
?>
	<div class="container-fluid">
		<?php
			include_once('controller.php');
			$controller = New Controller();
			$requestTypes = $controller->getAllRequestTypes();
			$customisations = $controller->getAllCustomisations();
			session_start();
			if (isset($_SESSION['message_success']) && $_SESSION['message_success'] != '') {
				echo $_SESSION['message_success'];
				unset($_SESSION['message_success']);
			}
			if (isset($_SESSION['message_exists']) && $_SESSION['message_exists'] != '') {
				echo $_SESSION['message_exists'];
				unset($_SESSION['message_exists']);
			}
			if (isset($_SESSION['message_error']) && $_SESSION['message_error'] != '') {
				echo $_SESSION['message_error'];
				unset($_SESSION['message_error']);
			}
		?>
			<h1 class="mb-3">
				<?php 
					foreach ($customisations as $customisation) {
						if ($customisation['id'] == 1) {
							echo $customisation['content'];
						}
					}
				?>
			</h1>
			<div class="row">
				<div class="col-md-6 col-lg-6 col-xs-12">
					<div class="card mb-3">
						<div class="card-header">
							Request Form
						</div>
						<div class="card-body">
							<form class="mb-3" action="submit_request.php" method="POST" onsubmit="return confirm('Are you sure you want to go ahead with the requests?');">
								<div class="mb-3">
									<label for="youtubeChannelName" class="form-label">Your YouTube Channel Name</label>
									<input type="text" class="form-control" id="youTubeChannelName" name="youTubeChannelName" required>
								</div>
								<div class="card request-card mb-3" id="requestCard1">
									<div class="card-header">
										Request 1 <button type="button" id="addRequestButton1" class="btn btn-outline-secondary float-end add-request-button" title="Add Another Request"><i class="fa-solid fa-plus"></i></button>
									</div>
									<div class="card-body">
										<label for="requestTypeIds" class="form-label">Request Type</label>
										<select class="form-select form-select-md mb-3" aria-label=".form-select-lg example" name="requestTypeIds[]" required>
											<?php foreach ($requestTypes as $requestType) { ?>
												<option value="<?= $requestType['id']; ?>"><?= $requestType['name']; ?></option>
											<?php } ?>
										</select>
										<div class="mb-3">
											<label for="artistName" class="form-label">Artist(s) Name</label>
											<input type="text" class="form-control" name="artistNames[]" required>
										</div>
										<div class="mb-3">
											<label for="albumTrackName" class="form-label">Album/Track Name</label>
											<input type="text" class="form-control" name="albumTrackNames[]" required>
										</div>
									</div>
								</div>
								<button type="submit" name="submit" class="btn btn-primary">Submit Request(s)</button>
							</form>
						</div>
					</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				All Current Requests (If Viewing On Phone Or Tablet, Click + Or - Respectively To Expand Or Collapse Rows)
			</div>
			<div class="card-body">
				<table id="requestsTable" class="display wrap" style="width: 100%;">
					<thead>
						<tr>
							<th>#</th>
							<th>YouTube Channel Name</th>
							<th>Album/Track</th>
							<th>Artist Name</th>
							<th>Album/Track Name</th>
							<th>Status</th>
							<th>Rejection Reason</th>
							<th>Completed Request URL</th>
							<th>Created</th>
							<th>Modified</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$i = 1;
							$requests = $controller->getAllRequests();
							foreach ($requests as $request) {
						?>
								<tr>
									<td><?= $i; ?></td>
									<td><?= $request['youtube_channel_name']; ?></td>
									<td><?= $request['request_type_name']; ?></td>
									<td><?= $request['artist_name']; ?></td>
									<td><?= $request['album_track_name']; ?></td>
									<td><span style="color: <?= $request['request_status_colour']; ?>;"><?= $request['request_status_name']; ?></span></td>
									<td><span style="color: <?= $request['request_status_colour']; ?>;"><?= $request['request_rejection_reason_name']; ?></span></td>
									<td><a href="<?= $request['completed_request_url']; ?>" target="_blank"><?= $request['completed_request_url']; ?></a></td>
									<td><?= $request['created']; ?></td>
									<td><?= $request['modified']; ?></td>
								</tr>
						<?php
								$i++;
							}
						?>
					</tbody>
					<tfoot>
						<tr>
							<th>#</th>
							<th>YouTube Channel Name</th>
							<th>Album/Track</th>
							<th>Artist Name</th>
							<th>Album/Track Name</th>
							<th>Status</th>
							<th>Rejection Reason</th>
							<th>Completed Request URL</th>
							<th>Created</th>
							<th>Modified</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function () {
			$('#requestsTable').DataTable({
				responsive: true
			});
			var i = 2;
			$('body').on("click", '.add-request-button', function() {
				if (i == 1) {
					i = 2;
				}
				$(this).parent().parent().after('<div class="card request-card mb-3" id="requestCard' + i + '"><div class="card-header">Request ' + i + ' <button type="button" id="removeRequestButton' + i +'" class="btn btn-outline-secondary float-end remove-request-button" title="Remove Request"><i class="fa-solid fa-minus"></i></button><button type="button" id="addRequestButton' + i +'" class="btn btn-outline-secondary float-end add-request-button" title="Add Another Request"><i class="fa-solid fa-plus"></i></button></div><div class="card-body"><label for="requestTypeIds" class="form-label">Request Type</label><select class="form-select form-select-md mb-3" aria-label=".form-select-lg example" name="requestTypeIds[]" required></select><div class="mb-3"><label for="artistName" class="form-label">Artist(s) Name</label><input type="text" class="form-control" name="artistNames[]" required></div><div class="mb-3"><label for="albumTrackName" class="form-label">Album/Track Name</label><input type="text" class="form-control" name="albumTrackNames[]" required></div></div></div>');
				$('#' + $(this).attr('id')).remove();
				i++;
				$('.request-card').each(function(index) {
					index = index + 1;
					numOfCards = $('.request-card').length;
					if (index > 1) {
						$(this).attr('id', 'requestCard' + index);
						if (index < numOfCards) {
							$(this).find('.card-header').html('Request ' + index + ' <button type="button" id="removeRequestButton' + index +'" class="btn btn-outline-secondary float-end remove-request-button" title="Remove Request"><i class="fa-solid fa-minus"></i></button>');
						} else if (index == numOfCards) {
								$(this).find('.card-header').html('Request ' + index + ' <button type="button" id="removeRequestButton' + index +'" class="btn btn-outline-secondary float-end remove-request-button" title="Remove Request"><i class="fa-solid fa-minus"></i></button><button type="button" id="addRequestButton' + index +'" class="btn btn-outline-secondary float-end add-request-button" title="Add Another Request"><i class="fa-solid fa-plus"></i></button>');
						}
					}
					$(this).find('select[name="requestTypeIds[]"]').empty();
					<?php foreach ($requestTypes as $requestType) { ?>
							$(this).find('select[name="requestTypeIds[]"]').append('<option value="<?= $requestType['id']; ?>"><?= $requestType['name']; ?></option>');
					<?php } ?>
				});
			});
			$('body').on("click", '.remove-request-button', function() {
				$(this).parent().parent().remove();
				i--;
				if (i > 2) {
					$('#requestCard' + i).find('.card-header').html('Request ' + i + ' <button type="button" id="removeRequestButton' + i +'" class="btn btn-outline-secondary float-end remove-request-button" title="Remove Request"><i class="fa-solid fa-minus"></i></button><button type="button" id="addRequestButton' + i +'" class="btn btn-outline-secondary float-end add-request-button" title="Add Another Request"><i class="fa-solid fa-plus"></i></button>');
				}
				if (i <= 2) {
					i = 1;
					$('#requestCard' + i).find('.card-header').html('Request ' + i + '<button type="button" id="addRequestButton' + i + '" class="btn btn-outline-secondary float-end add-request-button" title="Add Another Request"><i class="fa-solid fa-plus"></i></button>');
				}
				$('.request-card').each(function(index) {
					numOfCards = $('.request-card').length;
					index = index + 1;
					if (numOfCards == 1) {
						if (index == 1) {
							$('#requestCard' + i).find('.card-header').html('Request ' + i + '<button type="button" id="addRequestButton' + i + '" class="btn btn-outline-secondary float-end add-request-button" title="Add Another Request"><i class="fa-solid fa-plus"></i></button>');
						}
					} else {
						if (index > 1) {
							$(this).attr('id', 'requestCard' + index);
							if (index < numOfCards) {
								$(this).find('.card-header').html('Request ' + index + ' <button type="button" id="removeRequestButton' + index +'" class="btn btn-outline-secondary float-end remove-request-button" title="Remove Request"><i class="fa-solid fa-minus"></i></button>');
							} else if (index == numOfCards) {
									$(this).find('.card-header').html('Request ' + index + ' <button type="button" id="removeRequestButton' + index +'" class="btn btn-outline-secondary float-end remove-request-button" title="Remove Request"><i class="fa-solid fa-minus"></i></button><button type="button" id="addRequestButton' + index +'" class="btn btn-outline-secondary float-end add-request-button" title="Add Another Request"><i class="fa-solid fa-plus"></i></button>');
							}							
						}
					}
				});
			});
		});
	</script>
<?php include_once('templates/layout/footer.php'); ?>