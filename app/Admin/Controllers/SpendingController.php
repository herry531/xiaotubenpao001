<?php

namespace App\Admin\Controllers;

use App\Financial;
use App\Movie;

use App\Spending;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Extensions\ExcelExpoter;
use Encore\Admin\Show;

class SpendingController extends Controller
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


            $content->header('财务出账');
            $content->description('');

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

            $content->header('财务出账');
            $content->description('编辑信息');

            $content->body($this->form()->edit($id));
        });
    }
    public function show($id, Content $content)
    {

        return $content->header('Post')
            ->description('详情')
            ->body(Admin::show(Spending::findOrFail($id), function (Show $show) {

                $show->panel()
                    ->tools(function ($tools) {
                        $tools->disableEdit();

                        $tools->disableDelete();
                    });;

//                $show->panel()
//                    ->style('danger')
//                    ->title('基本信息');
                $show->spending('支出项目');
                $show->price('价格');
                $show->name('支出人');
                $show->baoxiao('报销');
                $show->date('日期');
                $show->images('照片')->urlWrapper();


            }));
    }


    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('财务出账');


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
        return Admin::grid(Spending::class, function (Grid $grid) {
            $grid->spending('支出项目');
            $grid->price('价格');
            $grid->name('支出人');
            $grid->baoxiao('报销');
            $grid->column('images')->urlWrapper();
            $grid->note('备注');
            $grid->date('日期');
            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
            });
            $grid->actions(function ($actions) {
                // append一个操作

                $actions->disableDelete();
            });
        });
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */

    protected function form()
    {

        return Admin::form(Spending::class, function (Form $form) {

            $form->row(function ($row) use ($form) {

                $row->width(4)->text('spending', '支出项目')->rules('required');
                $row->width(2)->currency('price', '价格')->symbol('￥')->rules('required');
                $row->width(4)->text('note','备注');
                $row->width(4)->select('name','支出人')->options(['海鸥'=>'海鸥','老鹰'=>'老鹰','猞猁'=>'猞猁','刺猬'=>'刺猬','海龟'=>'海龟'])->rules('required');
                $row->width(4)->select('baoxiao','是否报销')->options(['是'=>'是','否'=>'否','不报销'=>'不报销'])->rules('required');

                $row->width(4)->date('date','日期')->rules('required');
                $row->width(4)->image('images','照片');
            }, $form);
            $form->tools(function (Form\Tools $tools) {
                // 去掉`删除`按钮
                $tools->disableDelete();

            });
        });


    }
}
