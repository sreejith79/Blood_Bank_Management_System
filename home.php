<?php
    $i = 0;
    require_once 'php/DBConnect.php';
    $db = new DBConnect();
    $db->auth();

    //search by blood group
    if(isset($_POST['searchBtn'])) {
        $bloodGroup = $_POST['blood_group'];
        $donors = $db -> searchDonorWithBloodGroup($bloodGroup);
    }

    //search by city
    if(isset($_POST['searchByCityBtn'])) {
        $city = $_POST['city'];
        $donors = $db->searchDonorByCity($city);
    }
    $title = "HOME";
    $setHomeActivity = "active";
    include 'layout/_header.php';
    include 'layout/_top_nav.php';
?>
<div class="constainer">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="form-group col-md-12">
                <form action="home.php" method="post" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-6">Search for donor with blood group</label>
                        <div class="col-sm-4">
                            <select name="blood_group" class="form-control">
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
                        <div class="col-sm-2">
                            <button class="btn btn-info btn-sm" name="searchBtn">Search</button>
                        </div>
                    </div>
                </form>

                <form action="home.php" method="post" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-6">Search for donor by city</label>
                        <div class="col-sm-4">
                            <input type="text" name="city" value="" class="form-control" required>
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-info btn-sm" name="searchByCityBtn">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
    <div class="row">
        <div class="col-md-1">
            <div class="col-12">
                <?php if(isset($_POST['searchBtn']) || isset($_POST['searchByCityBtn'])): ?>
                    <?php if(isset($donors) && count($donors) > 0):?>
                        <table class="table table-condensed">
                            <tr>
                                <th>Index</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Mobile</th>
                                <th>Phone</th>
                                <th>Blood Group</th>
                            </tr>
                            <?php foreach($donors as $d): $i++; ?>
                                <tr class = "<?php if($i%2 == 0) {echo "bg-success"; } else {echo "bg-danger"; } ?>">
                                    <td><?= $i; ?></td>
                                    <td><?= $d['first_name'] . " " . $d['last_name']; ?></td>
                                    <td><?= $d['sex']; ?></td>
                                    <td><?= $d['address']; ?></td>
                                    <td><?= $d['city']; ?></td>
                                    <td><?= $d['mobile']; ?></td>
                                    <td><?= $d['phone']; ?></td>
                                    <td><?= $d['blood_type']; ?></td>
                                </tr>    
                            <?php  endforeach; ?>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-warning">No Records Found.</div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>