<?php
require("functions.php");

$file_path = "data.json";

if (isset($_GET['ids'])) {
    // Chouf si kayn chi ID dyal les employees li 3ayto f URL
    $ids = explode('-', $_GET['ids']);

    // n9raw contenu du fil json
    $data = read_json_file($file_path);

    if ($data !== false) {
        // Parcourir les IDs dyal les employees li bghina nfas7o
        foreach ($ids as $id) {
            // Dirou l'id li kat 3ando string l'int
            $id = intval($id);
            // Cherchi index dyal l'employee b'id hada
            $index = array_search($data[$id], $data);
            // Si kayn index, fahmo hta l'employee b'id hada
            if ($index !== false) {
                // n7aydo employé mn tableau
                unset($data[$index]);
            }
        }

        // ghadi iraja3 fil json ltableau associatif
        $json_data = json_encode(array_values($data), JSON_PRETTY_PRINT);

        // Gheddo ldata f fichier
        file_put_contents($file_path, $json_data);

        // Raidiou l'utilisateur l index.php
        header("Location: index.php");
        exit();
    }
}

// Pagination logic
// Hada dyal lpagination
$itemsPerPage = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $itemsPerPage;

// Initialize data
$data = read_json_file('data.json');
if ($data === false) {
    $data = [];
}

// Chouf wach formulaire dyal recherche kayn
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['search']) && !empty(trim($_GET['search']))) {
    // Kayn terme dyal recherche
    $searchTerm = trim($_GET['search']);
    // Filtrow ldata
    $filteredData = array_filter($data, function ($employee) use ($searchTerm) {
        // Chouf wach kayn chi field f l'employee li kan9albo 3lih
        foreach ($employee as $value) {
            if (stripos(strtolower($value), strtolower($searchTerm)) !== false) {
                return true; // Match found
            }
        }
        return false; // No match found
    });
} else {
    $filteredData = $data;
}

// Ensure filteredData is always an array
if (!is_array($filteredData)) {
    $filteredData = [];
}

// Hada dyal lpagination
$totalPages = 0;
if (!empty($filteredData)) {
    $totalPages = ceil(count($filteredData) / $itemsPerPage);
}

// Handle empty data case
$currentPageItems = [];
if (!empty($filteredData)) {
    $currentPageItems = array_slice($filteredData, $offset, $itemsPerPage);
}

// Get table columns - handle empty case
$thead_columns = [];
if (!empty($currentPageItems) && isset($currentPageItems[0]) && is_array($currentPageItems[0])) {
    $thead_columns = array_keys($currentPageItems[0]);
} else if (!empty($data) && isset($data[0]) && is_array($data[0])) {
    // Use original data structure if current page is empty but data exists
    $thead_columns = array_keys($data[0]);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 20px;
        }

        .table-container {
            border: 1px solid #dee2e6;
            overflow-x: auto;
            max-height: 70vh;
            background-color: #fff;
            border-radius: 8px;
        }

        .table-container table {
            border-collapse: collapse;
            width: 100%;
        }

        .table-container th,
        .table-container td {
            padding: 8px;
            text-align: center;
            vertical-align: middle;
        }

        .table-container th {
            background-color: #343a40;
            color: #fff;
        }

        .table-container tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table-container tbody tr:hover {
            background-color: #e2e2e2;
        }

        .pagination {
            justify-content: center;
        }

        .btn {
            margin-right: 5px;
        }

        h1 {
            margin-bottom: 20px;
            text-align: center;
        }

        form {
            margin-bottom: 20px;
        }

        .text-capitalize {
            text-transform: capitalize;
        }
        
        .no-data {
            text-align: center;
            padding: 20px;
            color: #6c757d;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Employee Management</h1>
    </div>
    <div class="container">
        <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group row">
                <label for="search" class="col-sm-2 col-form-label">Search:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="search" name="search" placeholder="Enter search criteria" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <?php if (isset($_GET['search']) && !empty(trim($_GET['search']))): ?>
                        <a href="index.php" class="btn btn-secondary">Clear</a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div><br>
    <div id="call-to-action" class="container">
        <a href="editer.php" class="btn btn-primary">Add Employee</a>
        <?php if (!empty($currentPageItems)): ?>
            <button class="btn btn-success" onclick="editRow()">Edit</button>
            <button class="btn btn-danger" name="delete" onclick="deleteRows()">Delete</button>
        <?php endif; ?>
    </div>
    <div class="container table-container my-2 border-1 rounded">
        <?php if (!empty($currentPageItems) && !empty($thead_columns)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>#</th>
                        <?php
                        foreach ($thead_columns as $columns) {
                            echo '<th class="text-capitalize">' . traduire_elements_en_francais($columns) . "</th>";
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($currentPageItems as $index => $row) {
                        echo "<tr>
                                <td><input type=\"checkbox\" name=\"line_marker_$index\" id=\"line_marker_$index\" data-index=\"$index\"></td>
                                <td>" . (intval($offset) + intval($index) + 1) . "</td>";
                        foreach ($row as $column) {
                            echo "<td>$column</td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <div class="pagination justify-content-center mt-4">
                    <ul class="pagination">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                <a class="page-link" href="./index.php?page=<?php echo $i; ?><?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="no-data">
                <p>No employees found. <a href="editer.php">Add the first employee</a></p>
            </div>
        <?php endif; ?>
    </div>
    <script src="script.js"></script>
</body>

</html>