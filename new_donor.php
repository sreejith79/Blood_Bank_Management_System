<?php
    $sucess = NULL;
    $message = NULL;
    if(isset($_POST['submitBtn'])) {
        $fname = $_POST['firstName'];
        $lname = $_POST['lastName'];
        $sex = $_POST['sex'];
        $bType = $_POST['b_type'];
        $dob = $_POST['dob'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $mobile = $_POST['mobile'];
        $phone = $_POST['phone'];
        $donationDate = $_POST['don_date'];
        $weight = $_POST['weight'];

        require_once 'php/DBConnect.php';
        $db = new DBConnect();
        $flag = $db->addDonor($fname, $lname, $sex, $bType, $dob, $address, $city, $donationDate, $weight, $phone, $mobile);
        if($flag) {
            $success = "The donor has been successfully added to the database!";
        } else {
            $message = "There was some error saving the user to the database!";
        }
    }
    $title = "Donor";
    $setDonorActive = "active";
    include 'layout/_header.php';
    include 'layout/_top_nav.php';
?>

<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <?php if(isset($success)): ?>
            <div class="alert-success fade-out-5"><?= $success; ?></div>
            <?php endif; ?>
            <?php if(isset($message)): ?>
            <div class="alert-danger fade-out-5"><?= $message; ?></div>
            <?php endif; ?>

            <form action="new_donor.php" class="form-horizontal" method="post">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5>Donor Basic Info</h5>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3">Name</label>
                            <div class="col-sm-3">
                                <input type="text" name="firstName" placeholder="First Name" class="form-control" required>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" name="lastName" placeholder="Last Name" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4">Gender</label>
                            <div class="col-sm-4 radio-inline">
                                <input type="radio" value="male" name="sex" checked="true">Male                         
                            </div>
                            <input type="radio" value="female" name="sex">Female 
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4">Blood Type</label>
                            <div class="col-sm-8">
                                <select name="b_type" class="form-control">
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4">DOB</label>
                            <div class="col-sm-8">
                                <input type="date" name="dob" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4">Address</label>
                            <div class="col-sm-8">
                                <textarea name="address" class="form-control" rows="8" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4">City</label>
                            <div class="col-sm-8">
                                <input type="text" name="city" class="form-control" required="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4">Mobile</label>
                            <div class="col-sm-8">
                                <input type="number" min="0" max = "10000000000" name="mobile" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4">Phone</label>
                            <div class="col-sm-8">
                                <input type="number" min="0" max = "10000000000" name="phone" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="panel-heading">
                        <h5>Donor Medical Info</h5>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-4">Date of Donation</label>
                            <div class="col-sm-8">
                                <input type="date" name="don_date" value="" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4">Weight</label>
                            <div class="col-sm-8">
                                <input type="number" step="0.01" name="weight" value="" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4"></label>
                            <div class="col-sm-4">
                                <button class="btn btn-success" type="submit" name="submitBtn">Add Donor</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>