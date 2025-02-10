<?php
class GameManager {

    private $conn;

    //making the connection
    public function __construct(DataBase $db) {
        $this->conn = $db->getConnection();
    }
    
    //function for deleting the data
    function delete_data($id) {
        try {
           
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
}

?>
