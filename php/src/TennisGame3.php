<?php

namespace TennisGame;

class TennisGame3 implements TennisGame
{
    const ADVANTAGEPOINT = 1;
    private $points =["Love", "Fifteen", "Thirty", "Forty"];
    private $scorePlayer1 = 0;
    private $scorePlayer2 = 0;
    private $player1Name = '';
    private $player2Name = '';
    private  const DEUCE  = "Deuce";

    public function __construct($player1Name, $player2Name)
    {
        $this->player1Name = $player1Name;
        $this->player2Name = $player2Name;
    }

    public function getScore()
    {
        if ($this->scorePlayer1 < 4 && $this->scorePlayer2 < 4 && !($this->scorePlayer1 + $this->scorePlayer2 == 6)) {
            $set = $this->points[$this->scorePlayer1];
            return ($this->isADraw()) ? "{$set}-All" : "{$set}-{$this->points[$this->scorePlayer2]}";
        } else {
            if ($this->isADraw()) {
                return self::DEUCE;
            }
            $set = $this->scorePlayer1 > $this->scorePlayer2 ? $this->player1Name : $this->player2Name;
            return (($this->extractAdvantagePoint()) * ($this->extractAdvantagePoint()) == self::ADVANTAGEPOINT) ? "Advantage {$set}" : "Win for {$set}";
        }
    }

    public function wonPoint($playerName)
    {
        if ($playerName == "player1") {
            $this->scorePlayer1++;
        } else {
            $this->scorePlayer2++;
        }
    }

    /**
     * @return bool
     */
    public function isADraw(): bool
    {
        return $this->scorePlayer1 == $this->scorePlayer2;
    }

    /**
     * @return int
     */
    public function extractAdvantagePoint(): int
    {
        return $this->scorePlayer1 - $this->scorePlayer2;
    }

}
