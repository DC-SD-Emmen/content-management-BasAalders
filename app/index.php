<?php
session_start();
include_once 'templates/index_start.php';
?>
    <div class="girdItem" id="gridItem2">
        <?php
            //gets the data out of the database and displays it in a list
            $gamesOphalen = new gameManager();
            $gamesOphalen->get_data_list(); 
        ?>
    </div>
    <div class="girdItem" id="gridItem3">
        <?php    
            //gets the data out of the database and displays it in big pictures
            $gamesOphalen->get_data_list_picture();
        ?>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>