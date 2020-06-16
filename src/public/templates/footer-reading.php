
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

		function finishReading(num) {
			var toreadId = parseInt(num);
			var res = confirm('OKを押すと「読んだ」の本棚に移動します。');
			if (res) {
				location.replace('/controller/FinishReading-controller?toreadId='+toreadId);
			}
		}

		$(function(){
			$('#date').datepicker({
				autoclose: true,
				format: 'yyyy-mm-dd',
				disableTouchKeyboard: true,
				language: 'ja'
			})
		})

		$('#progressModal').on('show.bs.modal', function (event) {
			let $button = $(event.relatedTarget);
			let toreadId = parseInt($button.data('toreadid'));
			let currentPage = parseInt($button.data('currentpage'));
			let totalPage = parseInt($button.data('totalpage'));
			let $modal = $(this);
			$modal.find('form')[0].reset();
			$modal.find('#range').attr('value', currentPage);
			$modal.find('#range').attr('max', totalPage);
			$modal.find('#rangeMax').html("/ " + totalPage);
			$modal.find('#toreadId').val(toreadId);

			// default
			$modal.find('#rangeValue').html(currentPage);
			$modal.find('#range').on('input change', function() {
				// update
				$('#rangeValue').html($(this).val());
			});
		})

		$('#detailModal').on('show.bs.modal', function (event) {
			let $button = $(event.relatedTarget);
			let index = parseInt($button.data('index'));
			let $modal = $(this);

			$.ajax({
				cache: false,
				type: 'POST',
				url: './modal/reading-detail.php',
				data: {'index': index},
				success: function(data) {
					$modal.find('#appDetail').html(data);
				}
			})

		})

		new Vue({
			el: '#appAdd',
			data() {
				return {
					bookName: '',
					totalPage: '',
					isValid: true,
					error: {
						bookName: '',
						totalPage: ''
					}
				}
			},
			watch: {
				bookName:
					function(val) {
						if (val == '') {
							this.error.bookName = '書名を入力してね'
						} else if (val.length > 50) {
							this.error.bookName = '50字以内で入力してね'
						} else {
							this.error.bookName = ''
						}
				},
				totalPage:
					function(val) {
						if (val <= 0 || val >= 1000000) {
							this.error.totalPage = '6桁以内の数値で入力してね'
						} else {
							this.error.totalPage = ''
						}
				},
				error: {
					handler: function() {
						if (this.error.bookName == '' &&
							this.error.totalPage == '') {
							this.isValid = true
						} else {
							this.isValid = false
						}
					},
					deep: true
				}
			}
		})
		
	</script>
</body>

</html>
