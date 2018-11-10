<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Tools\ShowArtwork;
use App\Archives;
use Encore\Admin\Widgets\Collapse;
use Encore\Admin\Widgets\InfoBox;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Extensions\ExcelExpoter;

use App\Models\ChinaArea;
use App\Models\User;
use Encore\Admin\Controllers\HasResourceActions;

use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;


class ArchivesController extends Controller
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


            $content->header('学员信息');
            $content->description('');

            $content->body($this->grid());
        });
    }
    public function show($id, Content $content)
    {
        return $content->header('Post')
            ->description('详情')
            ->body(Admin::show(Archives::findOrFail($id), function (Show $show) {

                $show->panel()
                    ->tools(function ($tools) {
                        $tools->disableEdit();
                        $tools->disableList();
                        $tools->disableDelete();
                    });;
                $show->panel()
                    ->style('danger')
                    ->title('基本信息');
                $show->name('学员姓名');
                $show->price('学习价格');
                $show->age('年龄');
                $show->phone('学员电话');
                $show->weixin('学员微信');
                $show->city('所在地区');
                $show->course('学习课程');
                $show->images()->image();
                $show->start_time('开始学习日期');
                $show->expect_time('预计学习日期');
                $show->content('毕业后跟进信息');
                $show->note('备注');
            }));
    }



    public function network()
    {
        return Admin::content(function (Content $content) {


            $content->header('报名数据');
            $content->description('');
            $res =$this->grid()->getFilter()->execute();
            $id  = (request()->route('id'));
            $baidu  = 0;
            $essay = 0;
            $referral = 0;
            $sreferral  = 0;
            $man = 0;
            $woman = 0;
            $shiba = 0;
            $sanshi =0;
            $sishi = 0;
            $sishiyishang = 0;
            foreach($res as $value){


                if($value['source'] == '百度'){
                    $baidu ++;
                }elseif($value['source'] == '网络'){
                    $baidu ++ ;
                }elseif($value['source'] == '网络文章'){
                    $essay ++;
                }elseif($value['source'] == '学员介绍'){
                    $referral ++;
                }elseif($value['source'] == '熟人介绍'){
                    $sreferral ++;
                }

                if($value['gender'] == '女'){
                    $woman ++;
                }elseif($value['gender'] == '男'){
                    $man ++;
                }
                if($value['age'] <= '20'){
                    $shiba++;
                }elseif($value['age'] > '20' && $value['age']< '30'){
                    $sanshi++;
                }elseif($value['age']>'30' && $value['age']< '40'){
                    $sishi ++;
                }elseif($value['age']> '40'){
                    $sishiyishang ++;
                }
            }


            $content->body(view('admin.charts.bar',compact('baidu','essay','referral','sreferral','id','man','woman','shiba','sanshi','sishi','sishiyishang')));

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

            $content->header('学员信息');
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


            $content->header('学员信息');
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
        return Admin::grid(Archives::class, function (Grid $grid) {

                $grid->actions(function ($actions) {
                    // append一个操作

                    $actions->disableDelete();
                });
                $grid->model()->orderBy('id', 'desc');
                $grid->name('姓名')->editable();
                $grid->gender('性别');
                $grid->price('价格');
                $grid->phone('电话');
                $grid->weixin('微信号');
                $grid->course('学习课程');
                $grid->column('images')->urlWrapper();
                $grid->tools(function ($tools) {
                    $tools->batch(function ($batch) {
                        $batch->disableDelete();
                    });
                });
                $grid->source('报名来源');
                $grid->note('备注');
                $grid->start_time('开始学习时间');

                $grid->filter(function ($filter) {
                    $filter->like('name','姓名');
                    $filter->like('phone','电话');
                    $filter->like('weixin','微信号');

                });
            $grid->filter(function($filter){


            });


//
//            $grid->define_preg(url('admin/archives/1/network'), '渠道数据');
//            $grid->define_preg1(url('admin/archives/2/network'), '性别数据');
//            $grid->define_preg2(url('admin/archives/3/network'), '年龄数据');



            $grid->paginate(15);

            $excel = new ExcelExpoter();
            $excel->setAttr(['姓名','性别','身份证号码','电话','微信号','学习课程','备注','所在地区','毕业后跟进信息','开始学习时间'], ['name', 'gender','nums', 'phone', 'weixin','course','note','city','content','start_time']);
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
        return Admin::form(Archives::class, function (Form $form) {
            $form->row(function ($row) use ($form) {
                $row->width(4)->text('name', '学员姓名')->rules('required');
                $row->width(4)->text('price', '学习价格')->rules('required');
                $row->width(4)->select('gender','学员性别')->options(['男'=>'男','女'=>'女'])->rules('required');
                $row->width(4)->select('purpose','学习目的')->options(['创业'=>'创业','就业'=>'就业'])->rules('required');
                $row->width(4)->number('age','年龄');
                $row->width(4)->mobile('phone', '学员电话')->rules('required');
                $row->width(4)->text('weixin','学员微信')->rules('required');
                $row->width(4)->select('source','报名来源')->options(['百度'=>'百度','微博'=>'微博','今日头条'=>'今日头条','360搜索'=>'360搜索','豆瓣'=>'豆瓣','公众号'=>'公众号','朋友圈'=>'朋友圈','抖音'=>'抖音','搜狐'=>'搜狐','美团'=>'美团','熟人介绍'=>'熟人介绍','学员介绍'=>'学员介绍','其它'=>'其它'])->rules('required');
                $row->width(4)->text('city','所在地区')->rules('required');
                $row->width(4)->text('course','学习课程')->rules('required');
                $row->width(4)->text('content','毕业后跟进信息');
                $row->width(4)->text('note','备注');
                $row->width(4)->date('start_time','开始学习日期');
                $row->width(4)->text('expect_time','预计学习日期');
                $row->width(4)->image('images','照片');

            }, $form);
        });


    }

}
