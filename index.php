<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>Event Registration</h2>
                    </div>
                    <div class="card-body">
                        <form action="process_registration.php" method="POST" id="register" class="needs-validation" novalidate>
                                <div class="form-group mb-2">
                                    <div class="row">
                                        <div class="col-4">
                                            <label>Title &nbsp;<span style="font-size: xx-small;">mr | mrs | etc</span></label>
                                            <input type="text" name="title" class="form-control form-control-lg">
                                        </div>
                                        <div class="col-8">
                                            <label>Surname</label>
                                            <input type="text" name="surname" required class="form-control form-control-lg">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Others Names</label>
                                    <input type="text" name="othernames" required class="form-control form-control-lg">
                                </div>
                                <div class="form-group mb-4">
                                    <label>Gender</label>
                                    <div class=" border  p-2">
                                        <input type="radio" required name="gender" value="Male" class="form-check-input fs-5" id="Male">
                                        <label for="Male" class="form-check-label me-2">Male</label>

                                        <input type="radio" required name="gender" value="Female" class="form-check-input fs-5" id="Female">
                                        <label for="Female" class="form-check-label me-2">Female</label>
                                    </div>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Email Address</label>
                                    <input type="email" name="email" data-parsley-type="email" data-parsley-trigger="keyup" class="form-control form-control-lg">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Phone Number</label>
                                    <input type="number" name="phone" required data-parsley-type='number' maxlength="11" data-parsley-length="[11, 11]" data-parsley-trigger="keyup" pattern="\d{11}" class=" form-control form-control-lg">
                                </div>
                                <div class="form-group mb-4">
                                    <label>Age Bracket</label>
                                    <select class="form-control form-control-lg" name="age" required>
                                        <option value="">--Please Select--</option>
                                        <option value="13-18">13 - 18 years</option>
                                        <option value="19-25">19 - 25 years</option>
                                        <option value="26-35">26 - 35 years</option>
                                        <option value="36-45">36 - 45 years</option>
                                        <option value="46-69">46 - 59 years</option>
                                        <option value="60upwards">60 and Above</option>
                                    </select>
                                </div>
                                <div class="form-group mb-4">
                                    <label>Marital Status</label>
                                    <select class="form-control form-control-lg" name="m_status" required>
                                        <option value="">--Please Select--</option>
                                        <option value="Single">Single</option>
                                        <option value="Engaged">Engaged</option>
                                        <option value="Married">Married</option>
                                        <option value="Separated">Separated</option>
                                        <option value="Divorced">Divorced</option>
                                        <option value="Widow">Widow(er)</option>
                                    </select>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Residential Address</label>
                                    <input type="text" name="residence" required class="form-control form-control-lg">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label>L.G.A of Residence</label>
                                        <input type="text" name="lga" required class="form-control form-control-lg">
                                    </div>
                                    <div class="col-6">
                                        <label>State of Residence</label>
                                        <input type="text" name="r_state" required class="form-control form-control-lg">
                                    </div>
                                </div>
                                <div class="form-group mb-2">
                                    <label>Occupation</label>
                                    <input type="text" name="work" class="form-control form-control-lg">
                                </div>
                                <div class="form-group mb-2">
                                    <label>Trained As&nbsp;&nbsp;<span style="font-size: x-small;">(optional)</span></label>
                                    <input type="text" name="trainedAs" class="form-control form-control-lg">
                                </div>
                                <div class="form-group mb-2">
                                    <label>Church Name And Address</label>
                                    <input type="text" name="l_assembly" class="form-control form-control-lg">
                                </div>
                                <div id="ajaxRes"></div>
                                <div class="d-grid mt-4">
                                    <input type="submit" id="submit" class="btn btn-success" value="Register Now">
                                </div>
                            </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mt-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>Download Existing Registration Tag</h2>
                            </div>
                    <div class="card-body">
                        <form action="process_registration.php" method="POST" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="regId" class="form-label">Registration ID</label>
                                <input type="text" class="form-control" id="regId" name="reg_id_download" required>
                                <div class="invalid-feedback">
                                    Please enter your Registration ID.
                                </div>
                            </div>
                            <button type="submit" class="btn btn-secondary">Download Tag</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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

    <!-- Success Modal -->
    <div class="modal fade" id="registrationSuccessModal" tabindex="-1" aria-labelledby="registrationSuccessModalLabel" aria-hidden="true">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
</body>
</html>
