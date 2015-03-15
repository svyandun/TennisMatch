<?php namespace Acme;

class Tennis {

    private $player1;

    private $player2;

    private $lookup = [
        '0' => 'Love',
        '1' => 'Fifteen',
        '2' => 'Thirty',
        '3' => 'Fourty',
    ];

    public function __construct(Player $player1, Player $player2)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;
    }


    public function score()
    {
        if ($this->hasWinner())
        {
            return 'Game ' . $this->leader()->name;
        }

        if ($this->hasTheAdvantage())
        {
            return 'Advantage ' . $this->leader()->name;
        }

        if ($this->inDeuce())
        {
            return 'Deuce';
        }

        return $this->generalScore();
    }

    private function hasWinner()
    {
        return $this->hasEnoughPointsToBeWon() && $this->isLeadingByAtLeastTwo();
    }

    private function hasTheAdvantage()
    {
        return $this->hasEnoughPointsToBeWon() && $this->isLeadingByOne();
    }

    private function inDeuce()
    {
        return $this->player1->points + $this->player2->points >= 6 && $this->tied();
    }

    private function generalScore()
    {
        $score = $this->lookup[$this->player1->points] . '-';
        $score .= $this->tied() ? 'All' : $this->lookup[$this->player2->points];
        return $score;

    }

    private function leader()
    {
        return $this->player1->points > $this->player2->points
            ? $this->player1
            : $this->player2;
    }

    private function tied()
    {
        return $this->player1->points == $this->player2->points;
    }

    private function hasEnoughPointsToBeWon()
    {
        return max([$this->player1->points, $this->player2->points]) >= 4;
    }

    private function isLeadingByAtLeastTwo()
    {
        return abs($this->player1->points - $this->player2->points) >= 2;
    }

    private function isLeadingByOne()
    {
        return abs($this->player1->points - $this->player2->points) == 1;
    }

}
