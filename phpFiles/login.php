<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
<h2>Login</h2>
<?php
// Connexion à la base de données MySQL
$servername = "localhost"; // Nom du serveur MySQL
$username = "root"; // Nom d'utilisateur MySQL
$password = ""; // Mot de passe MySQL
$dbname = "tp1-redis"; // Nom de la base de données MySQL

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

// Requête pour vérifier si l'utilisateur existe
    $sql = "SELECT * FROM utilisateurs WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if (!$result) {
        // Afficher l'erreur de la requête
        echo "Erreur de requête : " . mysqli_error($conn);
    } else {
        // Vérifier s'il y a des résultats
        if ($result->num_rows > 0) {
            // Utilisateur trouvé, redirection vers une autre page
//            header("Location: services.php");
            $output = shell_exec('C:\wamp64\www\EtuServices\INFO834-TP1-REDIS\pythonFiles\main.py');
            echo $output;
//            exit;c
        } else {
            // Utilisateur non trouvé, afficher un message d'erreur
            echo "L'utilisateur n'existe pas. Veuillez vérifier vos informations de connexion.";
        }
    }

}
?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br><br>
    <button type="submit" name="submit">Login</button>
</form>
</body>
</html>

<?php
// Fermer la connexion
$conn->close();
?>
