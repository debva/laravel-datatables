<?php

namespace Debva\LaravelDatatables\Utilities;

trait Footer
{
    protected $footer;

    /**
     * @param mixed $footer
     * 
     * @return self
     */
    public function footer($footer): self
    {
        $this->footer = call_user_func($footer);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getFooter()
    {
        return $this->footer;
    }
}
