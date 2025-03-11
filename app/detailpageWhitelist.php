<?php
include_once 'templates/index_start.php';
include_once 'classes/gameManager.php';
$id = isset($_GET['id']) ? $_GET['id'] : 0;
?>
    <div class="girdItem" id="gridItem2">
        <?php
        // gets the data out of the database and displays it in a list
        $gamesOphalen = new gameManager();
        $gamesOphalen->get_favorite_games_list($_SESSION['userId']);
        ?>
    </div>
        <div class="girdItem" id="gridItem3">

        <?php include_once 'templates/detailpages.php'; ?>
        <a href="#deletebuttonDiv"><div id="deletebutton">de-whitelist</div></a>
        <div id="deletebuttonDiv">
            <p class="middleText">are you sure?</p> <br>
            <form id="deletebuttonForm" method="POST" action="userHandeling.php">
                <a href="#deletebutton" id="dontdelete"><div>no</div></a>
                <?php echo '<input type="hidden" name="gameId" value="' . $id .'">'?>
                <input type="submit" id="yesDeletebutton" name="deWhitelist" value="yes">
            </form>
        </div>
        <br>
        <?php
        //calls the delete proses from gameManagement.php
        include_once 'classes/gameManager.php';
        $gameMngr = new GameManager($gamesOphalen);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['deleteButon'])) {
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
