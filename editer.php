<?php
require("functions.php");
//taakd wch clicikina 3la sbmit
if (isset($_POST['submit'])) {
    $index = $_POST['index'];//Récupère l'index envoyé via le formulaire
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];// declare var
    $age = $_POST['age'];
    $phone = $_POST['phone'];
    $marital_status = $_POST['marital_status'];
    $gender = $_POST['gender'];
    $city = $_POST['city'];
    $street = $_POST['street'];
    $zip = $_POST['zip'];
    $title = $_POST['title'];
    $company = $_POST['company'];
    $industry = $_POST['industry'];
    $file_path = 'data.json';// Spécifie l  e chemin vers le fichier JSON
    $data = reads_json_file($file_path);//kt9ra lina contenu fichier json 
    if ($data !== false) {// Vérifie si la lecture du fichier JSON s'est bien 
        $data_array = json_decode($data, true);// Décode le JSON bch kyrj3  contenu fichier json lina tableau associatif
        $data_array[$index]['first_name'] = $first_name;// Met à jour le prénom dans le tableau de données
        $data_array[$index]['last_name'] = $last_name;
        $data_array[$index]['age'] = $age;
        $data_array[$index]['phone'] = $phone;
        $data_array[$index]['marital_status'] = $marital_status;
        $data_array[$index]['gender'] = $gender;
        $data_array[$index]['city'] = $city;
        $data_array[$index]['street'] = $street;
        $data_array[$index]['zip'] = $zip;
        $data_array[$index]['title'] = $title;
        $data_array[$index]['company'] = $company;
        $data_array[$index]['industry'] = $industry;
        $updated_json_data = json_encode($data_array, JSON_PRETTY_PRINT);// Convertit le tableau de données en JSON formaté
        file_put_contents($file_path, $updated_json_data); // Écrit les données mises à jour dans le fichier JSON
        header("Location: index.php");// ktwjhna page d'accueil b3dma knrslo formulaire
        exit;
    } else {
        echo "Failed to read JSON file.";//afficher hd message ila ml9tach lina fichier json 
        exit;
    }
}
if (isset($_GET['id'])) {// kay3tina ida kan id f url
    $index = $_GET['id'];// Récupère l'ID de l'employé à partir de l'URL
    $employeeData = getEmployeeDataByIndex($index, 'data.json');//kt7sl lina 3la les donnees mn fichier json 
    if ($employeeData !== false) { // kt7a9a9 wch kynin les donnees employee
                // ktjib li kolchi bach kaydir edit l employee
        $first_name = $employeeData['first_name'];
        $last_name = $employeeData['last_name'];
        $age = $employeeData['age'];
        $phone = $employeeData['phone'];
        $marital_status = $employeeData['marital_status'];
        $gender = $employeeData['gender'];
        $city = $employeeData['city'];
        $street = $employeeData['street'];
        $zip = $employeeData['zip'];
        $title = $employeeData['title'];
        $company = $employeeData['company'];
        $industry = $employeeData['industry'];
    } else {
        echo "Employee not found.";// Affiche un message si l'employé n'a pas été trouvé
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit / Add Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        .btn-primary {
            width: 150px;
        }
    </style>
</head>

<body>
    <div class="container text-center">
        <h3 class="align-self-center">Formulaire pour modifier ou ajouter les informations</h3>
    </div>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md">
                    <?php if (isset($index)) : ?>
                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo isset($first_name) ? $first_name : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo isset($last_name) ? $last_name : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="text" class="form-control" id="age" name="age" value="<?php echo isset($age) ? $age : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo isset($phone) ? $phone : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="marital_status">Marital Status</label>
                        <input type="text" class="form-control" id="marital_status" name="marital_status" value="<?php echo isset($marital_status) ? $marital_status : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <input type="text" class="form-control" id="gender" name="gender" value="<?php echo isset($gender) ? $gender : ''; ?>">
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md">
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control" id="city" name="city" value="<?php echo isset($city) ? $city : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="street">Street</label>
                        <input type="text" class="form-control" id="street" name="street" value="<?php echo isset($street) ? $street : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="zip">Zip Code</label>
                        <input type="text" class="form-control" id="zip" name="zip" value="<?php echo isset($zip) ? $zip : ''; ?>">
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo isset($title) ? $title : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="company">Company</label>
                        <input type="text" class="form-control" id="company" name="company" value="<?php echo isset($company) ? $company : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="industry">Industry</label>
                        <input type="text" class="form-control" id="industry" name="industry" value="<?php echo isset($industry) ? $industry : ''; ?>">
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </div>
            </div>
        </div>
    </form>
</body>

</html>