<?php
session_start();
include 'db.php';

// Fetch waitlist data
$sql = "SELECT waitlist.waitlist_id, customers.name, customers.phone_number, waitlist.party_size, waitlist.status
        FROM waitlist
        INNER JOIN customers ON waitlist.customer_id = customers.customer_id
         WHERE waitlist.status != 'Removed'
        ORDER BY waitlist.waitlist_id ASC";

$result = $conn->query($sql);
$waitlist = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $waitlist[] = $row;
    }
} else {
    die("Database query error: " . $conn->error);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="d-flex flex-column align-items-center p-4">

    <h2 class="mb-4">Admin Dashboard</h2>

    <div class="card p-4 shadow-lg" style="width: 80%;">
        <h4>Waitlist Management</h4>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Phone Number</th>
                    <th>Party Size</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($waitlist as $entry): ?>
                <tr>
                    <td><?php echo htmlspecialchars($entry['waitlist_id']); ?></td>
                    <td><?php echo htmlspecialchars($entry['name']); ?></td>
                    <td><?php echo htmlspecialchars($entry['phone_number']); ?></td>
                    <td><?php echo htmlspecialchars($entry['party_size']); ?></td>
                    <td id="status-<?php echo $entry['waitlist_id']; ?>"><?php echo ucfirst(htmlspecialchars($entry['status'])); ?></td>
                    <td>
                        <button onclick="updateStatus(<?php echo $entry['waitlist_id']; ?>, 'Seated')" class="btn btn-success btn-sm">Seat</button>
                        <button onclick="updateStatus(<?php echo $entry['waitlist_id']; ?>, 'Removed')" class="btn btn-danger btn-sm">Remove</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <h4 class="mt-4">Table Layout</h4>
    <div class="container">
        <div class="row row-cols-4" id="tableGrid">
            <!-- Table buttons will be inserted dynamically -->
        </div>
    </div>

    <a href="index.html" class="btn btn-secondary mt-3">Back to Home</a>
    <a href="logout.php" class="btn btn-danger mt-3">Logout</a>

    <script>
        function updateStatus(id, newStatus) {
            if (confirm("Are you sure you want to update the status to " + newStatus + "?")) {
                $.post("update_status.php", { id: id, status: newStatus }, function(response) {
                    alert(response);
                    if (newStatus === "Removed") {
                        $("#status-" + id).closest("tr").remove();
                    } else {
                        $("#status-" + id).text(newStatus);
                    }
                });
            }
        }

        function loadTableGrid() {
            $.get("get_tables.php", function(data) {
                const tables = data;
                const container = $("#tableGrid");
                container.empty();

                tables.forEach(table => {
                    const color = table.status === "Available" ? "btn-success" :
                                  table.status === "Reserved" ? "btn-warning" : "btn-danger";

                    container.append(`
                        <div class="col p-2">
                            <button class="btn ${color} w-100 table-btn" title="Status: ${table.status}"
                                onclick="adminChangeTableStatus(${table.table_id}, '${table.status}')">
                                Table ${table.table_number}
                            </button>
                        </div>
                    `);
                });
            });
        }

        function adminChangeTableStatus(tableId, currentStatus) {
            const newStatus = prompt("Enter new status (Available, Reserved, Occupied):", currentStatus);
            const validStatuses = ["Available", "Reserved", "Occupied"];

            if (newStatus && validStatuses.includes(newStatus)) {
                $.post("update_table_status.php", {
                    table_id: tableId,
                    status: newStatus
                }, function(response) {
                    alert(response);
                    loadTableGrid();
                });
            } else {
                alert("Invalid status. Please enter Available, Reserved, or Occupied.");
            }
        }

        $(document).ready(loadTableGrid);
    </script>

</body>
</html>
