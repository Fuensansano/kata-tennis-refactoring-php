<?php

namespace TennisGame;

class TennisGame3 implements TennisGame
{
    private const ADVANTAGE_POINT = 1;
    private const MAX_POINTS_BEFORE_ADVANTAGE = 4;
    private const DEUCE = "Deuce";
    private const POINTS = ["Love", "Fifteen", "Thirty", "Forty"];
    private const EARLY_SUM_POINTS = 6;
    private int $player1Score = 0;
    private int $player2Score = 0;
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
            $this->player1Score++;
        }
        if ($playerName === $this->player2Name) {
            $this->player2Score++;
        }
    }

    private function isADraw(): bool
    {
        return $this->player1Score === $this->player2Score;
    }

    private function extractAdvantagePoint(): int
    {
        return $this->player1Score - $this->player2Score;
    }

    private function extractAdvantagePlayerName(): string
    {
        if ($this->player1Score > $this->player2Score) {
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
        return $this->player1Score < self::MAX_POINTS_BEFORE_ADVANTAGE
            && $this->player2Score < self::MAX_POINTS_BEFORE_ADVANTAGE
            && !($this->player1Score + $this->player2Score === self::EARLY_SUM_POINTS);
    }

    private function extractGameScore(): string
    {
        $set1 = self::POINTS[$this->player1Score];
        if (($this->isADraw())) {
            return "$set1-All";
        }

        $set2 = self::POINTS[$this->player2Score];
        return "$set1-$set2";
    }
}
