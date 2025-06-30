<div class="card">
            <div class="card-header">
                    <div class="row">
                        <h3 class="col-md-9">Student Details</h3>                    
                    </div>
                </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover text-center">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Contact No</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody class="text-justify">
                        <?php if (!empty($students)): ?>
                            <?php $count = 0; ?>
                            <?php foreach ($students as $student): ?>
                                <?php if ($count++ >= 5) break; ?>
                                <tr id="student-row-<?= $student['id'] ?>">
                                    <td><?= htmlspecialchars($student['id'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($student['first_name'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($student['last_name'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($student['email'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($student['phone_no'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($student['address'] ?? '') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7" class="text-center">No students found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="../student/index.php" class="btn btn-primary float-right">See More</a>
            </div>
        </div>