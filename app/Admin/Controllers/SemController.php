<?php

namespace App\Admin\Controllers;

use App\Movie;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Extensions\ExcelExpoter;

class SemController extends Controller
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


            $content->header('用户信息');
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

            $content->header('用户信息');
            $content->description('编辑信息');

            $content->body($this->form()->edit($id));
        });
    }

    public function lists($id)
    {

        return Admin::content(function (Content $content) use ($id) {

            $content->header('用户信息');
            $content->description('编辑信息');

            $content->body($this->listfrom()->edit($id));
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

            $content->header('用户信息');
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
        return Admin::grid(Movie::class, function (Grid $grid) {

                $grid->actions(function ($actions) {
                    // append一个操作
                    $actions->append("<a href='movies/{$actions->getKey()}/list'><i class='fa fa-eye'></i></a>");
                    $actions->disableDelete();
                });
                $grid->model()->orderBy('id', 'desc');
                $grid->id('ID')->sortable();
                $grid->name('姓名');

                $grid->gender('性别');
                $grid->phone('电话');
                $grid->weixin_num('微信号');
                $grid->source('来源渠道');
                $grid->course('意向课程');
                $grid->care('在意问题点');


                $grid->tools(function ($tools) {
                    $tools->batch(function ($batch) {
                        $batch->disableDelete();
                    });
                });

                $grid->filter(function ($filter) {
                    $filter->like('name','姓名');
                    $filter->like('phone','电话');
                    $filter->like('weixin_name','微信名称');
                    $filter->like('weixin_num','微信号');
                    $filter->like('source','来源渠道');
                    $filter->like('visitors','是否到访');
                    $filter->between('one_data','初次沟通时间')->datetime();

                });
                $grid->paginate(15);

            $excel = new ExcelExpoter();
            $excel->setAttr(['姓名','性别','年龄','电话','微信名称','微信号','来源渠道','所在地区','学习目的','意向课程','职业','在意问题点','是否到访','详细信息','初次沟通时间','二次沟通时间','三次沟通时间','创建时间'], ['name', 'gender', 'age','phone', 'weixin_name','weixin_num','source','city','purpose','course','professional','care','visitors','text','one_data','tow_data','three_data','created_at']);
            $grid->exporter($excel);
//            $grid->exporter(new ExcelExpoter());
//            $grid->model()->where('id', '<', 100);
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */

    protected function listfrom()
    {
        return Admin::form(Movie::class, function (Form $form) {

            $form->row(function ($row) use ($form) {
                $row->width(4)->display('name', '姓名');
                $row->width(4)->display('age', '年龄');
                $row->width(4)->display('gender','性别');
                $row->width(4)->display('phone', '电话');
                $row->width(4)->display('weixin_name','微信名称');
                $row->width(4)->display('weixin_num','微信号');
                $row->width(4)->display('source','来源渠道');
                $row->width(4)->display('city','所在地区');
                $row->width(4)->display('purpose','学习目的');
                $row->width(4)->display('course','意向课程');
                $row->width(4)->display('professional','职业');
                $row->width(4)->display('care','在意问题点');
                $row->width(4)->display('text','具体详细信息');

                $row->width(4)->display('visit_data','到访日期');
                $row->width(4)->display('one_data','初次沟通时间');
                $row->width(4)->display('tow_data','二次沟通时间');
                $row->width(4)->display('three_data','三次沟通时间');

            }, $form);
        });
    }

    protected function form()
    {

        return Admin::form(Movie::class, function (Form $form) {

            $form->row(function ($row) use ($form) {
                $row->width(4)->text('name', '姓名');
                $row->width(4)->select('age', '年龄')->options(['20岁以下'=>'20岁以下','20-30岁'=>'20-30岁','30-40岁'=>'30-40岁','40岁+'=>'40岁+']);
                $row->width(4)->select('gender','性别')->options(['男'=>'男','女'=>'女','未知'=>'未知'])->rules('required');

                $row->width(4)->mobile('phone', '电话');
                $row->width(4)->text('weixin_name','微信名称');
                $row->width(4)->text('weixin_num','微信号');
                $row->width(4)->text('source','来源渠道');
                $row->width(4)->text('city','所在地区');
                $row->width(4)->text('purpose','学习目的');
                $row->width(4)->text('course','意向课程');
                $row->width(4)->text('professional','职业');
                $row->width(4)->text('care','在意问题点');
                $row->width(4)->text('text','具体详细信息');



                $row->width(4)->datetime('one_data','初次沟通时间');
                $row->width(4)->datetime('tow_data','二次沟通时间');
                $row->width(4)->datetime('three_data','三次沟通时间');

            }, $form);
        });


    }
}
