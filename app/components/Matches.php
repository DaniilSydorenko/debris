<?php
/*******************************************************************************
 * Name: App -> Components -> Admin
 * Version: 1.0
 * Author: Daniil Sydorenko (daniildeveloper@gmail.com)
 ******************************************************************************/


// Default namespace
namespace App\Components\Admin;

use Gaia\Components\ORM\Doctrine;
use App\Libraries\Controllers\Twig;

/**
 * Class Matches
 */
class Matches
{
    /**
     * Create match
     *
     * @param $firstPlayerId
     * @param $secondPlayerId
     * @param $firstScore
     * @param $secondScore
     * @param $operatorId
     * @param $roundId
     * @return bool|string
     * @throws \Exception
     */
    public function createMatch($firstPlayerId, $secondPlayerId, $firstScore, $secondScore, $operatorId, $roundId)
    {
        // Error message
        $errorMessage = null;

        // Get doctrine instance
        $Doctrine = Doctrine::getInstance();

        // Try to get round
        $Round = $roundId ? $Doctrine->getRepository("\\App\\Models\\Round")->findOneBy(["id" => $roundId]) : null;

        if (!$Round) {
            // Throw error
            throw new \Exception(_("Runda nie istnieje!"), \App\Libraries\Error\Code::ROUND_DOES_NOT_EXISTS);
        }

        // Try to get operator(current user)
        $Operator = $operatorId ? $Doctrine->getRepository("\\App\\Models\\User")
            ->findOneBy(["id" => $operatorId]) : null;

        // Try to get first player
        $FirstUser = $firstPlayerId ? $Doctrine->getRepository("\\App\\Models\\User")
            ->findOneBy(["id" => $firstPlayerId]) : null;

        // Try to get second player
        $SecondUser = $secondPlayerId ? $Doctrine->getRepository("\\App\\Models\\User")
            ->findOneBy(["id" => $secondPlayerId]) : null;

        if (!$FirstUser || !$SecondUser) {
            // Throw error
            throw new \Exception(_("Użytkownik nie istnieje!"), \App\Libraries\Error\Code::USER_DOES_NOT_EXISTS);
        }

        // League id
        $leagueId = $Round->getSeason()->getLeague()->getId();

        // Try to get league
        $League = $Doctrine->getRepository("\\App\\Models\\League")->find($leagueId);

        // Get sets limit
        $setsLimit = $League->getSetsLimit();

        // Try to get matches
        $UsersMatches = $Doctrine->getRepository("\\App\\Models\\Match")->getAllMatches();

        // Validate score value
        $validatedScore = $this->validateScoreValues($firstScore, $secondScore, $setsLimit);

        if (!$validatedScore) {
            // Error message
            $errorMessage = "Niepoprawne wartości wyników!";
        } elseif (is_array($UsersMatches) && !empty($UsersMatches)) {
            foreach ($UsersMatches as $matchData) {
                // If users was playing before in this round - throw error
                if ($firstPlayerId == $secondPlayerId) {
                    // Error message
                    $errorMessage = "Użytkownik nie może grać sam z sobą!";
                } // Duplicated matches
                elseif (($matchData["users"][0]["id"] == $firstPlayerId && $matchData["users"][1]["id"] == $secondPlayerId && $matchData["rounds"]["id"] == $roundId) ||
                    ($matchData["users"][1]["id"] == $firstPlayerId && $matchData["users"][0]["id"] == $secondPlayerId && $matchData["rounds"]["id"] == $roundId)
                ) {
                    // Error message
                    $errorMessage = "Użytkownicy już grali między sobą w tej rundie!";
                }
            }
        }

        if ($errorMessage) {
            return $errorMessage;
        } else {
            // Start new transaction
            $Doctrine->getConnection()->beginTransaction();

            // Try to save match
            try {
                // Create new match
                $Match = new \App\Models\Match();

                // Set primary properties
                $Match->setOperator($Operator);
                $Match->setRound($Round);

                // Save new match
                $Doctrine->persist($Match);

                // Calculate points of match
                $firstUserPoints = $SecondUser->getRanking() * $firstScore;
                $secondUserPoints = $FirstUser->getRanking() * $secondScore;

                // Set first player
                $UserMatch = new \App\Models\User\Match();
                $UserMatch->setMatch($Match);
                $UserMatch->setUser($FirstUser);
                $UserMatch->setScore($firstScore);
                $UserMatch->setPoints($firstUserPoints);

                // Save new score for the first user
                $Doctrine->persist($UserMatch);

                // Save score
                $Doctrine->flush();

                // Set second player
                $UserMatch = new \App\Models\User\Match();
                $UserMatch->setMatch($Match);
                $UserMatch->setUser($SecondUser);
                $UserMatch->setScore($secondScore);
                $UserMatch->setPoints($secondUserPoints);

                // Save new score for the second user
                $Doctrine->persist($UserMatch);

                // Save score
                $Doctrine->flush();

                // Commit changes
                $Doctrine->getConnection()->commit();
            } catch (\Exception $Exception) {
                // Rollback transaction
                $Doctrine->getConnection()->rollback();

                // Close transaction
                $Doctrine->close();

                // Throw exception
                throw new \Exception(_('Przepraszamy, mecz nie może być zapisany. Sprobuj póżniej!'), \App\Libraries\Error\Code::MATCH_CANNOT_BE_CREATED);
            }

            return true;
        }
    }

    /**
     * Update match
     *
     * @param $id
     * @param $firstPlayerId
     * @param $secondPlayerId
     * @param $firstScore
     * @param $secondScore
     * @param $operatorId
     * @param $roundId
     * @return bool
     * @throws \Exception
     */
    public function updateMatch($id, $firstPlayerId, $secondPlayerId, $firstScore, $secondScore, $operatorId, $roundId)
    {
        // Get doctrine instance
        $Doctrine = Doctrine::getInstance();

        // Try to get round
        $Round = $roundId ? $Doctrine->getRepository("\\App\\Models\\Round")->findOneBy(["id" => $roundId]) : null;

        // If round is not exists or is not enabled - throw error
        if (!$Round || !$Round->isEnabled()) {
            // Throw error
            throw new \Exception(_("Runda nie aktywna!"));
        }

        // Try to get operator(current user)
        $Operator = $operatorId ? $Doctrine->getRepository("\\App\\Models\\User")->findOneBy(["id" => $operatorId]) : null;

        // Try to get first player
        $FirstUser = $firstPlayerId ? $Doctrine->getRepository("\\App\\Models\\User")->findOneBy(["id" => $firstPlayerId]) : null;

        // Try to get second player
        $SecondUser = $secondPlayerId ? $Doctrine->getRepository("\\App\\Models\\User")->findOneBy(["id" => $secondPlayerId]) : null;

        // If one of users is not exists - throw error
        if (!$FirstUser || !$SecondUser) {
            // Throw error
            throw new \Exception(_("Użytkownik nie istnieje!"), \App\Libraries\Error\Code::USER_DOES_NOT_EXISTS);
        }

        // Try to get match
        $Match = $Doctrine->getRepository("\\App\\Models\\Match")->findOneBy(["id" => $id]);

        // Try to get first user match
        $FirstUserMatch = $Doctrine->getRepository("\\App\\Models\\User\\Match")->findOneBy(["Match" => $Match, "User" => $firstPlayerId]);

        // Try to get second user match
        $SecondUserMatch = $Doctrine->getRepository("\\App\\Models\\User\\Match")->findOneBy(["Match" => $Match, "User" => $secondPlayerId]);

        // League id
        $leagueId = $Round->getSeason()->getLeague()->getId();

        // Try to get league
        $League = $Doctrine->getRepository("\\App\\Models\\League")->find($leagueId);

        // Get sets limit
        $setsLimit = $League->getSetsLimit();

        // Validate score value
        $validatedScore = $this->validateScoreValues($firstScore, $secondScore, $setsLimit);

        // Start new transaction
        $Doctrine->getConnection()->beginTransaction();

        if (!$validatedScore) {
            // Error message
            $errorMessage = "Nie poprawne wartości wyników!";
            return $errorMessage;
        } else {
            try {
                // Calculate points of match
                $firstUserPoints = $SecondUser->getRanking() * $firstScore;
                $secondUserPoints = $FirstUser->getRanking() * $secondScore;

                // Set match properties
                $Match->setRound($Round);
                $Match->setOperator($Operator);

                // Set first user match
                $FirstUserMatch->setScore($firstScore);
                $FirstUserMatch->setPoints($firstUserPoints);

                // Set second user match
                $SecondUserMatch->setScore($secondScore);
                $SecondUserMatch->setPoints($secondUserPoints);

                // Save score
                $Doctrine->flush();

                // Commit changes
                $Doctrine->getConnection()->commit();
            } catch (\Exception $Exception) {
                // Rollback transaction
                $Doctrine->getConnection()->rollback();

                // Close transaction
                $Doctrine->close();

                // Throw exception
                throw new \Exception($Exception->getMessage(), \App\Libraries\Error\Code::DATABASE_ERROR);
            }

            return true;
        }
    }

    /**
     * Validate score values
     *
     * @param $firstScore
     * @param $secondScore
     * @param $setsLimit
     * @return bool
     */
    protected function validateScoreValues($firstScore, $secondScore, $setsLimit)
    {
        // Check first score value for size and int value
        $firstScore = (\is_numeric($firstScore) && ($firstScore >= 0 && $firstScore <= $setsLimit)) ? $firstScore : null;

        // Check second score value for size and int value
        $secondScore = (\is_numeric($secondScore) && ($secondScore >= 0 && $secondScore <= $setsLimit)) ? $secondScore : null;

        // Match sum
        $matchSum = $firstScore + $secondScore;

        // Check if scores exists and check their sum value
        if ($firstScore === null || $secondScore === null || (($firstScore >= 1 && $secondScore >= 1) && $matchSum < 5)
            || $matchSum > $setsLimit || (($firstScore == 0 || $secondScore == 0) && $matchSum < 5)
        ) {
            return false;
        } else {
            return true;
        }
    }
}