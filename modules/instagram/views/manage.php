<h2>Subscriptions</h2>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>Name</th>
				<th>Status</th>
				<th>Tag Subscribed To</th>
				<th>Preview</th>
				<th>Last Recieved</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
		<? foreach($subscriptions as $sub): ?>
			<tr>
				<td><?= $sub->alias ?></td>
				<td><?= $sub->status ?></td>
				<td><?= $sub->object_id ?></td>
				<td>
					<? $images = $sub->preview_images(3);?>
					<? foreach($images as $image): ?>
						<img width="50" height="50" src="<?= $image->thumb_img ?>" />
					<? endforeach; ?>
				</td>
				<td><?= $sub->last_image_received ? strftime('%d/%m/%Y %H:%M', $sub->last_image_received) : 'No Images Received' ?></td>
				<td>
					<? if($sub->status != 'Disabled'): ?>
					<a href="/admin/instagram/manage/approval/<?= $sub->instagram_subscription_id ?>" class="btn btn-info btn-mini">Approve Images</a>
					<a href="/admin/instagram/manage/unsubscribe/<?= $sub->instagram_subscription_id ?>" class="btn btn-danger btn-mini">Unsubscribe</a>
					<? endif ?>
				</td>
			</tr>
		<? endforeach ?>
		</tbody>
	</table>

	<div class="row">
		<div class="span12">
			<?= $fieldset ?>
		</div>
	</div>
