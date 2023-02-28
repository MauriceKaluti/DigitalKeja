<?php


namespace Innox\Classes\Handlers;


class ReportCard
{
    private  $title;
    private  $value;
    private  $icon;
    private  $uri;
    private  $bgColor = 'bg-yellow';

    public static  function build()
    {
        return new static();
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }


    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

        public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    public function setUri($uri = "#!")
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * @param mixed $bgColor
     * @return ReportCard
     */
    public function setBgColor($bgColor)
    {
        $this->bgColor = $bgColor;

        return $this;
    }
    public function card()
    {
        $html = '';

        ob_start();
        ?>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box <?= $this->bgColor?>">
                <div class="inner">
                    <h3><?= $this->value ?></h3>

                    <p><?= $this->title ?></p>
                </div>
                <div class="icon">
                    <i class="fa <?= $this->icon ?>"></i>
                </div>
                <a href="<?= $this->uri ?>" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <?php

        return ob_get_clean();



    }

    public function output()
    {
        return '';

    }


}
