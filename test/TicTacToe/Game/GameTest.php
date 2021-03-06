<?php


namespace JSK\TicTacToe\Game;


class GameTest extends \PHPUnit_Framework_TestCase {

  public function test_game_checks_with_referee_to_see_if_move_is_valid()
  {
    $refereeSpy = new RefereeSpy();
    $target = new Game($refereeSpy);
    $state = new State();
    $move = new PlayerMoveStub('JSK', 123, 321);

    $target->makeMove($move, $state);
    $this->assertEquals($refereeSpy->moveMakeCallCalledWith(), $move);
  }

  public function test_game_returns_expected_state_object()
  {
    $state = new State();
    $target = new Game(new RefereeSpy());
    $move = PlayerMove::forX(0, 0);
    $newState = $target->makeMove($move, $state);
    $moveHistory = $newState->getMoveHistory();
    $this->assertEquals($move, $moveHistory[0]);
  }

  public function test_game_returns_expected_state_object_on_second_play_too()
  {
    $target = new Game(new RefereeSpy(), new State());
    $move = PlayerMove::forX(0, 0);
    $move2 = PlayerMove::forO(0, 1);

    $state = new State();
    $state = $target->makeMove($move, $state);
    $state = $target->makeMove($move2, $state);
    $moveHistory = $state->getMoveHistory();

    $this->assertEquals($move, $moveHistory[0]);
    $this->assertEquals($move2, $moveHistory[1]);
  }

  public function test_game_can_evaluate_move()
  {
    $state = new State();
    $target = new Game(new RefereeSpy());
    $target->isValidMove(PlayerMove::forX(0, 0), $state);
  }

  public function test_playing_an_invalid_move_throws_an_exception()
  {
    $this->setExpectedException(IllegalMoveException::class);
    $refereeSpy = new IllegalMoveRefereeStub();
    $target = new Game($refereeSpy);
    $target->makeMove(PlayerMove::forX(0, 0), new State());
  }

}

class RefereeSpy extends Referee {

  /** @var  Move */
  private $move;

  function __construct() { }

  /**
   * @param Move $move
   * @param array $moveHistory
   * @return bool
   */
  public function makeCall(Move $move, array $moveHistory)
  {
    $this->move = $move;
    return true;
  }


  public function moveMakeCallCalledWith()
  {
    return $this->move;
  }

  public function winnerIsX(array $moveHistory) { return false; }
  public function winnerIsO(array $moveHistory) { return false; }

}

class IllegalMoveRefereeStub extends Referee {
  public function __construct() {}
  public function makeCall(Move $move, array $moveHistory) { return false; }
}

class PlayerMoveStub extends PlayerMove {
  /** @var  */
  private $player;
  private $row;
  private $column;

  public function __construct($player, $row, $column)
  {
    $this->player = $player;
    $this->row = $row;
    $this->column = $column;
  }
}

