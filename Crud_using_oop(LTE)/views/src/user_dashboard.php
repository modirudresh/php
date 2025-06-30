<div class="card">
            <div class="card-header">
                    <div class="row">
                        <h3 class="col-md-9">User Details</h3>                    
                    </div>
                </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover text-center">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Image</th>
                            <th>Gender</th><th>Contact No</th><th>Date of Birth</th><th>Hobby</th>
                        </tr>
                    </thead>
                    <tbody class="text-justify">
                        <?php if (!empty($users)): ?>
                            <?php $count = 0; ?>
                            <?php foreach ($users as $User): ?>
                                <?php if ($count++ >= 5) break; ?>
                                <tr id="user-row-<?= $User['id'] ?>">
                                    <td><?= htmlspecialchars($User['id']) ?></td>
                                    <td><?= htmlspecialchars($User['first_name']) ?></td>
                                    <td><?= htmlspecialchars($User['last_name'] ?? 'NA') ?></td>
                                    <td><?= htmlspecialchars($User['email']) ?></td>
                                    <td style="text-align: center;">
                                        <img src="<?= (!empty($User['image_path']) && file_exists('../../' . $User['image_path'])) ? '../../' . htmlspecialchars($User['image_path']) : '../../uploads/default.png' ?>" class="img-thumbnail mt-1 shadow-lg" style="width: 60px;">
                                    </td>
                                    <td class="text-center">
                                        <?= match ($User['gender']) {
                                            'male' => "<span class='badge badge-primary'>Male</span>",
                                            'female' => "<span class='badge' style='background-color:pink;'>Female</span>",
                                            'other' => "<span class='badge badge-secondary'>Other</span>",
                                            default => "<span>N/A</span>",
                                        }; ?>
                                    </td>
                                    <td><?= htmlspecialchars($User['phone_no']) ?></td>
                                    <td><?= htmlspecialchars($User['DOB']) ?></td>
                                    <td>
                                        <?php
                                        if (!empty($User['hobby'])) {
                                            foreach (explode(',', $User['hobby']) as $hobby) {
                                                echo "<span class='badge badge-info w-100'>" . htmlspecialchars(trim($hobby)) . "</span><br>";
                                            }
                                        } else {
                                            echo 'N/A';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="10" class="text-center">No users found.</td></tr>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>
            <div class="card-footer">
                <a href="../user/index.php" class="btn btn-primary float-right">See More</a>
            </div>
        </div>
