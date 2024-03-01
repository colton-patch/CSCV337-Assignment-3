<!--
File: movie.php
Author: Colton Patch
Course: CSCV 337

Displays a movie review page given movies passed as parameters in queries.
The directory contains information for 2 movies:
    The Good, the Bad and the Ugly
    Gremlins 2

Their review pages can be viewed with the following queries
    ?film=good_bad_ugly
    ?film=gremlins2
-->

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Movie Review</title>
        <link rel="stylesheet" href="movie.css">
    </head>

    <body>
        <?php
            // Get movie from parameter and open overview file
            $movieDirectory = $_REQUEST['film'];
            $overviewFile = file_get_contents("{$movieDirectory}/overview.txt");
            $movieInfo = explode("\n", $overviewFile);
    
            // store movie info
            $title = trim(explode(":", $movieInfo[0], 2)[1]);
            $year = trim(explode(":", $movieInfo[1])[1]);
            $genre = trim(explode(":", $movieInfo[2])[1]);
            $runtime = trim(explode(":", $movieInfo[3])[1]);
            $director = trim(explode(":", $movieInfo[4])[1]);
            $producer = trim(explode(":", $movieInfo[5])[1]);
            $writers = trim(explode(":", $movieInfo[6])[1]);
            $synopsis = trim(explode(":", $movieInfo[7])[1]);
            $image = trim(explode(":", $movieInfo[8], 2)[1]);
            $rating = trim(explode(":", $movieInfo[9])[1]);

            // Get reviews
            $reviews = getReviews();
            $totalScore = getTotalScore();
        ?>

        <div>
            <div class="left_column">
                <img src=<?= $image ?>" />

                <h2><?= $title ?></h2>
                <div class="movie_info">
                    <p><strong>Rating: </strong> <?= $rating ?></p>
                    <p><strong>Year: </strong> <?= $year ?></p>
                    <p><strong>Genre: </strong> <?= $genre ?></p>
                    <p><strong>Runtime: </strong> <?= $runtime ?></p>
                    <p><strong>Director: </strong> <?= $director ?></p>
                    <p><strong>Producer: </strong> <?= $producer ?></p>
                    <p><strong>Writers: </strong> <?= $writers ?></p>
                </div>
            </div>
        
            <div class="right_column">
               <h1><?= $title ?></h1>
               <hr>
               <h3>Synopsis</h3>
               <p> <?= $synopsis ?></p>

               <h3>Overall Score</h3>
               <h1 style="color:<?= getScoreColor($totalScore) ?>"><?= $totalScore ?>/10</h1>

               <h3>Reviews</h3>
               <div class="reviews_container">
                    <div class="review">
                        <h3 class="score" style="color: <?= getScoreColor($reviews[0][0]) ?>"><?= $reviews[0][0] ?>/10</h3>
                        <p class="review_text"><?= $reviews[0][1] ?></p>
                    </div>

                    <div class="review">
                        <h3 class="score" style="color: <?= getScoreColor($reviews[1][0]) ?>"><?= $reviews[1][0] ?>/10</h3>
                        <p class="review_text"><?= $reviews[1][1] ?></p>
                    </div>

                    <div class="review">
                        <h3 class="score" style="color: <?= getScoreColor($reviews[2][0]) ?>"><?= $reviews[2][0] ?>/10</h3>
                        <p class="review_text"><?= $reviews[2][1] ?></p>
                    </div>

                    <div class="review">
                        <h3 class="score" style="color: <?= getScoreColor($reviews[3][0]) ?>"><?= $reviews[3][0] ?>/10</h3>
                        <p class="review_text"><?= $reviews[3][1] ?></p>
                    </div>

                    <div class="review">
                        <h3 class="score" style="color: <?= getScoreColor($reviews[4][0]) ?>"><?= $reviews[4][0] ?>/10</h3>
                        <p class="review_text"><?= $reviews[4][1] ?></p>
                    </div>

                    <div class="review">
                        <h3 class="score" style="color: <?= getScoreColor($reviews[5][0]) ?>"><?= $reviews[5][0] ?>/10</h3>
                        <p class="review_text"><?= $reviews[5][1] ?></p>
                    </div>
               </div>
            </div>
        </div>
    </body>

    <?php
        /**
         * getReviews() - reads the "reviews.txt" file and stores each review
         *      as an array, with the first element being the score and the
         *      second element being the text. It returns an array of
         *      these reviews.
         */
        function getReviews() {
            global $movieDirectory;

            // Open reviews.txt file and store each review as a string
            $reviewFile = file_get_contents("{$movieDirectory}/reviews.txt");
            $reviewStrings = explode("/", $reviewFile);

            // loop through each review and store it as an array
            // with the score and text as elements
            $reviews = array();
            for ($i = 0; $i < count($reviewStrings); $i++) {
                $reviewRaw = explode("\n", $reviewStrings[$i]);
                $review = array();
                $review[] = trim(explode(":", $reviewRaw[0])[1]);
                $review[] = trim(explode(":", $reviewRaw[1])[1]);
                $reviews[] = $review;
            }

            return $reviews;
        }

        /**
         * getTotalScore() - gets the average score by dividing the combined
         *      scores of all reviews by the number of reviews.
         */
        function getTotalScore() {
            global $reviews;
            $total = 0;
            for ($i = 0; $i < count($reviews); $i++) {
                $score = floatval($reviews[$i][0]);
                $total += $score;
            }
            return $total / count($reviews);
        }

        /**
         * getScoreColor($score) - Returns a color hex code
         *  based on the passed score.
         *      7+: green
         *      4-6: yellow
         *      3-: red
         */
        function getScoreColor($score) {
            if ($score > 6) {
                return "#00b312";
            } 
            else if ($score < 4) {
                return "#d60902";
            }
            else {
                return "#cc920a";
            }
        }
    ?>
</html>