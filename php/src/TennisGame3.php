<?php

namespace TennisGame;

class TennisGame3 implements TennisGame
{
    const ADVANTAGEPOINT = 1;
    private const MAX_POINTS_BEFORE_ADVANTAGE = 4;
    private  const DEUCE  = "Deuce";
    private $points =["Love", "Fifteen", "Thirty", "Forty"];
    private $scorePlayer1 = 0;
    private $scorePlayer2 = 0;
    private $player1Name = '';
    private $player2Name = '';

    public function __construct($player1Name, $player2Name)
    {
        $this->player1Name = $player1Name;
        $this->player2Name = $player2Name;
    }

    public function getScore()
    {
        if ($this->isEarlyGameStage()) {
            return $this->extractGameScore();
        }
        if ($this->isADraw() ) {
            return self::DEUCE;
        }
        return $this->retrieveWinPlayerName();
    }

    public function wonPoint($playerName)
    {
        if ($playerName == "player1") {
            $this->scorePlayer1++;
        } else {
            $this->scorePlayer2++;
        }
    }

    private function isADraw(): bool
    {
        return $this->scorePlayer1 == $this->scorePlayer2;
    }

    private function extractAdvantagePoint(): int
    {
        return $this->scorePlayer1 - $this->scorePlayer2;
    }

    private function extractAdvantagePlayerName(): string
    {
        if ($this->scorePlayer1 > $this->scorePlayer2) {
            return  $this->player1Name;
        }
        return $this->player2Name;
    }

    private function retrieveWinPlayerName(): string
    {
        $set = $this->extractAdvantagePlayerName();
        return $this->isOneAdvantagePoint() ? "Advantage {$set}" : "Win for {$set}";
    }

    private function isOneAdvantagePoint(): bool
    {
        return (($this->extractAdvantagePoint()) * ($this->extractAdvantagePoint()) == self::ADVANTAGEPOINT);
    }

    private function isEarlyGameStage():bool
    {
        return $this->scorePlayer1 < self::MAX_POINTS_BEFORE_ADVANTAGE &&
            $this->scorePlayer2 < self::MAX_POINTS_BEFORE_ADVANTAGE
            && !($this->scorePlayer1 + $this->scorePlayer2 == 6);
    }

    private function extractGameScore(): string
    {
        $set = $this->points[$this->scorePlayer1];
        return ($this->isADraw()) ? "{$set}-All" : "{$set}-{$this->points[$this->scorePlayer2]}";
    }
}
