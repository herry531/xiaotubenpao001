<?php

namespace App\Admin\Controllers;

use App\Financial;
use App\Movie;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Extensions\ExcelExpoter;

class FinancialController extends Controller
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


            $content->header('财务进账');
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

            $content->header('财务进账');
            $content->description('编辑信息');

            $content->body($this->form()->edit($id));
        });
    }

    public function lists($id)
    {

        return Admin::content(function (Content $content) use ($id) {

            $content->header('财务进账');
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

            $content->header('财务进账');


            $content->body($this->form());
        });
    }

    public function network()
    {
        return Admin::content(function (Content $content) {


            $content->header('财务月报表');
            $content->description('');
            $res =$this->grid()->getFilter()->execute();
            $eight = 0;
            $nine  = 0;
            $ten   = 0;
            $eleven = 0;
            $twelve =0;
            foreach($res as $value){
                if(substr($value['date'],0,7) == '2018-08'){
                   $eight += $value['price'];
                }elseif(substr($value['date'],0,7) == '2018-09'){
                   $nine  += $value['price'];
                }elseif(substr($value['date'],0,7) == '2018-10'){
                    $ten += $value['price'];
                }elseif(substr($value['date'],0,7) == '2018-11'){
                    $eleven += $value['price'];
                }elseif(substr($value['date'],0,7) == '2018-12'){
                    $twelve += $value['price'];
                }

                //一月


            }

            $id  = (request()->route('id'));



            $content->body(view('admin.charts.financial',compact('eight','nine','ten','eleven','twelve')));

        });

    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Financial::class, function (Grid $grid) {

            $grid->actions(function ($actions) {
                // append一个操作

                $actions->disableDelete();
            });
            $grid->model()->orderBy('id', 'desc');
            $grid->id('ID')->sortable();
            $grid->product('产品');

            $grid->price('价格');
            $grid->source('来源');
            $grid->note('备注');
            $grid->date('日期');



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

            $grid->define_preg3(url('admin/financial/1/network'), '月报数据');


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

        return Admin::form(Financial::class, function (Form $form) {

            $form->row(function ($row) use ($form) {
                $row->width(4)->text('product', '产品');
                $row->width(2)->currency('price', '价格')->symbol('￥');
                $row->width(4)->text('source','来源');

                $row->width(4)->text('note','备注');
                $row->width(4)->date('date','日期');


            }, $form);
        });


    }
}
