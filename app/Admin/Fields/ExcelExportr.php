<?php

namespace App\Admin\Fields;

use App\Admin\Models\TranTransOrder;
use Encore\Admin\Grid\Exporters\AbstractExporter;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class ExcelExportr extends AbstractExporter
{

    public function export()
    {
        // 这段逻辑是从表格数据中取出需要导出的字段
        $rows = collect($this->getData())->map(function ($item) {
//                    dd($item['user']);
//                    return array_only($item, ['id', 'receive_amt', 'user.regist_address', 'user.open_bank_name', 'user.bank_line_name','user.account_name',]);
            return $item;
        });
        //IOFactory::createReader("Xls")；
        $file = "kuaiqian.xls";
        $reader = IOFactory::createReader("Xls");
//        $reader->setReadDataOnly(TRUE);
        $spreadsheet = $reader->load($file);

        $worksheet = $spreadsheet->getActiveSheet();
        $i=3;
        foreach($rows as $k => $v){
            $worksheet->setCellValue('A'.$i, $v['user']['regist_address']);
            $worksheet->setCellValue('B'.$i, $v['user']['open_bank_name']);
            $worksheet->setCellValue('C'.$i, $v['user']['bank_line_name']);
            $worksheet->setCellValue('D'.$i, $v['user']['account_name']);
            $worksheet->setCellValue('E'.$i, "'".$v['user']['account_no']);
            $worksheet->setCellValue('F'.$i, $v['receive_amt']);

            $i++;
        }

        $writer = new Xls($spreadsheet);
        $name = '提现'.date('YmdHis').'.xls';
//                $writer->save($name);
        $this->browser_export('Excel',$name);//输出到浏览器
        $writer->save('php://output');
        $todayEnd= date('Y-m-d 23:59:59', time());
        $ret =  $this->grid->model()
            ->eloquent()
            ->where('receive_time','<=',$todayEnd)
            ->update(['status' => '4'])
        ;
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