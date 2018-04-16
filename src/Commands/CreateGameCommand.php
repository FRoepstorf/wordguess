<?php

declare(strict_types=1);

namespace AE\Commands;

use AE\Domain\Game\Repository\GameMapper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateGameCommand extends Command
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
        $this
              //Sets the name for this command
             ->setName('game:new')
             //Sets the description that is shown while the command executes
             ->setDescription('Creates a new game...')
             //Sets the help description when appended with --help
             ->setHelp("This command create a new game for you");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //Since you can only play one game at a time, it will clear the database before a new game
        $this->gameMapper->deleteGame();
        $this->gameMapper->persistNewGame(
            $this->commandParameters->wordToGuessInit(),
            $this->commandParameters->guessedCharsInit()
        );
        $output->writeln([
            "Game created!",
            "============",
            "Start guessing by using game:guess + the character you want to try! E.g game:guess a"
        ]);
    }
}
