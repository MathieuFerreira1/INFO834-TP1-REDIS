<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="..\cssFiles\login.css">
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
            // Requête pour récupérer l'ID de l'utilisateur à partir de l'email
            $sql2 = "SELECT id FROM utilisateurs WHERE email = '$email' AND password = '$password'";
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {
                // Récupérer la ligne de résultat
                $row = $result2->fetch_assoc();
                // Récupérer l'ID de l'utilisateur
                $userId = $row['id'];
                // Convertir l'ID en chaîne de caractères
                $userId = strval($userId);

                // Exécuter le script Python pour vérifier si l'utilisateur peut se connecter
                $cmd = "C:\Users\Mathieu\AppData\Local\Programs\Python\Python311\python.exe C:\wamp64\www\EtuServices\INFO834-TP1-REDIS\pythonFiles\main.py $userId";
                $command = escapeshellcmd($cmd);
                $shelloutput = shell_exec($command);

                // Rediriger l'utilisateur vers la page de services si la connexion est réussie
                if ($shelloutput == "1") {
                    header("Location: services.php");
                } else {
                    echo "La connexion est impossible, vous vous êtes connecté plus de 10 fois dans les 10 dernières minutes.";
                }


            }
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
