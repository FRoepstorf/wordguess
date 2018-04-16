<?php

declare(strict_types=1);

namespace AE\Commands;

use AE\Domain\Game\Repository\GameMapper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GuessCommand extends Command
{
    /**
     * @var GameMapper
     */
    private $gameMapper;

    /**
     * @var GameCommandParameters
     */
    private $commandParameters;

    public function __construct(GameMapper $gameMapper, GameCommandParameters $commandParameters)
    {
        parent::__construct();
        $this->gameMapper = $gameMapper;
        $this->commandParameters = $commandParameters;
    }

    protected function configure()
    {
        $this->setName('game:guess')
             ->setDescription('Guesses a char')
             ->addArgument('guess');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //Loads the game from the database
        $gameBeforeGuess = $this->gameMapper->game();
        $gameAfterGuess = $this->commandParameters->createGameAfterGuess($gameBeforeGuess, $input->getArgument('guess'));
        //Checks whether the player guessed the word allready
        if ($gameAfterGuess->remainingWordToGuess()->asString() === $gameAfterGuess->wordToGuess()->asString()) {
            $output->writeln("Correct! Thanks for playing!");
            $this->gameMapper->deleteGame();
        } else {
            $this->gameMapper->persistGuess($gameAfterGuess);
            $output->writeln([
                $gameAfterGuess->remainingWordToGuess()->asString(),
                "Continue to guess the word!"
            ]);
        }
    }
}