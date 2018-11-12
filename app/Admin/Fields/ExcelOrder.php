<?php

namespace App\Admin\Fields;

use App\Admin\Models\GoodsOrder;
use App\Admin\Models\TranTransOrder;
use Encore\Admin\Grid\Exporters\AbstractExporter;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class ExcelOrder extends AbstractExporter
{

    public function export()
    {

        // 这段逻辑是从表格数据中取出需要导出的字段
        $rows = collect($this->getData())->map(function ($item) {

            return $item;
        });
//        dd($rows);
        //IOFactory::createReader("Xls")；
        $file = "order.xls";
        $reader = IOFactory::createReader("Xls");
//        $reader->setReadDataOnly(TRUE);
        $spreadsheet = $reader->load($file);

        $worksheet = $spreadsheet->getActiveSheet();
        $i=2;
        foreach($rows as $k => $v){
            GoodsOrder::where('id',$v['id'])->update(['export_status' => '10']);
            $time = date('Y-m-d',strtotime($v['update_time']));
            $worksheet->setCellValue('A'.$i, $v['goods']['name']);
            $worksheet->setCellValue('B'.$i, $v['unit_price']);
            $worksheet->setCellValue('C'.$i, $v['total_price']);
            $worksheet->setCellValue('D'.$i, $v['number']);
            $worksheet->setCellValue('E'.$i, $v['address']);
            $worksheet->setCellValue('F'.$i, $v['consignee_name']);
            $worksheet->setCellValue('G'.$i, $v['consignee_mobile']);
//            $worksheet->setCellValue('H'.$i, $v['user']['user_name']);
            $worksheet->setCellValue('H'.$i, $v['goods']['supplier']);
            $worksheet->setCellValue('I'.$i, $time);
            $worksheet->setCellValue('J'.$i, $v['goods']['cost']);

            $i++;
        }

        $writer = new Xls($spreadsheet);
        $name = '发货单' .'('. date('Y-m-d His',time()) .')'.'.xls';
//                $writer->save($name);
        $this->browser_export('Excel',$name);//输出到浏览器
        $writer->save('php://output');

    }
    //输出excel 文件到浏览器
    public function browser_export($type,$filename)
    {
        if ($type == "Excel5") {
            header('Content-Type: application/vnd.ms-excel'); //告诉浏览器将要输出excel03文件
        } else {
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');//告诉浏览器数据excel07文件
        }
        header('Content-Disposition: attachment;filename="' . $filename . '"');  //告诉浏览器将输出文件的名称
        header('Cache-Control: max-age=0');  //禁止缓存
    }
}