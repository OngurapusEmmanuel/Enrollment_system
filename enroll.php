<?php
require_once "includes/sessions.php";
if (isset($_SESSION["name"])) {

    header("Location:index.php");
   
  }
  else {
      header("Location:login.php");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enroll Clients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="images/bethel.png" type="image/x-icon">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .step {
            display: none;
        }
        .step.active {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Enroll Client</h1>
        <form id="enrollForm" method="POST" action="submit_enrollment.php">
            <!-- Step 1: Personal Information -->
            <div class="step active" id="step1">
                <h3>Step 1: Personal Information</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="firstname" class="form-label">First Name:</label>
                        <input type="text" id="firstname" name="firstname" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label for="lastname" class="form-label">Last Name:</label>
                        <input type="text" id="lastname" name="lastname" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone Number:</label>
                        <input type="text" id="phone" name="phone" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label for="age" class="form-label">Age:</label>
                        <input type="number" id="age" name="age" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Gender:</label><br>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="male" name="gender" value="M" class="form-check-input" required>
                            <label for="male" class="form-check-label">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="female" name="gender" value="F" class="form-check-input" required>
                            <label for="female" class="form-check-label">Female</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="parent_name" class="form-label">Parents' Name:</label>
                        <input type="text" id="parent_name" name="parent_name" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label for="parent_occupation" class="form-label">Occupation of Parent:</label>
                        <input type="text" id="parent_occupation" name="parent_occupation" class="form-control" required>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <button type="button" class="btn btn-primary" onclick="nextStep(2)">Next</button>
                </div>
            </div>

            <!-- Step 2: Disability Information -->
            <div class="step" id="step2">
                <h3>Step 2: Disability Information</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="education" class="form-label">Educational Qualification:</label>
                        <input type="text" id="education" name="education" class="form-control" required>
                    </div>
    
                    <div class="col-md-6">
                        <label for="category" class="form-label">Category (SC/ST/Other):</label>
                        <input type="text" id="category" name="category" class="form-control" required>
                    </div>
                    <label class="form-label">Types of Disabilities:</label><br>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="disabilities[0]" value="CP" class="form-check-input" id="cp">
                        <label for="cp" class="form-check-label">C.P</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="disabilities[1]" value="Autism" class="form-check-input" id="autism">
                        <label for="autism" class="form-check-label">Autism</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="disabilities[2]" value="MR" class="form-check-input" id="mr">
                        <label for="mr" class="form-check-label">MR</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="disabilities[3]" value="MD" class="form-check-input" id="md">
                        <label for="md" class="form-check-label">MD</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" name="disabilities[4]" value="Other" class="form-check-input" id="other">
                        <label for="other" class="form-check-label">Other</label>
                    </div>

                    <div  class="col-md-6" >
                        <label for="other1" class="form-check-label">Please state:</label>
                        <input type="text" name="disabilities[4]" class="form-control" id="other1">
                        
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Disability Certificate:</label><br>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="disability_yes" name="disability_certificate" value="Yes" class="form-check-input" required>
                            <label for="disability_yes" class="form-check-label">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" id="disability_no" name="disability_certificate" value="No" class="form-check-input" required>
                            <label for="disability_no" class="form-check-label">No</label>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <button type="button" class="btn btn-secondary" onclick="previousStep(1)">Previous</button>
                    <button type="button" class="btn btn-primary" onclick="nextStep(3)">Next</button>
                </div>
            </div>

            <!-- Step 3: Support and Benefits -->
            <div class="step" id="step3">
                <h3>Step 3: Support and Benefits</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="bpl" class="form-label">BPL:</label>
                        <select id="bpl" name="bpl" class="form-select" required>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Support from Govt/NGO:</label><br>
                        <div class="form-check">
                            <input type="checkbox" name="support[0]" value="Scholarship" class="form-check-input" id="scholarship">
                            <label for="scholarship" class="form-check-label">Scholarship</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="support[1]" value="Pension" class="form-check-input" id="pension">
                            <label for="pension" class="form-check-label">Pension</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="support[2]" value="Training" class="form-check-input" id="training">
                            <label for="training" class="form-check-label">Training</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="support[3]" value="Loan" class="form-check-input" id="loan">
                            <label for="loan" class="form-check-label">Loan</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="support[4]" value="Others" class="form-check-input" id="others">
                            <label for="others" class="form-check-label">Others</label>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <button type="button" class="btn btn-secondary" onclick="previousStep(2)">Previous</button>
                    <button type="button" class="btn btn-primary" onclick="nextStep(4)">Next</button>
                </div>
            </div>

            <!-- Step 4: Guardian and Health Insurance -->
            <div class="step" id="step4">
                <h3>Step 4: Guardian and Health Insurance</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="guardian_name" class="form-label">Name of Guardian:</label>
                        <input type="text" id="guardian_name" name="guardian_name" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label for="guardian_relation" class="form-label">Relationship with Guardian:</label>
                        <input type="text" id="guardian_relation" name="guardian_relation" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label for="health_insurance" class="form-label">Health Insurance for PwDs:</label>
                        <select id="health_insurance" name="health_insurance" class="form-select" required>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="other_info" class="form-label">Other Information:</label>
                        <textarea id="other_info" name="other_info" class="form-control"></textarea>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <button type="button" class="btn btn-secondary" onclick="previousStep(3)">Previous</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 4;

        function nextStep(step) {
            if (step <= totalSteps) {
                document.getElementById('step' + currentStep).classList.remove('active');
                currentStep = step;
                document.getElementById('step' + currentStep).classList.add('active');
            }
        }

        function previousStep(step) {
            if (step >= 1) {
                document.getElementById('step' + currentStep).classList.remove('active');
                currentStep = step;
                document.getElementById('step' + currentStep).classList.add('active');
            }
        }
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        let otherCheckbox = document.getElementById("other");
        let otherInput = document.getElementById("other1");

        otherCheckbox.addEventListener("change", function () {
            if (this.checked) {
                otherInput.style.display = "block";
                otherInput.required = true; // Make input required
            } else {
                otherInput.style.display = "none";
                otherInput.required = false;
                otherInput.value = ""; // Clear input when hidden
                this.value = "Other"; // Reset checkbox value
            }
        });

        otherInput.addEventListener("input", function () {
            if (otherCheckbox.checked) {
                otherCheckbox.value = this.value; // Set checkbox value to input value
            }
        });

        // Hide input initially
        otherInput.style.display = "none";
    });
</script>
</body>
</html>
<script>
    // document.addEventListener("DOMContentLoaded", function () {
    //     let otherCheckbox = document.getElementById("other");
    //     let otherInput = document.getElementById("other1");

    //     otherCheckbox.addEventListener("change", function () {
    //         if (this.checked) {
    //             otherInput.style.display = "block";
    //         } else {
    //             otherInput.style.display = "none";
    //             otherInput.value = ""; // Clear input when hidden
    //         }
    //     });

    //     // Hide input initially
    //     otherInput.style.display = "none";
    // });
</script>






   