<?php
class gameManager{

    private $conn;

    //making the connection
    public function __construct() {
        include_once 'databaseConnection.php';
        $db = new DataBase();
        $this->conn = $db->getConnection();
    }

    //function for deleting the data
    function delete_data($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM user_games WHERE game_id = :game_id");
            $stmt->bindParam(":game_id", $id);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $stmt = $this->conn->prepare("DELETE FROM user_games WHERE game_id = :game_id");
                $stmt->bindParam(":game_id", $id);
                $stmt->execute();
            }

            $stmt = $this->conn->prepare("SELECT afbeelding FROM games WHERE id='$id'");
            $stmt->execute();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $image_path = $row["afbeelding"];
                //deleting the image
                if (unlink($image_path)) {
                    echo "Image deleted successfully: " . $image_path;
                } else {
                    echo "Failed to delete image: " . $image_path;
                }
            }
            //delete the current game on wich the delete button had been pressed
            $stmt = $this->conn->prepare("DELETE FROM games WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            if (is_file($image_path)) {

            } else {
                echo "Image not found: " . $image_path;
            }
            echo "Record deleted successfully";
            //rederect to index.php
            echo "<meta http-equiv='refresh' content='0;url=http://localhost/'>";

        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

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
        echo "it is being added???????///?";
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
                    echo "<a href='detailPages.php?id=$gameId'><li><div><img class='imgBeforeTextRight' src='$afbeeldingPath' alt='$gameTitle'> $gameTitle</div></li></a>";
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

                    echo "<a href='detailPages.php?id=$gameId'>" . '<div class="bigPictureGridItem">' . '<img class="imgBig" alt="img" src="' . $afbeeldingPath . '"></div>';
                }
                echo "</div>";
            }else{
                // displays "0 results" if the database is empty
                echo "0 results";
            }
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }


    //returns all the details from a certain id
    function get_game_details($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM games WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function get_favorite_games_list($user_id)
    {
        try{
            $stmt = $this->conn->prepare("SELECT games.id, games.title, games.afbeelding FROM games INNER JOIN user_games ON games.id = user_games.game_id WHERE user_games.user_id = :user_id");
            $stmt->bindParam(':user_id', $user_id);
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
                    echo "<a href='detailpageWishlist.php?id=$gameId'><li><div><img class='imgBeforeTextRight' src='$afbeeldingPath' alt='$gameTitle'> $gameTitle</div></li></a>";
                }
                echo "</ul>";
            }else{
                echo "You dont have any games wishlisted.";
            }
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }


    }

    function get_favorite_games_list_picture($user_id)
    {
        try{
            $stmt = $this->conn->prepare("SELECT games.id, games.afbeelding FROM games INNER JOIN user_games ON games.id = user_games.game_id WHERE user_games.user_id = :user_id");
            $stmt->bindParam(':user_id', $user_id);
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

                    echo "<a href='detailpageWishlist.php?id=$gameId'>" . '<div class="bigPictureGridItem">' . '<img class="imgBig" alt="img" src="' . $afbeeldingPath . '"></div>';
                }
                echo "</div>";
            }else{
            }
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function add_favorite_games($game_id, $user_id)
    {
        $stmt =  $this->conn->prepare("SELECT * FROM user_games WHERE game_id = :game_id AND user_id = :user_id");
        $stmt->bindParam(':game_id', $game_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $_SESSION['error'] = 'Already whislisted';
            header("Location: detailPages.php?id=$game_id");
            return;
        }

        try {
            $stmt = $this->conn->prepare("INSERT INTO user_games (user_id, game_id) VALUES (:user_id, :game_id)");
            $stmt->bindParam(':game_id', $game_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            header("Location: profilepage.php");
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }


    }
    function remove_favorite_games($game_id, $user_id)
    {
        try{
            $stmt = $this->conn->prepare("SELECT * FROM user_games WHERE game_id = :game_id AND user_id = :user_id");
            $stmt->bindParam(':game_id', $game_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $stmt = $this->conn->prepare("DELETE FROM user_games WHERE game_id = :game_id AND user_id = :user_id");
                $stmt->bindParam(':game_id', $game_id);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->execute();
                header("Location: profilepage.php");
            }
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    function get_users_by_game_id($game_id)
    {
        $stmt = $this->conn->prepare("SELECT users.username FROM user_games JOIN users ON user_games.user_id = users.id WHERE game_id = :game_id");

        $stmt->bindParam(':game_id', $game_id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch all usernames into an array
        $usernames = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $usernames[] = $row['username']; // Append username to array
        }
        if ($stmt->rowCount() > 0) {
            return implode(", ", $usernames); // Return array of usernames
        }else{
            return 'No one';
        }
    }
    //ends the connection
    function __destruct() {
        $this->conn = null;
    }



}