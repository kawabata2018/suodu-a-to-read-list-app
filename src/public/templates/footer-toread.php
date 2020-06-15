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
		function deleteToread(num) {
			var toreadId = parseInt(num);
			var res = confirm('本当に削除しますか？');
			if (res) {
				location.replace('/controller/DeleteToread-controller?toreadId='+toreadId);
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

		new Vue({
			el: '#appEdit',
			data() {
				return {
					bookName: document.getElementsByName('bookName')[0].value,
					authorName: document.getElementsByName('authorName')[0].value,
					memo: document.getElementsByName('memo')[0].value,
					currentPage: document.getElementsByName('currentPage')[0].value,
					totalPage: document.getElementsByName('totalPage')[0].value,
					isValid: true,
					error: {
						bookName: '',
						authorName: '',
						memo: '',
						currentPage: '',
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
				authorName:
					function(val) {
						if (val == '') {
							this.error.authorName = '作者名を入力してね'
						} else if (val.length > 50) {
							this.error.authorName = '50字以内で入力してね'
						} else {
							this.error.authorName = ''
						}
				},
				memo:
					function(val) {
						if (val == '') {
							this.error.memo = 'メモを入力してね'
						} else if (val.length > 100) {
							this.error.memo = '100字以内で入力してね'
						} else {
							this.error.memo = ''
						}
				},
				currentPage:
					function(val) {
						if (parseInt(val) <= 0 || parseInt(val) >= 1000000) {
							this.error.currentPage = '6桁以内の数値で入力してね'
						} else if (parseInt(val) > parseInt(this.totalPage)) {
							this.error.currentPage = '全ページ数を超えてるよ'
						} else {
							this.error.currentPage = ''
						}
				},
				totalPage:
					function(val) {
						if (parseInt(val) <= 0 || parseInt(val) >= 1000000) {
							this.error.totalPage = '6桁以内の数値で入力してね'
						} else {
							this.error.totalPage = ''
						}
				},
				error: {
					handler: function() {
						if (this.error.bookName == '' &&
							this.error.authorName == '' &&
							this.error.memo == '' &&
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