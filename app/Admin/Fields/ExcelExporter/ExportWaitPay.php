<?php

namespace App\Admin\Fields\ExcelExporter;

use App\Admin\Models\TranTransOrder;
use Encore\Admin\Grid\Exporters\AbstractExporter;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class ExportWaitPay extends AbstractExporter
{

    public function export()
    {
        // 这段逻辑是从表格数据中取出需要导出的字段
        $rows = collect($this->getData())->map(function ($item) {
            return $item;
        });
        $file = "kuaiqian.xls";
        $reader = IOFactory::createReader("Xls");
        $spreadsheet = $reader->load($file);

        $worksheet = $spreadsheet->getActiveSheet();
        $i=3;
        foreach($rows as $k => $v){
            TranTransOrder::where('id',$v['id'])->update(['status' => '4']);
            $worksheet->setCellValue('A'.$i, $v['user']['regist_address']);
            $worksheet->setCellValue('B'.$i, $v['user']['open_bank_name']);
            $worksheet->setCellValue('C'.$i, $v['user']['bank_line_name']);
            $worksheet->setCellValue('D'.$i, $v['user']['account_name']);
            $worksheet->setCellValue('E'.$i, "'".$v['user']['account_no']);
            $worksheet->setCellValue('F'.$i, $v['receive_amt']);

            $i++;
        }

        $writer = new Xls($spreadsheet);
        $name = '提现T+1' .'('. date('Y-m-d His',time()) .')'.'.xls';
        $this->browser_export('Excel',$name);//输出到浏览器
        $writer->save('php://output');
        $todayEnd= date('Y-m-d 23:59:59', time());
        $dateTime= date('Y-m-d H:i:s', time());

        // 修改状态
        $this->grid->model()
            ->eloquent()
            ->where('receive_time','<=',$todayEnd)
            ->update(['status' => '4','update_time' => $dateTime])
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