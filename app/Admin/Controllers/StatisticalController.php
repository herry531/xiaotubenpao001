<?php

namespace App\Admin\Controllers;

use App\Movie;

use App\Statistical;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Extensions\ExcelExpoter;

use App\Models\Post;

use Encore\Admin\Show;

class StatisticalController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {


            $content->header('数据统计');
            $content->description('　');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('数据统计');
            $content->description('编辑信息');

            $content->body($this->form()->edit($id));
        });
    }


    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('数据统计');
            $content->description('新增');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Statistical::class, function (Grid $grid) {

                $grid->actions(function ($actions) {
                    // append一个操作
//                    $actions->append("<a href='movies/{$actions->getKey()}/list'><i class='fa fa-eye'></i></a>");
                    $actions->disableDelete();
                        // append一个操作
                    $actions->disableView();

                });
            $grid->name('数据名称')->display(function ($name) {
                return "<span class='label label-success'>$this->name</span>";
            });
                $grid->model()->orderBy('id', 'desc');
                $grid->url('链接')->link();
                $grid->disableFilter();
                $grid->disableExport();
                $grid->tools(function ($tools) {
                    $tools->batch(function ($batch) {
                        $batch->disableDelete();
                    });
                });
                $grid->paginate(15);


        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */



    protected function form()
    {
        return Admin::form(Statistical::class, function (Form $form) {
            $form->row(function ($row) use ($form) {
                $row->width(4)->text('name', '姓名');
                $row->width(4)->text('url', '地址');
            }, $form);
            $form->tools(function (Form\Tools $tools) {

                // 去掉`列表`按钮
                $tools->disableList();

                // 去掉`删除`按钮
                $tools->disableDelete();

                // 去掉`查看`按钮
                $tools->disableView();


            });
        });


    }
}
