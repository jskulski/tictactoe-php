<?php


namespace JSK\TicTacToe\CLI;


use JSK\TicTacToe\Game\Factory;
use JSK\TicTacToe\Game\Game;
use JSK\TicTacToe\Game\Move;
use JSK\TicTacToe\Game\PlayerMove;
use JSK\TicTacToe\Game\State;


class MakeRocketGo {

  /** @var Factory */
  private $factory;

  function __construct($factory)
  {
    $this->factory = $factory;
  }

  public function run()
  {
    /** @var Game $game */
    $game = $this->factory->createGame();
    /** @var State $state */
    $state = new State();

    while (true) {
      $this->renderGameState($state);

      $rowInput = $this->promptUserForRow();
      if ($this->hasUserQuit($rowInput)) {
        break;
      }

      $columnInput = $this->promptUserForColumn();
      if ($this->hasUserQuit($columnInput)) {
        break;
      }

      $row = $this->mapInputToCoordinate($rowInput);
      $column = $this->mapInputToCoordinate($columnInput);

      if ($state->isPlayerXTurn()) {
        $move = PlayerMove::forX($row, $column);
      }
      else {
        $move = PlayerMove::forO($row, $column);
      }

      if ($game->isValidMove($move, $state)) {
        $state = $game->makeMove($move, $state);
      }
      else {
        \cli\line("Sorry that move was invalid. Try again");
      }

      if ($state->winnerIsX()) {
        \cli\line("Player X wins!");
        $this->renderGameState($state);
        break;
      }
      else if ($state->winnerIsO()) {
        \cli\line("Player O wins!");
        $this->renderGameState($state);
        break;
      }
      else if ($state->isTiedGame()) {
        \cli\line("Cat's Game! Tied!");
        $this->renderGameState($state);
        break;
      }

    }
  }

  public function renderGameState(State $state) {
    $markersOnBoard = array(
      array(' - ', ' - ', ' - '),
      array(' - ', ' - ', ' - '),
      array(' - ', ' - ', ' - ')
    );
    $moves = $state->getMoveHistory();
    foreach ($moves as $move) {
      /** @var $move Move */
      $marker = $move->isX() ? 'X' : 'O';
      $row = $this->mapInputToBoardMarker($move->getRow());
      $col = $this->mapInputToBoardMarker($move->getColumn());
      $markersOnBoard[$row][$col] = $marker;
    }

    $table = new \cli\Table();
    $table->setRows($markersOnBoard);
    $table->display();
  }


  /**
   * @return array
   */
  public function promptUserForRow()
  {
    $row = \cli\Streams::prompt('Row', null, '[1/2/3] ? ');
    return $row;
  }

  public function promptUserForColumn() {
    $column = \cli\Streams::prompt('Column', null, '[1/2/3] ? ');
    return $column;
  }

  /**
   * @param $row
   * @param $column
   * @return bool
   */
  private function hasUserQuit($input)
  {
    if ($input == 'q') {
      return true;
    }
    return false;
  }

  private function mapInputToBoardMarker($input) {
    $map = array(
      '-1' => 0,
      '0' => 1,
      '1' => 2
    );
    return $map[$input];
  }

  private function mapInputToCoordinate($input)
  {
    $map = array(
      '1' => -1,
      '2' =>  0,
      '3' =>  1
    );
    return $map[$input];
  }

}
