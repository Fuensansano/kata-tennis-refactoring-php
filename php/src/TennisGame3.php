<?php

namespace TennisGame;

class TennisGame3 implements TennisGame
{
    private const ADVANTAGE_POINT = 1;
    private const MAX_POINTS_BEFORE_ADVANTAGE = 4;
    private const DEUCE = "Deuce";
    private const POINTS = ["Love", "Fifteen", "Thirty", "Forty"];
    private const EARLY_SUM_POINTS = 6;
    private int $scorePlayer1 = 0;
    private int $scorePlayer2 = 0;
    private string $player1Name;
    private string $player2Name;

    public function __construct(string $player1Name, string $player2Name)
    {
        $this->player1Name = $player1Name;
        $this->player2Name = $player2Name;
    }

    public function getScore(): string
    {
        if ($this->isEarlyGameStage()) {
            return $this->extractGameScore();
        }
        if ($this->isADraw() ) {
            return self::DEUCE;
        }
        return $this->retrieveWinPlayerName();
    }

    public function wonPoint(string $playerName): void
    {
        if ($playerName === $this->player1Name) {
            $this->scorePlayer1++;
        }
        if ($playerName === $this->player2Name) {
            $this->scorePlayer2++;
        }
    }

    private function isADraw(): bool
    {
        return $this->scorePlayer1 === $this->scorePlayer2;
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
        if ($this->isOneAdvantagePoint()) {
            return "Advantage $set";
        }

        return "Win for $set";
    }

    private function isOneAdvantagePoint(): bool
    {
        return (($this->extractAdvantagePoint()) * ($this->extractAdvantagePoint()) === self::ADVANTAGE_POINT);
    }

    private function isEarlyGameStage(): bool
    {
        return $this->scorePlayer1 < self::MAX_POINTS_BEFORE_ADVANTAGE
            && $this->scorePlayer2 < self::MAX_POINTS_BEFORE_ADVANTAGE
            && !($this->scorePlayer1 + $this->scorePlayer2 === self::EARLY_SUM_POINTS);
    }

    private function extractGameScore(): string
    {
        $set1 = self::POINTS[$this->scorePlayer1];
        if (($this->isADraw())) {
            return "$set1-All";
        }

        $set2 = self::POINTS[$this->scorePlayer2];
        return "$set1-$set2";
    }
}
