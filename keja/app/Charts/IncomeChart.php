<?php

namespace App\Charts;

use App\DB\Building\Room;
use App\DB\Lease\Invoice;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;


class IncomeChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

}
