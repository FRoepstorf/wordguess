#What is this?

This game is about guessing a given word, pretty much like hangman but without the hanging man.

##How to use

###Requirements
Install docker https://docs.docker.com/install/

Install docker-compose https://docs.docker.com/compose/install/#prerequisites

###How to use
Create a new game

```docker exec -it wordguess_php_1 php application.php game:new```

Guess a character

```docker exec -it wordguess_php_1 php application.php game:guess YOUR_GUESS ```
