<div class="footer">
		<p class="copyright text-muted ">Copyright &copy; 2016 -
			<?= date('Y') ?>
			& Onwords Central ICT , Art of Living International Center, Bangalore. All rights reserved. Version 3.2.0</p>
	</div>









	<!-- TODO End: -->

	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src="<? echo  base_url(); ?>js/jquery.1.11.0.min.js"></script>
	<script src="<? echo  base_url(); ?>js/bootstrap.min.js"></script>
	<script>
		$('[rel="popover"]').popover();

		function validateEmail(email) {
			var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(email);
		}

		$("#forrm form").submit(function(event) {
			if ($("[name='ashram']").val() == "") {
				alert("Please select the ashram first!");
				event.preventDefault();
				return false;
			}
			if ($("[name='email_address']").val() == "" || $("[name='password']").val() == "") {
				alert("Please fill the login credentials!");
				event.preventDefault();
				return false;
			}



			if (!validateEmail($("[name='email_address']").val())) {
				alert("Invalid email address!");
				event.preventDefault();
			}

		});
	</script>

	<script>
		function myFunction() {
			var x = document.getElementById("myTopnav");
			if (x.className === "topnav") {
				x.className += " responsive";
			} else {
				x.className = "topnav";
			}
		}
	</script>




</body>

</html>