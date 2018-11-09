<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class ShowArtwork extends AbstractTool
{
    protected  $countUser;
    protected  $total;
    function __construct($countUser,$total)
    {
        $this->url = $countUser;
        $this->total = $total;

    }

    public function render()
    {
        $total = $this->total;

        $countUser = $this->countUser;
        return view('admin.tools.button', compact('total','countUser'));
    }
}
