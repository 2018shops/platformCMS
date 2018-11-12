<?php

namespace App\Admin\Fields\ExcelExporter;

use App\Admin\Models\TranTransOrder;
use Encore\Admin\Grid\Exporters\AbstractExporter;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class ExportTaskTransfer extends AbstractExporter
{

    public function export()
    {
        // 这段逻辑是从表格数据中取出需要导出的字段
        $rows = collect($this->getData())->map(function ($item) {
            return $item;
        });
        $file = "task_customer.xls";
        $reader = IOFactory::createReader("Xls");
        $spreadsheet = $reader->load($file);

        $worksheet = $spreadsheet->getActiveSheet();
        $i=3;
        foreach($rows as $k => $v){
            $worksheet->setCellValue('A'.$i, $v['user']['user_name']);
            $worksheet->setCellValue('B'.$i, '\''.$v['user']['login_name']);
            $worksheet->setCellValue('C'.$i, '\''.$v['user']['account_no']);
            $worksheet->setCellValue('D'.$i, $v['user']['account_name']);
            $worksheet->setCellValue('E'.$i, '\''.$v['user']['crp_id_no']);
            $worksheet->setCellValue('F'.$i, '\''.$v['user']['bank_reserved_mobile']);
            $worksheet->setCellValue('G'.$i, $v['user']['regist_address']);
            $worksheet->setCellValue('H'.$i, $v['user']['open_bank_name']);
            $worksheet->setCellValue('I'.$i, $v['user']['bank_line_name']);
            $i++;
        }
        $writer = new Xls($spreadsheet);
        $name = '任务奖励'.date('YmdHis').'.xls';
        $this->browser_export('Excel',$name);//输出到浏览器
        $writer->save('php://output');
        $dateTime= date('Y-m-d H:i:s', time());
        // 修改状态
        $this->grid->model()
            ->eloquent()
            ->where('status','=','20')
            ->update(['status' => '50','update_time' => $dateTime])
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