<?php

class LuckyTicket {
    public string $first;
    public string $end;
    public array $luckyTickets = [];

    public function __construct()
    {
        [$first, $end] = $this->getValidatedParams();

        $this->first = $first;
        $this->end = $end;
    }

    /**
     * @return array|void
     */
    public function getValidatedParams()
    {
        if ( ! (isset($_GET['first']) && isset($_GET['end']))) {
            die("Please, provide 'first' and 'end' parameters.");
        }

        $first = $_GET['first'];
        $end = $_GET['end'];

        if (strlen($first) != 6 || strlen($first) != strlen($end)) {
            die("Length of ticket must be equal to 6.");
        }

        if ( ! (ctype_digit($first) && ctype_digit($end))) {
            die("'first' and 'end' must be numeric.");
        }

        if ($first > $end) {
            die("'first' must be less than 'end'.");
        }

        return [$first, $end];
    }

    public function count(): int
    {
        for ($i = (int) $this->first; $i <= (int) $this->end; $i++) {
            $number = str_pad($i, 6, '0', STR_PAD_LEFT);

            $sumLeft = $number[0] + $number[1] + $number[2];
            $sumRight = $number[3] + $number[4] + $number[5];

            if ($sumLeft >= 10) {
                $sumLeftSplitted = str_split($sumLeft);
                $sumLeft = $sumLeftSplitted[0] + $sumLeftSplitted[1];
            }

            if ($sumRight >= 10) {
                $sumRightSplitted = str_split($sumRight);
                $sumRight = $sumRightSplitted[0] + $sumRightSplitted[1];
            }

            if ($sumLeft == $sumRight) {
                $this->luckyTickets[] = $number;
            }
        }

        return count($this->luckyTickets);
    }
}

$luckyTickets = new LuckyTicket();
echo $luckyTickets->count();
