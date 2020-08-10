	<footer class="section mt-2">
		<div class="text-center text-muted">&copy; Copyright 2020 Kawabata</div>
	</footer>
	
	<script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script type="text/javascript" src="/public/js/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="/public/js/bootstrap-datepicker.ja.min.js"></script>
	<script>
		function signOut() {
			var res = confirm('ログアウトしますか？');
			if (res) {
				location.replace('/controller/Logout-controller');
			}
		}

		function backtoReading(num) {
			var toreadId = parseInt(num);
			var res = confirm('OKを押すと「読みたい」の本棚に戻します。');
			if (res) {
				location.replace('/controller/BacktoReading-controller?toreadId='+toreadId);
			}
		}

		// aboutme.php
		$('#followingBtn').on({
			'mouseenter': function() {
				$(this).text('フォロー解除');
			},
			'mouseleave': function() {
				$(this).text('フォロー中');
			},
			'click': function() {
				let res = confirm('フォローを解除しますか？');
				if (res) {
					let url = new URL(location);
					let paramId = url.searchParams.get('id');
					location.replace('/controller/Relation-controller?action=unfollow&id=' + paramId);
				}
			}
		});
		$('#requestingBtn').on({
			'mouseenter': function() {
				$(this).text('フォロー申請解除');
			},
			'mouseleave': function() {
				$(this).text('フォロー申請中');
			},
			'click': function() {
				let res = confirm('フォロー申請を解除しますか？');
				if (res) {
					let url = new URL(location);
					let paramId = url.searchParams.get('id');
					location.replace('/controller/Relation-controller?action=unfollow&id=' + paramId);
				}
			}
		});

		$(function(){
			$('#date').datepicker({
				autoclose: true,
				format: 'yyyy-mm-dd',
				disableTouchKeyboard: true,
				language: 'ja'
			})
		})

		$('#detailModal').on('show.bs.modal', function (event) {
			let $button = $(event.relatedTarget);
			let index = parseInt($button.data('index'));
			let $modal = $(this);

			$.ajax({
				cache: false,
				type: 'POST',
				url: './modal/library-detail.php',
				data: {'index': index},
				success: function(data) {
					$modal.find('#appDetail').html(data);
				}
			})

		})
	</script>
</body>

</html>