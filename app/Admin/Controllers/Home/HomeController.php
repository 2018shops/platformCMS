<?php

namespace App\Admin\Controllers\Home;

use App\Admin\Models\CommUser;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Illuminate\Support\Facades\Log;

/**
 * Class HomeController
 * 首页控制台
 * @package App\Admin\Controllers\Home
 */
class HomeController extends Controller
{
    public function index()
    {
        return Admin::content(function (Content $content) {


            $content->header('美乐精选');
            $content->description('数据统计');

            //$content->body(view('admin.charts.bar'));
            $content->row(Dashboard::title());

            $content->row(function (Row $row) {
                //--------------------------------------------
                $row->column(4, function (Column $column) {
                    $column->append(view('admin.charts.bar'));
                });

//                $row->column(4, function (Column $column) {
//                    $column->append(view('admin.charts.bar2'));
//                });
//                $row->column(4, function (Column $column) {
//                    $column->append(view('admin.charts.bar3'));
//                });
//
//                //-------------------------------------------
//                $row->column(4, function (Column $column) {
//                    $column->append(Dashboard::environment());
//                });
//
//                $row->column(4, function (Column $column) {
//                    $column->append(Dashboard::extensions());
//                });
//
//                $row->column(4, function (Column $column) {
//                    $column->append(Dashboard::dependencies());
//                });


            });
        });
    }

    public function GetUserData()
    {
        $my_data = array();
        array_push($my_data, CommUser::where('user_tariff_code','=', 'P1111')->count());
        array_push($my_data, CommUser::where('user_tariff_code','=', 'P1201')->count());
        array_push($my_data, CommUser::where('user_tariff_code','=', 'P1301')->count());
        array_push($my_data, CommUser::where('user_tariff_code','=', 'P1311')->count());
        array_push($my_data, CommUser::where('user_tariff_code','=', 'P1401')->count());
        array_push($my_data, CommUser::where('user_tariff_code','=', 'P1501')->count());
        array_push($my_data, CommUser::where('user_tariff_code','=', 'P1601')->count());
        array_push($my_data, CommUser::where('user_tariff_code','=', 'P2101')->count());
        array_push($my_data, CommUser::where('user_tariff_code','=', 'P2201')->count());
        array_push($my_data, CommUser::where('user_tariff_code','=', 'P2301')->count());

        Log::info(json_encode($my_data));

        return $my_data;
    }

}
