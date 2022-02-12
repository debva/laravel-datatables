<?php

namespace Debva\Utilities;

trait Footer
{
    protected $footer;

    public function footer($footer)
    {
        $this->footer = call_user_func($footer);
        return $this;
    }

    public function getFooter()
    {
        return $this->footer;
    }
}
