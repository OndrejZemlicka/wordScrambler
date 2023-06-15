<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylus.css">
    <title>Document</title>
</head>
<body>
    
    <div class="navbar">
        <a class="navbar-brand" href="index.html">Game Website</a>
    </div>

    <h1>Guess the Word Game</h1>
    <h3 id="difficultyLevel">Difficulty Level: Easy</h3>

    <div id="letterButtons">
        <!-- Randomized letter buttons will be generated here -->
    </div>

    <div class="word-selection">
        <div id="wordSelection"></div>
        <button class="button" onclick="resetSelection()">Reset</button>
    </div>

    <div class="message" id="message"></div>

    <div class="selected-letters">
        Selected Letters:
        <div id="selectedLetters"></div>
    </div>


    <script>
        var words = ["CORN", "DATE", "LAND", "BABY", "ROAD", "PARK", "FISH", "LION", "TREE", "BOOK"];
        var mediumWords = ["APPLE", "BANANA", "CHERRY", "ORANGE", "GRAPE"];
        var hardWords = ["ADVENTURE","BEAUTIFUL","CONFIDENCE","EDUCATION","FANTASTIC","GENERATION","HARMONIOUS","INSPIRATION","JOURNEY","KNOWLEDGE"];
        var expertWords = ["CONGRATULATIONS","EXTRAVAGANT","PHILOSOPHY","COMMUNICATION","DIFFICULT","ACCOMMODATE","TECHNOLOGY","FASCINATING","HYPOTHESIS","TERRIFIC"];
        var currentWordArray = words;
        
        var currentWord = getRandomWord();
        var selectedLetters = [];
        var letterButtons = document.getElementById("letterButtons");
        var selectedLettersDisplay = document.getElementById("selectedLetters");
        var wordSelection = document.getElementById("wordSelection");
        var messageDisplay = document.getElementById("message");
        var difficultyLevelDisplay = document.getElementById("difficultyLevel");

        var guesses = 0; // Variable to keep track of the number of guesses
        var currentDifficulty = 0;
        var difficultyThreshold = 5; // Number of guesses after which difficulty increases

        function getRandomWord() {
            setCurrentArray();
            var randomIndex = Math.floor(Math.random() * currentWordArray.length);
            return currentWordArray[randomIndex];
        }

        function setCurrentArray() {
            if (currentDifficulty === 0) {
                currentWordArray = words;
            } else if (currentDifficulty === 1) {
                currentWordArray = mediumWords;
            } else if(currentDifficulty === 2){
                currentWordArray = hardWords;
            } else if(currentDifficulty === 3){
                currentWordArray = expertWords;
            }
        }

        function generateLetterButtons() {
            var shuffledWord = currentWord.split("").sort(function () {
                return 0.5 - Math.random();
            });
            for (var i = 0; i < shuffledWord.length; i++) {
                var letterButton = document.createElement("button");
                letterButton.className = "letter-button";
                letterButton.textContent = shuffledWord[i];
                letterButton.onclick = function () {
                    selectLetter(this);
                };
                letterButtons.appendChild(letterButton);
            }
        }

        function updateSelectedLettersDisplay() {
            selectedLettersDisplay.textContent = selectedLetters.join(" ");
        }

        function updateWordSelection() {
            wordSelection.innerHTML = "";
            for (var i = 0; i < selectedLetters.length; i++) {
                var letter = document.createElement("span");
                letter.className = "letter";
                letter.textContent = selectedLetters[i];
                letter.onclick = function () {
                    removeLetter(this.textContent);
                };
                wordSelection.appendChild(letter);
            }
        }

        function updateMessage(message) {
            messageDisplay.textContent = message;
        }

        function selectLetter(button) {
            var letter = button.textContent;
            selectedLetters.push(letter);
            updateSelectedLettersDisplay();
            updateWordSelection();
            button.disabled = true;
            if (selectedLetters.length === currentWord.length) {
                var guessedWord = selectedLetters.join("");
                if (guessedWord === currentWord) {
                    //updateMessage("Congratulations! You guessed the word correctly.");
                    resetGame();
                } else {
                    //updateMessage("Oops! Your guess is incorrect. Try again!");
                }
                guesses++;
                if (guesses >= difficultyThreshold) {
                    increaseDifficulty();
                }
            }
        }

        function increaseDifficulty() {
            currentDifficulty++;
            guesses = 0; // Reset guesses counter
            setCurrentArray(); // Update currentWordArray
            updateDifficultyLevel(); // Update difficulty level display
        }

        function updateDifficultyLevel() {
            var difficultyLevel = "Easy";
            if (currentDifficulty === 1) {
                difficultyLevel = "Medium";
            } else if (currentDifficulty === 2) {
                difficultyLevel = "Hard";
            } else if (currentDifficulty === 3) {
                difficultyLevel = "Expert";
            }

            difficultyLevelDisplay.textContent = "Difficulty Level: " + difficultyLevel;
        }

        function removeLetter(letter) {
            var index = selectedLetters.indexOf(letter);
            if (index !== -1) {
                selectedLetters.splice(index, 1);
                updateSelectedLettersDisplay();
                updateWordSelection();
                var buttons = letterButtons.getElementsByTagName("button");
                for (var i = 0; i < buttons.length; i++) {
                    if (buttons[i].textContent === letter) {
                        buttons[i].disabled = false;
                        break;
                    }
                }
            }
        }

        function resetSelection() {
            selectedLetters = [];
            updateSelectedLettersDisplay();
            updateWordSelection();
            var buttons = letterButtons.getElementsByTagName("button");
            for (var i = 0; i < buttons.length; i++) {
                buttons[i].disabled = false;
            }
            console.log(guesses);
        }

        function resetGame() {
            letterButtons.innerHTML = "";
            currentWord = getRandomWord();
            generateLetterButtons();
            resetSelection();
        }

        // Initialize the game
        generateLetterButtons();
    </script>

</body>
</html>