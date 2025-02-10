<?php
class DataBase{

    private $host = "mysql"; 
    private $dbname = "gamelibrary";
    private $username = "root";
    private $password = "root";
    private $conn;
    function __construct(){

        //connect to the database
        try {  
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname;", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function handlePostRequest() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['allData'])) {
                // URL-decode the incoming data
                $rawData = urldecode($_POST['allData']);
                
                // Now decode the JSON data
                $gameData = json_decode($rawData, true);
                
                // Check if the decoding was successful
                if ($gameData) {
                    $this->add_game($gameData);
                } else {
                    // Return an error if the data is not valid
                    echo json_encode(['status' => 'error', 'message' => 'Invalid game data.']);
                }
            } else {
                // If no data is provided, return an error
                echo json_encode(['status' => 'error', 'message' => 'No game data provided.']);
            }
        }
    }
    

    function add_game($gameData) {
        try {
            // Use the null coalescing operator to handle missing values
            $titel = $gameData['name'] ?? 'N/A';
            $genre = isset($gameData['genres']) && count($gameData['genres']) > 0 
                ? implode(', ', array_column($gameData['genres'], 'name')) 
                : 'N/A';
    
            $platform = isset($gameData['platforms']) && count($gameData['platforms']) > 0 
                ? implode(', ', array_map(function($platform) {
                    return $platform['platform']['name'];
                }, $gameData['platforms'])) 
                : 'N/A';
    
            $release_year = $gameData['released'] ?? 'N/A';
            $beoordeeling = $gameData['rating'] ?? 'N/A';
            
            // Handle screenshots (could be an array of images)
            $screenshots = isset($gameData['short_screenshots']) && count($gameData['short_screenshots']) > 0 
                ? implode(',', array_column($gameData['short_screenshots'], 'image')) 
                : 'N/A';
    
            $afbeelding = $gameData['background_image'] ?? 'no_image.png';
    
            // Prepare the SQL statement for inserting the game data
            $stmt = $this->conn->prepare("INSERT INTO games (title, genre, platform, release_year, rating, screenshots, afbeelding) 
                                          VALUES (:titel, :genre, :platform, :uitkom_jaar, :beoordeeling, :screenshots, :afbeelding)");
            $stmt->bindParam(':titel', $titel);
            $stmt->bindParam(':genre', $genre);
            $stmt->bindParam(':platform', $platform);
            $stmt->bindParam(':uitkom_jaar', $release_year);
            $stmt->bindParam(':beoordeeling', $beoordeeling);
            $stmt->bindParam(':screenshots', $screenshots);
            $stmt->bindParam(':afbeelding', $afbeelding);
    
            // Execute the statement and insert the game data into the database
            $stmt->execute();
            echo json_encode(['status' => 'success', 'message' => 'Game added successfully.']);
        } catch(PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
    

    //gets the data out of the database and displays it in a list
    function get_data_list(){
        try{
            $stmt = $this->conn->prepare("SELECT id, title, afbeelding FROM games");
            $stmt->execute();
            echo "<ul>";
            //checks if there is something in the database
            if ($stmt->rowCount()> 0) {
                include 'games.php';
                //create a list item for every item in the database and sets and gets them using functions in games.php
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $gameId = $row['id'];
                    $game = new GamesDb();
                    $game->set_image($row["afbeelding"]);
                    $game->set_titel($row["title"]);
                    $afbeeldingPath = $game->get_image();
                    $gameTitle = $game-> get_titel();
                    echo "<a href='detailPages.php?id=$gameId'><li><div><img class='imgBeforeTextRight' src='$afbeeldingPath' alt='$gameTitle'> {$gameTitle}</div></li></a>";
                }
                echo "</ul>";
            }else{
                // displays "0 results" if the database is empty
                echo "0 results";
            }
        //display errors
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    function get_data_list_picture(){
        try{
            $stmt = $this->conn->prepare("SELECT id, afbeelding FROM games");
            $stmt->execute();
            echo "<div class='bigPicturesGridContainer'>";
            //checks if there is something in the database
            if ($stmt->rowCount()> 0) {
                //gets the data out of the database and displays it in big pictures
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $gameId = $row['id'];
                    $game = new GamesDb();
                    $game->set_image($row["afbeelding"]);
                    $afbeeldingPath = $game->get_image();

                    echo "<a href='detailPages.php?id=$gameId'>" . '<div class="bigPictureGridItem">' . '<img class="imgBig" src="' . $afbeeldingPath . '"></div>';    
                }
                echo "</div>";
            }else{
                // displays "0 results" if the database is empty
                echo "0 results";
            }
        //display errors
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    //returns all the details from a certen id
    function get_game_details($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM games WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $game = $stmt->fetch(PDO::FETCH_ASSOC);
                return $game; 
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    //ends the connection
    function __destruct() {
        $this->conn = null;
    }

    function addLogin($username, $password){
        // test if username already exist
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            echo "<br> Username already exist";
            return;
        }


        $stmt = $this->conn->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        echo "<br> User added successfully";
        echo "<br><a href='http://localhost/loginSysteem.php'>Go back to login</a>";
    }

    function login($username, $password){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['password'])) {
                echo "<br> Login successful";
                ?>
                <script>
                    setTimeout(function() {
                        window.location.href = "http://localhost/";
                    },2000);
                </script>
                <?php
                exit();
            } else {
                echo "<br> Login failed";
            }
        }

    }

}
?>