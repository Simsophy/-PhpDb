<?php
include('../config.php');
include('../function.php');
$title = "Employees";
include('../includes/header.php');

// query must return `title` from table
$rows = query("SELECT *, CONCAT(first_name, ' ', last_name) AS name FROM employees");
?>

<body>
    <div class="container">
        <?php alert_success(); ?>
    <?php alert_error(); ?>
        <h3>Employees List</h3>
        <p>
            <a href="create.php" class="btn btn-primary btn-sm">Create</a>
            <a href="../index.php" class="btn btn-success btn-sm">Back</a>
        </p>

        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Title</th>
                    <th>Age</th>
                    <th>Service Year</th>
                    <th>Salary</th>
                    <th>Perks</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($rows)): ?>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id'] ?? ''); ?></td>
<td><?= htmlspecialchars($row['name'] ?? ''); ?></td>
<td><?= htmlspecialchars($row['title'] ?? ''); ?></td>
<td><?= htmlspecialchars($row['age'] ?? ''); ?></td>
<td><?= htmlspecialchars($row['service_year'] ?? ''); ?></td>
<td><?= htmlspecialchars($row['salary'] ?? ''); ?></td>
<td><?= htmlspecialchars($row['perks'] ?? ''); ?></td>
<td><?= htmlspecialchars($row['email'] ?? ''); ?></td>

                            <td>
                                <a href="#" class="btn btn-success btn-sm">Edit</a>
                                <a href="#" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="9" class="text-center">No employees found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
<?php include('../includes/footer.php'); ?>
