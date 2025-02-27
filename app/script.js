$(document).ready(function () {

    // hide the previous and next buttons
    $("#pageButtons").hide();

    // initiade virables
    let search = "";
    let searchType = "";
    let page = 1;
    let page_size = 12;
    let responseCache = [];
    let descriptionShown = true;



    // function to format the date to dd-mm-yyyy
    function formatDate(dateString) {
        const date = new Date(dateString);
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day}-${month}-${year}`;
    }

    // function to get games from api and displays them
    function fetchGames(search, searchType, page_size) {
        // logs to console the search type and search value
        console.log("Search type:", searchType);
        console.log("Search value:", search);

        // first piece of data that will be send to the api
        let data = {
            page_size: page_size,
            page: page,
            key: '82a1ec66db184d689ca8d99cc0b82399'
        };
        // set the search value to lowercase and trim it to avoid 0 results
        search = search.toLowerCase().trim();

        // cheks on wich the search is and ajusted the search based on that
        if (searchType === "gameName") {
            data.search = search;
        } else if (searchType === "gameGenre") {
            data.genres = search;
        } else if (searchType === "platform") {
            if (search.includes("playstation")) {
                search = "18";
            } else if (search.includes("xbox")) {
                search = "1";
            } else if (search.includes("nintendo")) {
                search = "7";
            } else if (search.includes("ios")) {
                search = "3";
            } else if (search.includes("android")) {
                search = "21";
            } else if (search.includes("pc")) {
                search = "4";
            }
            data.platforms = search;
        } else if (searchType === "store") {
            if (search === "steam") {
                search = "1";
            } else if (search.includes("epic")) {
                search = "19";
            } else if (search.includes("xbox")) {
                search = "2";
            } else if (search.includes("nintendo")) {
                search = "6";
            } else if (search.includes("playstation")) {
                search = "3";
            } else if (search.includes("google")) {
                search = "8";
            }
            data.stores = search;
        }

        // logs the data that will be send to the api
        console.log("Data being sent to API:", data);

        // ajax call
        $.ajax({
            url: 'https://api.rawg.io/api/games',
            type: 'GET',
            // important the data
            data: data,
            // if succesfull do this
            success: function (response) {
                // log the amount of games found
                console.log(response.results.length);
                // if there is more then 0 games else display no games found
                if (response.results.length > 0) {
                    // log the response
                    console.log(response);
                    // set the response to the responseCache
                    responseCache = response.results;
                    // empty the games list
                    $('#games-list').empty();

                    // loop through the games and display them
                    response.results.forEach(function (game, index) {
                        // get the first genre of the game if there is one else set it to N/A
                        const firstGenre = game.genres.length > 0 ? game.genres[0].name : 'N/A';
                        // if there is no images set it to no_image.png
                        if (game.background_image === null) {
                            game.background_image = 'no_image.png';
                        }
                        // sets the html
                        const gameHtml = `
                            <div class="game border" id="game-${index}" style="opacity: 0;">
                                <img src="${game.background_image}" alt="${game.name}" />
                                <div class="game-info">
                                    <h3>${game.name}</h3>
                                    <p>Release date: ${formatDate(game.released)}</p>
                                    <p>Rating: ${game.rating}</p>
                                    <p>Genre: ${firstGenre}</p>
                                </div>
                            </div>`;
                        // appends the gamehtml to the games list
                        $('#games-list').append(gameHtml);
                        // animates the games by fading them in 4 at a time until all are shown
                        const delayTime = Math.floor(index / 4) * 500;
                        $(`#game-${index}`)
                            .delay(delayTime)
                            .animate({ opacity: 1 }, 1000);
                    });
                    // waits 1 second and then fades in the page buttons
                    $("#pageButtons").delay(1000).fadeIn();
                } else {
                    // if there are no games found display no games found and empty the games list
                    $('#games-list').empty();
                    $('#games-list').append('<h1>No games found</h1>');
                }
            },
            // in case of an error log the error
            error: function (error) {
                console.log('Error:', error);
            }
        });
    }

    // gets the click of the page buttons and checks if the next or previous button is clicked
    // if the next one is clicked do +1 page then call the fetchgames function


    $('#pageButtons').on('click', '#next', function () {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        page++;
        fetchGames(search, searchType, page_size);
    });

    // if the previous button is clicked do only -1 if the page number is above 1 to avoid going in to negative page numbers page then call the fetchgames function
    $('#pageButtons').on('click', '#previous', function () {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        if (page > 1) {
            page--;
            fetchGames(search, searchType, page_size);
        }
    });

    // if the search form is submitted gets the data from the form and calls the fetchgames function
    // makes also sure that th epage doesnt reload
    $("#formZoeken").submit(function (event) {
        event.preventDefault(); // Prevent the default form submission
        $("#search").blur();
        page = 1;
        search = $("#search").val();
        searchType = $("#searchType").val();
        page_size = $("#pageSize").val();
        fetchGames(search, searchType, page_size);
    });

    // if a game is clicked get the game details and display them
    $('#games-list').on('click', '.game', function () {
        // get the small game info html and set it to a variable
            $(document).ready(function() {
            // Check if any `.screenshot` elements exist before applying the event
            if ($(".screenshot").length > 0) {
                // Add 'focus' event listener for `.screenshot` elements
                $(".screenshot").on("focus", function() {
                    // Smoothly scroll to the top of the page
                    $("html, body").animate({ scrollTop: 0 }, 500);
                });
            } else {
                console.warn("No `.screenshot` elements found to bind events.");
            }
        });smallGameInfoHtml = $(this).find('.game-info').html();
        // if the game is small and the game is clicked
        if (descriptionShown) {
            console.log("descriptionShown", descriptionShown);
            // scroll to the top of the page
            $("html, body").animate({ scrollTop: 0 }, "slow");
            // log the game that is clicked
            console.log($(this).attr('id') + " clicked");
            // get the index of the game that is clicked
            const index = $(this).attr('id').split('-')[1];
            // toggle the full screen class which makes the game full screen
            $(this).toggleClass('full-screen');
            // get the details of the game and set them to variables
            const gameDetail = responseCache[index];
            console.log(gameDetail);
            const genres = gameDetail.genres.map(genre => genre.name).join(', ') || 'N/A';
            const esrb_rating = gameDetail.esrb_rating ? gameDetail.esrb_rating.name : 'N/A';
            const platform = gameDetail.platforms && gameDetail.platforms.length > 0 ? gameDetail.platforms.map(platform => platform.platform.name).join(', ') : 'N/A';
            const stores = gameDetail.stores && gameDetail.stores.length > 0 ? gameDetail.stores.map(stores => stores.store.name).join(', ') : 'N/A';
            
            
            // makes the html for the game details
            const gameInfoHtml = `
            <div class="game-info-full">
                <h1 id="closeButton">X</h1>
                <h2>${gameDetail.name}</h2>
                <p>Release date: ${formatDate(gameDetail.released)}</p>
                <p>Rating: ${gameDetail.rating}</p>
                <p>Esrb rating: ${esrb_rating}</p>
                <p>Genre: ${genres}</p>
                <p>Platforms: ${platform}</p>
                <p>Stores: ${stores}</p>
                <p>Screenshots:</p>
                <div class='gameScreenshots'>
                    ${gameDetail.short_screenshots.map(screenshot => `<img src="${screenshot.image}" alt="Screenshot" />`).join('')}
                </div>
                <form method="POST" id="addToGamelibaryForm">
                    <!-- Convert gameDetail to a JSON string and then escape it -->
                    <input type="hidden" name="allData" value="${encodeURIComponent(JSON.stringify(gameDetail))}">
                    <input type="submit" value="Add to gamelibary" id="addToGamelibary">
                </form>
            </div>`;
        
            // set the original html to the small game info html
            $(this).data('original-html', $(this).html());
            // set the game info html to the game info html
            $(this).find('.game-info').html(gameInfoHtml);
            descriptionShown = false;
    
        }
    });

    // if the close button is clicked remove the full screen class and set the original html back
    $('#games-list').on('click', '#closeButton', function (e) {
        e.stopPropagation(); // Voorkom dat het klik-event ook de .game selecteerd
        const parentGame = $(this).closest('.game');
        const originalHtml = parentGame.data('original-html');
        parentGame.html(originalHtml).removeClass('full-screen');
        descriptionShown = true;
        
    });

    $('#goToGamelibary').click(function () {
        window.location.href = "http://localhost/";

    });



    $('#search').click(function () {
        $("html, body").animate({ scrollTop: 610 }, "slow");
    });

    $('#games-list').on('submit', '#addToGamelibaryForm', function (e) {
        e.preventDefault();
        
        // Serialize the form data, including the hidden input
        const formData = $(this).serialize();
        console.log(formData);  // For debugging, to see the form data
    
        $.ajax({
            url: 'http://localhost/classes/formHandeling.php',
            type: 'POST',
            data: formData,  // Send the whole form data
            success: function (response) {
                console.log(response)
                if (response.includes('"status":"error"')) {
                    console.log('Error:', response);
                    $('#addToGamelibary').prop('disabled', true);
                    $('#addToGamelibary').css('background-color', 'red');
                    $('#addToGamelibary').val('Error adding to gamelibrary )');
                    //reload after 1 second
                    setTimeout(() => {
                        window.location.href = "http://localhost/";
                    }, 1000);

                    // return;
                } else if (response.includes('"status":"success"')) {
                    console.log('response:', response);
                    $('#addToGamelibary').prop('disabled', true);
                    $('#addToGamelibary').css('background-color', 'green');
                    $('#addToGamelibary').val('Added to gamelibrary!!!');
                    setTimeout(() => {
                        window.location.href = "http://localhost/";
                    }, 1000);
                }
            },
            error: function (error) {
                console.log('Error:', error);
                $('#addToGamelibary').prop('disabled', true);
                $('#addToGamelibary').css('background-color', 'red');
                $('#addToGamelibary').val('Error adding to gamelibrary )');
            }
        });
    });

});
