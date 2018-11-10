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

use App\Models\Post;

use Encore\Admin\Show;

class MovieController extends Controller
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

    public function show($id, Content $content)
    {
        return $content->header('Post')
            ->description('详情')
            ->body(Admin::show(Movie::findOrFail($id), function (Show $show) {
                $show->panel()
                    ->tools(function ($tools) {
                        $tools->disableEdit();

                        $tools->disableDelete();
                    });;

                $show->panel()
                    ->style('danger')
                    ->title('基本信息');
                $show->name('姓名');
                $show->age('年龄');
                $show->gender('性别');
                $show->phone('电话');
                $show->weixin_name('微信名称');
                $show->weixin_num('微信号');
                $show->source('渠道');
                $show->city('地区');
                $show->purpose('学习目的');
                $show->course('意向课程');
                $show->care('在意问题点');
                $show->text('具体详细信息');
                $show->one_data('初次沟通时间');
                $show->tow_data('二次沟通时间');
                $show->three_data('三次沟通时间');
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
//                    $actions->append("<a href='movies/{$actions->getKey()}/list'><i class='fa fa-eye'></i></a>");
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
                $grid->expandFilter('姓名');


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

                    $filter->between('one_data','初次沟通时间')->datetime();

                });
                $grid->paginate(15);

            $excel = new ExcelExpoter();
            $excel->setAttr(['姓名','性别','年龄','电话','微信名称','微信号','来源渠道','所在地区','学习目的','意向课程','职业','在意问题点','是否到访','详细信息','初次沟通时间','二次沟通时间','三次沟通时间','创建时间'], ['name', 'gender', 'age','phone', 'weixin_name','weixin_num','source','city','purpose','course','professional','care','visitors','text','one_data','tow_data','three_data','created_at']);
            $grid->exporter($excel);

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */



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
                $row->width(4)->select('source','报名来源')->options(['百度'=>'百度','微博'=>'微博','今日头条'=>'今日头条','360搜索'=>'360搜索','豆瓣'=>'豆瓣','公众号'=>'公众号','朋友圈'=>'朋友圈','抖音'=>'抖音','搜狐'=>'搜狐','美团'=>'美团','大众点评'=>'大众点评','熟人介绍'=>'熟人介绍','学员介绍'=>'学员介绍','其它'=>'其它'])->rules('required');
                $row->width(4)->text('city','所在地区');
                $row->width(4)->text('purpose','学习目的');
                $row->width(4)->text('course','意向课程');

                $row->width(4)->text('care','在意问题点');
                $row->width(4)->text('text','具体详细信息');

                $row->width(4)->date('one_data','初次沟通时间');
                $row->width(4)->date('tow_data','二次沟通时间');
                $row->width(4)->date('three_data','三次沟通时间');

            }, $form);
            $form->tools(function (Form\Tools $tools) {
                // 去掉`删除`按钮
                $tools->disableDelete();

            });

        });


    }
}
