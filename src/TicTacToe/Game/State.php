<?php


namespace JSK\TicTacToe\Game;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;

/**
 * Class State
 * @package JSK\TicTacToe\Game
 * @Entity
 */
class State {

  /**
   * @var int
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   */
  private $stateId;

  /**
   * @var  PlayerMove[]
   */
  private $moveHistory = array();

  /**
   * @var  boolean
   * @Column(type="boolean")
   */
  private $winnerIsX = true;

  /**
   * @var  boolean
   * @Column(type="boolean")
   */
  private $winnerIsO = true;

  /**
   * @var  boolean
   * @Column(type="boolean")
   */
  private $tiedGame = false;

  /**
   * @var  boolean
   * @Column(type="boolean")
   */
  private $isPlayerXTurn = true;


  public function __construct() { }

  /**
   * @return Move[]
   */
  public function getMoveHistory()
  {
    return $this->moveHistory ? $this->moveHistory : array();
  }

  /**
   * @param PlayerMove[] $moveHistory
   */
  public function setMoveHistory($moveHistory)
  {
    $this->moveHistory = $moveHistory;
  }

  /**
   * @param boolean $playerXTurn
   */
  public function setPlayerXTurn($playerXTurn)
  {
    $this->isPlayerXTurn = $playerXTurn;
  }

  public function isPlayerXTurn()
  {
    return $this->isPlayerXTurn;
  }

  public function isPlayerOTurn()
  {
    return !$this->isPlayerXTurn();
  }

  /**
   * @return bool
   */
  public function isOver()
  {
    $isBoardFull = count($this->getMoveHistory()) == 9;
    $hasWinner = $this->winnerIsX() || $this->winnerIsO();
    return $isBoardFull || $hasWinner;
  }

  /**
   * @param $winnerIsX boolean
   */
  public function setWinnerIsX($winnerIsX) {
    $this->winnerIsX = $winnerIsX;
  }

  /**
   * @return bool
   */
  public function winnerIsX() {
    return $this->winnerIsX;
  }

  /**
   * @param $winnerIsO boolean
   */
  public function setWinnerIsO($winnerIsO) {
    $this->winnerIsO = $winnerIsO;
  }

  /**
   * @return bool
   */
  public function winnerIsO()
  {
    return $this->winnerIsO;
  }

  /**
   * @return boolean
   */
  public function isTiedGame()
  {
    return $this->tiedGame;
  }

  /**
   * @param boolean $tiedGame
   */
  public function setTiedGame($tiedGame)
  {
    $this->tiedGame = $tiedGame;
  }

  /**
   * @param Move
   * @return State
   */
  public function addMoveToMoveHistory(Move $move) {
    $moveHistory = $this->getMoveHistory();
    array_push($moveHistory, $move);
    $this->moveHistory = $moveHistory;
  }



  /**
   * @return int
   */
  public function getStateId()
  {
    return $this->stateId;
  }

  /**
   * @param int $stateId
   */
  public function setStateId($stateId)
  {
    $this->stateId = $stateId;
  }

}

