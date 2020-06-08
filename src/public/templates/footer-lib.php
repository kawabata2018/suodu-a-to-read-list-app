
	<footer class="section mt-2">
		<div class="text-center text-muted">&copy; Copyright 2020 Kawabata</div>
	</footer>

	<script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script type="text/javascript" src="/bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="/bootstrap-datepicker-1.9.0-dist/locales/bootstrap-datepicker.ja.min.js"></script>
	<script>
		function signOut() {
			var res = confirm('ログアウトしますか？');
			if (res) {
				location.replace('/controller/Logout-controller');
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
			let button = $(event.relatedTarget);
			let toreadid = parseInt(button.data('toreadid'));
			let currentpage = parseInt(button.data('currentpage'));
			let totalpage = parseInt(button.data('totalpage'));
			let modal = $(this);
			modal.find('#range').attr('value', currentpage);
			modal.find('#range').attr('max', totalpage);
			modal.find('#rangeMax').html("/ " + totalpage);
			modal.find('#toreadId').val(toreadid);

			// default
			$('#rangeValue').html(currentpage);
			$('#range').on('input change', function() {
				// update
				$('#rangeValue').html($(this).val());
			});
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
							this.error.totalpage = '6桁以内の数値で入力してね'
						} else {
							this.error.totalpage = ''
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
