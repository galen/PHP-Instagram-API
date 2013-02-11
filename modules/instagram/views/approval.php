<div class="tabbable"> <!-- Only required for left/right tabs -->
  <ul class="nav nav-tabs">
    <li class="active">
    	<a href="#unsorted" data-toggle="tab">Unsorted 
    		<span class="badge badge-warning unsorted-cnt"><?= isset($image_counts['unsorted']) ? $image_counts['unsorted'] : '0' ?></span>
    	</a>
    </li>
    <li>	
    	<a href="#approved" data-toggle="tab">Approved 
    		<span class="badge badge-warning approved-cnt"><?= isset($image_counts['accepted']) ? $image_counts['accepted'] : '0' ?></span>
    	</a>
    </li>
    <li>
    	<a href="#rejected" data-toggle="tab">Rejected 
    		<span class="badge badge-warning rejected-cnt"><?= isset($image_counts['declined']) ? $image_counts['declined'] : '0'  ?></span>
    	</a>
    </li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="unsorted">
      <div class="row images-container">
			<? foreach($unsorted_images as $image): ?>
				<img class="span2 instagram-img unsorted" data-image-id="<?= $image['id'] ?>" style="margin-bottom: 15px;" src="<?= $image['thumb_img'] ?>" />
			<? endforeach ?>
		</div>
		<input type="hidden" name="unsorted_image_count" value="<?= isset($image_counts['unsorted']) ? $image_counts['unsorted'] : 0 ?>">
    </div>
    <div class="tab-pane" id="approved">
      <div class="row images-container">
			<? foreach($accepted_images as $image): ?>
				<img class="span2 instagram-img accepted" data-image-id="<?= $image['id'] ?>" style="margin-bottom: 15px;" src="<?= $image['thumb_img'] ?>" />
			<? endforeach ?>
		</div>
      	<input type="hidden" name="approved_image_count" value="<?= isset($image_counts['accepted']) ? $image_counts['accepted'] : 0 ?>">
    </div>
    <div class="tab-pane" id="rejected">
      <div class="row images-container">
			<? foreach($declined_images as $image): ?>
				<img class="span2 instagram-img declined" data-image-id="<?= $image['id'] ?>" style="margin-bottom: 15px;" src="<?= $image['thumb_img'] ?>" />
			<? endforeach ?>
		</div>
      <input type="hidden" name="rejected_image_count" value="<?= isset($image_counts['declined']) ? $image_counts['declined'] : 0 ?>">
    </div>
  </div>
</div>


<input type="hidden" name="subscription_id" value="<?= $subscription_id ?>">

<script>
		$(function(){

			var iterations = [];
			iterations['#unsorted'] = 1;
			iterations['#approved'] = 1;
			iterations['#rejected'] = 1;
			var images = [];
			images['#unsorted'] = parseInt($('input[name="unsorted_image_count"]').val());
			images['#approved'] = parseInt($('input[name="approved_image_count"]').val());
			images['#rejected'] = parseInt($('input[name="rejected_image_count"]').val());
			var sub_id = parseInt($('input[name="subscription_id"]').val());
			var max_iterations = [];
			max_iterations['#unsorted'] = parseInt(images['#unsorted'] / 42);
			max_iterations['#approved'] = parseInt(images['#approved'] / 42);
			max_iterations['#rejected'] = parseInt(images['#rejected'] / 42);
			var current_tab;
			var active_popover;

			$(window).scroll(function() {

				if ($(window).scrollTop() == $(document).height() - $(window).height()) {

					current_tab = $('.nav-tabs .active a').attr('href');

					var offset = 42 * iterations[current_tab];
					if(max_iterations[current_tab] > 1 && offset < images[current_tab]) {

						iterations[current_tab]++;

						$.post('/admin/instagram/ajax/more.json', {'offset' : offset, 'subscription' : sub_id}, function(data){
							$.each(data.images, function(index, img){
								$(current_tab).find('.images-container').append($('<img>').attr({
									'src' : img.thumb_img,
									'data-image-id' : img.id
								}).addClass('span2 instagram-img unsorted'));
							});
						});
					}
				}
			});

			$('.nav-tabs a').click(function(){
				if(active_popover) {
					active_popover.popover('destroy');
				}
			});

			$('.instagram-img').live('click', function(){

				if(active_popover) {
					active_popover.popover('destroy');
				}

				$(this).popover({
					'html' : true,
					'content' : get_content($(this)),
					'title' : 'Image Actions',
					'placement' : 'right',
				}).popover('show');

				active_popover = $(this);

			});

			function get_content($img)
			{
				var html = $('<div></div>');

				if(!$img.hasClass('accepted')) {
					html.append($('<a>Approve</a>').attr({
					'href' : '#',
					'data-status' : 'accepted',
					'data-image-id' : $img.attr('data-image-id')
					}).addClass('btn post-image-status'));
				}

				if(!$img.hasClass('declined')) {
					html.append($('<a>Reject</a>').attr({
					'href' : '#',
					'data-status' : 'declined',
					'data-image-id' : $img.attr('data-image-id')
					}).addClass('btn post-image-status'));
				}

				return html;
			}

			function move_to(target, $img) {
				var clone = $img.clone();

				clone.removeClass('declined accepted unsorted');
				if(target == '#approved') {
					clone.addClass('accepted');
				} else {
					clone.addClass('rejected');
				}

				$(target).find('.images-container').append(clone);
				clone.show();

				$img.fadeOut(400, function(){
					active_popover.popover('destroy');
					$(this).remove();
				});

			}
			
			$('.post-image-status').live('click', function(e){

				e.preventDefault();

				var $this = $(this);
				var status = $this.attr('data-status');
				var image_id = $this.attr('data-image-id');

				$.post('/admin/instagram/ajax/status.json', {
					'status' : status, 
					'image' : $this.attr('data-image-id')
				}, function(data){
					current_tab = $('.nav-tabs .active a').attr('href');
					switch(current_tab) {
						case '#unsorted':
							images['#unsorted']--;
							$('.unsorted-cnt').text(images['#unsorted']);
							$('input[name="unsorted_image_count"]').val(images['#unsorted']);

							if(status == 'accepted') {
								images['#approved']++;
								$('.approved-cnt').text(images['#approved']);
								$('input[name="approved_image_count"]').val(images['#approved']);
								move_to('#approved', $('img[data-image-id="' + image_id + '"]'));
							} else {
								images['#rejected']++;
								$('.rejected-cnt').text(images['#rejected']);
								$('input[name="rejected_image_count"]').val(images['#rejected']);
								move_to('#rejected', $('img[data-image-id="' + image_id + '"]'));
							}
						break;
						case '#approved':
							images['#approved']--;
							$('.approved-cnt').text(images['#approved']);
							$('input[name="approved_image_count"]').val(images['#approved']);
							images['#rejected']++;
							$('.rejected-cnt').text(images['#rejected']);
							$('input[name="rejected_image_count"]').val(images['#rejected']);
							move_to('#rejected', $('img[data-image-id="' + image_id + '"]'));
						break;
						case '#rejected':
							images['#rejected']--;
							$('.rejected-cnt').text(images['#rejected']);
							$('input[name="rejected_image_count"]').val(images['#rejected']);
							images['#approved']++;
							$('.approved-cnt').text(images['#approved']);
							$('input[name="approved_image_count"]').val(images['#approved']);
							move_to('#approved', $('img[data-image-id="' + image_id + '"]'));
						break;
					}
				});
			});




		});
</script>

