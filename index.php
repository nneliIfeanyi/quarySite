<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Event Registration</title>
	<link rel="stylesheet" href="./assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="./assets/css/main.css">
	<link rel="stylesheet" href="./assets/css/animation.css">
	<style>
		.nav-link:hover {
			opacity: .8;
		}
	</style>
</head>

<body>
	<!-- Nav -->
	<nav class="navbar navbar-expand-lg navbar-light shadow-sm py-0">
		<div class="container">
			<!-- Navbar Brand - Logo -->
			<h2 class="navbar-brand bg-success fs-3 py-4 px-3 mb-0">
				<a href="" class="text-white">Revival Labourers</a>
			</h2>
			<!-- Mobile Hambuger -->
			<button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav"
				arial-controls="navbarNav" aria-expanded="false" aria-label="Toggle Navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<!-- Nav Links -->
			<div class="collapse navbar-collapse py-5 py-lg-0" id="navbarNav">
				<ul class="navbar-nav ms-auto">
					<li class="nav-item mx-lg-3 mb-3 mb-lg-0 fs-5 fw-semibold">
						<a href="" class="nav-link">HOME</a>
					</li>
					<li class="nav-item mx-lg-3 mb-3 mb-lg-0 fs-5 fw-semibold">
						<a href="" class="nav-link">ABOUT</a>
					</li>
					<li class="nav-item mx-lg-3 mb-3 mb-lg-0 fs-5 fw-semibold">
						<a href="" class="nav-link">RESOURCES</a>
					</li>
					<li class="nav-item mx-lg-3 mb-3 mb-lg-0 fs-5 fw-semibold">
						<a href="" class="nav-link">EVENTS</a>
					</li>
					<li class="nav-item mx-lg-3 mb-3 mb-lg-0 fs-5 fw-semibold">
						<a href="" class="nav-link">CONTACT</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<!-- Main -->
	<main class="d-flex align-items-center justify-content-center py-5">
		<div class="container mt-5">
			<div class="row gy-5 justify-content-around p-3">
				<!-- Registration Card Section -->
				<div class="col-lg-7 col-md-10 reg-card shadow p-4 pt-5 rounded-4">
					<!-- Card Header -->
					<div class="reg-card-header mb-4">
						<h2>Event Registration</h2>
					</div>
					<!-- Card Body -->
					<div class="reg-card-body">
						<!-- Form -->
						<form action="process_registration.php" method="POST" id="register"
							class="registration-form needs-validation">
							<!-- Form Step 1 -->
							<div class="form-group form-step step-1 mb-2">
								<div class="row">
									<div class="mb-3">
										<label>Title &nbsp;<span class="opacity-75" style="font-size: x-small;">(Mr. | Mrs. |
												etc)</span></label>
										<input type="text" name="title" class="form-control form-control-lg">
									</div>
									<div class="mb-3">
										<label>Surname</label>
										<input type="text" name="surname" required class="form-control form-control-lg">
									</div>
									<div class="mb-3">
										<label>Others Names</label>
										<input type="text" name="othernames" required class="form-control form-control-lg">
									</div>
									<div class="mb-3">
										<label class="mb-3">Gender</label>
										<div class="d-flex align-items-center">
											<div class="me-5">
												<input type="radio" required name="gender" value="Male" class="form-check-input fs-5 mt-0 me-1"
													id="Male">
												<label for="Male" class="form-check-label">Male</label>
											</div>
											<div class="me-5">
												<input type="radio" required name="gender" value="Female"
													class="form-check-input fs-5 mt-0 me-1" id="Female">
												<label for="Female" class="form-check-label">Female</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- Form Step 2 -->
							<div class="form-group form-step step-2 mb-2 d-none">
								<div class="mb-3">
									<label>Email Address</label>
									<input type="email" name="email" data-parsley-type="email" data-parsley-trigger="keyup"
										class="form-control form-control-lg">
								</div>
								<div class="mb-3">
									<label>Phone Number</label>
									<input type="number" name="phone" required data-parsley-type='number' maxlength="11"
										data-parsley-length="[11, 11]" data-parsley-trigger="keyup" pattern="\d{11}"
										class=" form-control form-control-lg">
								</div>
								<div class="mb-3">
									<label>Age Bracket</label>
									<select class="form-control form-control-lg" name="age" required>
										<option value="">Please Select</option>
										<option value="13-18">13 - 18 years</option>
										<option value="19-25">19 - 25 years</option>
										<option value="26-35">26 - 35 years</option>
										<option value="36-45">36 - 45 years</option>
										<option value="46-69">46 - 59 years</option>
										<option value="60upwards">60 and Above</option>
									</select>
								</div>
								<div class="mb-3">
									<label>Marital Status</label>
									<select class="form-control form-control-lg" name="m_status" required>
										<option value="">Please Select</option>
										<option value="Single">Single</option>
										<option value="Engaged">Engaged</option>
										<option value="Married">Married</option>
										<option value="Separated">Separated</option>
										<option value="Divorced">Divorced</option>
										<option value="Widow">Widow</option>
										<option value="Widower">Widower</option>
									</select>
								</div>
							</div>
							<!-- Form Step 3 -->
							<div class="form-group form-step step-1 mb-2 d-none">
								<div class="mb-3">
									<label>Residential Address</label>
									<input type="text" name="residence" required class="form-control form-control-lg">
								</div>
								<div class="row">
									<div class="col-6 mb-3">
										<label>L.G.A of Residence</label>
										<input type="text" name="lga" required class="form-control form-control-lg">
									</div>
									<div class="col-6 mb-3">
										<label>State of Residence</label>
										<input type="text" name="r_state" required class="form-control form-control-lg">
									</div>
								</div>
								<div class="mb-3">
									<label>Occupation</label>
									<input type="text" name="work" class="form-control form-control-lg">
								</div>
								<div class="mb-3">
									<label>Trained As&nbsp;&nbsp;<span style="font-size: x-small;">(optional)</span></label>
									<input type="text" name="trainedAs" class="form-control form-control-lg">
								</div>
								<div class="mb-3">
									<label>Church Name And Address</label>
									<input type="text" name="l_assembly" class="form-control form-control-lg">
								</div>
							</div>
							<!-- Form Buttons -->
							<div class="buttons d-flex align-items-center justify-content-between flex-wrap pt-5 pb-3">
								<button type="button" id="prevBtn" class="prev-step btn btn-secondary btn-lg px-5">Previous</button>
								<button type="button" id="nextBtn" class="next-step btn btn-success btn-lg px-5">Next</button>
							</div>
						</form>
					</div>
				</div>
				<!-- Dowload Existing tag Section -->
				<div class="col-lg-4 col-md-10 download shadow p-4 pt-5 rounded-4 h-75">
					<h2 class="mb-4">Download Existing Tag</h2>
					<form action="process_registration.php" method="POST" class="needs-validation pb-3" novalidate>
						<div class="mb-5">
							<label for="regId" class="form-label">Registration ID</label>
							<input type="text" class="form-control" id="regId" name="reg_id_download" required>
							<div class="invalid-feedback">
								Please enter your Registration ID.
							</div>
						</div>
						<button type="submit" class="next-step btn btn-success btn-lg px-5">Download Tag</button>
					</form>
				</div>
			</div>
		</div>
	</main>


	<script src="./assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="./assets/js/registerForm.js"></script>
	<script>
		// Bootstrap client-side validation
		(function () {
			'use strict'
			var forms = document.querySelectorAll('.needs-validation')
			Array.prototype.slice.call(forms)
				.forEach(function (form) {
					form.addEventListener('submit', function (event) {
						if (!form.checkValidity()) {
							event.preventDefault()
							event.stopPropagation()
						}
						form.classList.add('was-validated')
					}, false)
				})
		})()
	</script>
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const urlParams = new URLSearchParams(window.location.search);
			const status = urlParams.get('status');
			const regTag = urlParams.get('reg_tag');

			if (status === 'success' && regTag) {
				const successModal = new bootstrap.Modal(document.getElementById('registrationSuccessModal'));
				document.getElementById('displayRegTag').innerText = `Your Tag: ${regTag}`;
				document.getElementById('downloadTagLink').href = `process_registration.php?reg_id_download=${regTag}`;
				successModal.show();

				// Clear URL parameters after showing modal to prevent it from reappearing on refresh
				window.history.replaceState({}, document.title, window.location.pathname);
			}
		});
	</script>

	<!-- Success Modal -->
	<div class="modal fade" id="registrationSuccessModal" tabindex="-1" aria-labelledby="registrationSuccessModalLabel"
		aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="registrationSuccessModalLabel">Registration Successful!</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body text-center">
					<p>Your registration was successful. Please download your registration tag below.</p>
					<h4 id="displayRegTag"></h4>
					<a href="#" id="downloadTagLink" class="btn btn-primary mt-3">Download Registration Tag</a>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</body>

</html>