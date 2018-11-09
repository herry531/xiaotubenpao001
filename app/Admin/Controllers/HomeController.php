<?php

namespace App\Admin\Controllers;

use App\Archives;
use App\Http\Controllers\Controller;
use App\Movie;
use App\Visiting;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index()
    {

        return Admin::content(function (Content $content) {

            $content->header('小兔奔跑后台管理系统');
            $content->description('');
            $archives =count($this->Archives()->getFilter()->execute());
            $movie =count($this->Movie()->getFilter()->execute());
            $visiting =count($this->Visiting()->getFilter()->execute());

            $scale = round($visiting/$archives*100);

            $content->body(view('admin.charts.test',compact('movie','visiting','archives','scale')));

        });
    }


    protected function Archives()
    {
        return Admin::grid(Archives::class, function (Grid $grid) {



        });
    }

    protected function Movie()
    {
        return Admin::grid(Movie::class, function (Grid $grid) {



        });
    }

    protected function Visiting()
    {
        return Admin::grid(Visiting::class, function (Grid $grid) {



        });
    }
}
