<?php


namespace App\DataTables;


class BaseTable
{


    protected function buttons($actions)
    {
        ob_start();
        ?>
        <div class="btn-group btn-group-sm">
            <button type="button" class="btn btn-primary btn-sm dropdown-toggle keja-round" data-bs-toggle="dropdown" aria-expanded="false">
                Action <span class="caret"></span>
            </button>
            <ul class="dropdown-menu w-100 keja-bg p-2" role="menu">
                <?php
                echo  $actions;
                ?>
            </ul>
        </div>

        <?php
        return ob_get_clean();
    }


}
