<?php


namespace JSK\TicTacToe\Game;


class MoveFilterer {

  const TOP_ROW    = -1;
  const MIDDLE_ROW =  0;
  const BOTTOM_ROW =  1;

  const LEFT_COLUMN   = -1;
  const MIDDLE_COLUMN =  0;
  const RIGHT_COLUMN  =  1;

  /** @var  Move[] */
  private $moves;

  /**
   * @param $moves Move[]
   */
  function __construct($moves = array()) {
    $this->moves = $moves;
  }

  /**
   * @param Move[] $moves
   * @return MoveFilterer
   */
  public function filter(array $moves)
  {
    return new MoveFilterer($moves);
  }

  /**
   * @return MoveFilterer
   */
  public function movesByO()
  {
    $filtered = array_filter($this->moves, function($move) {
      /** @var $move Move */
      return $move->isO();
    });
    return new MoveFilterer($filtered);
  }

  /**
   * @return MoveFilterer
   */
  public function movesByX()
  {
    $filtered = array_filter($this->moves, function($move) {
      /** @var $move Move */
      return $move->isX();
    });
    return new MoveFilterer($filtered);
  }


  /** @return MoveFilterer */
  public function movesInTopRow()    { return $this->movesInRow(self::TOP_ROW); }
  /** @return MoveFilterer */
  public function movesInMiddleRow() { return $this->movesInRow(self::MIDDLE_ROW); }
  /** @return MoveFilterer */
  public function movesInBottomRow() { return $this->movesInRow(self::BOTTOM_ROW); }

  /** @return MoveFilterer */
  public function movesInLeftColumn()   { return $this->movesInColumn(self::LEFT_COLUMN); }
  /** @return MoveFilterer */
  public function movesInMiddleColumn() { return $this->movesInColumn(self::MIDDLE_COLUMN); }
  /** @return MoveFilterer */
  public function movesInRightColumn()  { return $this->movesInColumn(self::RIGHT_COLUMN); }


  /**
   * @return MoveFilterer
   */
  public function movesInLeftToRightDiagonal()
  {
    $filtered = array_filter($this->moves, function($move) {
      /** @var $move Move */
      return
        ($move->getColumn() == self::LEFT_COLUMN && $move->getRow()  == self::TOP_ROW) ||
        ($move->getColumn() == self::MIDDLE_COLUMN && $move->getRow() == self::MIDDLE_ROW) ||
        ($move->getColumn() == self::RIGHT_COLUMN && $move->getRow()  == self::BOTTOM_ROW);
    });
    return new MoveFilterer($filtered);
  }

  /**
   * @return MoveFilterer
   */
  public function movesInRightToLeftDiagonal()
  {
    $filtered = array_filter($this->moves, function($move) {
      /** @var $move Move */
      return
        ($move->getColumn() == self::RIGHT_COLUMN && $move->getRow()  == self::TOP_ROW) ||
        ($move->getColumn() == self::MIDDLE_COLUMN && $move->getRow() == self::MIDDLE_ROW) ||
        ($move->getColumn() == self::LEFT_COLUMN && $move->getRow()  == self::BOTTOM_ROW);
    });
    return new MoveFilterer($filtered);
  }

  /** @return Move */
  public function moveInTopLeft() { return $this->movesInTopRow()->movesInLeftColumn()->getMove(); }
  /** @return Move */
  public function moveInTopMiddle() { return $this->movesInTopRow()->movesInMiddleColumn()->getMove(); }
  /** @return Move */
  public function moveInTopRight() { return $this->movesInTopRow()->movesInRightColumn()->getMove(); }

  /** @return Move */
  public function moveInMiddleLeft() { return $this->movesInMiddleRow()->movesInLeftColumn()->getMove(); }
  /** @return Move */
  public function moveInMiddleMiddle() { return $this->movesInMiddleRow()->movesInMiddleColumn()->getMove(); }
  /** @return Move */
  public function moveInMiddleRight() { return $this->movesInMiddleRow()->movesInRightColumn()->getMove(); }

  /** @return Move */
  public function moveInBottomLeft() { return $this->movesInBottomRow()->movesInLeftColumn()->getMove(); }
  /** @return Move */
  public function moveInBottomMiddle() { return $this->movesInBottomRow()->movesInMiddleColumn()->getMove(); }
  /** @return Move */
  public function moveInBottomRight() { return $this->movesInBottomRow()->movesInRightColumn()->getMove(); }


  /**
   * @return int
   */
  public function count() {  return count($this->moves); }

  /**
   * @param $row int
   * @return MoveFilterer
   */
  private function movesInRow($row)
  {
    $filtered = array_filter($this->moves, function($move) use ($row) {
      /** @var $move Move */
      return $move->getRow() == $row;
    });
    return new MoveFilterer($filtered);
  }

  /**
   * @param $column int
   * @return MoveFilterer
   */
  private function movesInColumn($column)
  {
    $filtered = array_filter($this->moves, function($move) use ($column) {
      /** @var $move Move */
      return $move->getColumn() == $column;
    });
    return new MoveFilterer($filtered);
  }


  /**
   * @return Move
   */
  private function getMove()
  {
    $move = array_pop($this->moves);
    return $move ? $move : new NullMove();
  }


}

