<?php
session_start();
include_once 'templates/index_start.php';
include_once 'classes/gameManager.php';
$id = $_GET['id'] ?? 0;
?>
    <div class="girdItem" id="gridItem2">
        <?php
        // gets the data out of the database and displays it in a list
        $gamesOphalen = new gameManager();
        $gamesOphalen->get_data_list();
        ?>
    </div>
        <div class="girdItem" id="gridItem3">

        <?php
        if (!empty($_SESSION['username'])){
            echo '<form id="wishlistForm" name="wishlistForm" method="post" action="userHandeling.php">';
            echo '<input type="hidden" name="gameId" value="' . $id . '">';
            echo '<input type="submit" id="wishlistButton" name="addToWishlist" value="wishlist game"></form>';
        }
            include_once 'templates/detailpages.php';
        ?>
            <form id="deletebuttonForm" method="POST">
                <input type="submit" id="Deletebutton" name="deleteButton" value="delete">
            </form>
        <br>
        <?php
        //calls the delete proses from gameManagement.php
        include_once 'classes/gameManager.php';
        $gameMngr = new GameManager();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['deleteButton'])) {
                $gameMngr-> delete_data($id);
            }
        }   
        ?>
        <div id="lightbox-modal" style="display: none;">
            <span id="lightbox-close" style="cursor: pointer; font-size: 2rem; position: absolute; top: 10px; right: 20px;">&times;</span>
            <img id="lightbox-img" src="" alt="Game Screenshot" style="width: 100%; height: auto;">
        </div>
        <script src="bigImage.js"></script>
    </div>
</div>
</body>
</html>
