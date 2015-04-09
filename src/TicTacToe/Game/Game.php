<?php


namespace JSK\TicTacToe\Game;


class Game {

  /** @var  Referee */
  private $referee;

  function __construct(Referee $referee)
  {
    $this->referee = $referee;
  }

  public function makeMove(Move $move, State $state)
  {
    if (!$this->isValidMove($move, $state)) {
      throw new IllegalMoveException('This is not a valid move');
    }

    $state->addMoveToMoveHistory($move);

    $moveHistory = $state->getMoveHistory();
    $state->setWinnerIsX($this->referee->winnerIsX($moveHistory));
    $state->setWinnerIsO($this->referee->winnerIsO($moveHistory));

    return $state;
  }

  public function isValidMove(Move $move, State $state)
  {
    /** @var Move[] $lastMoves */
    $lastMoves = $state->getMoveHistory();
    return $this->referee->makeCall($move, $lastMoves);
  }

}