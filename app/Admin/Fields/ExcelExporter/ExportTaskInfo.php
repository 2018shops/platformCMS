<?php

namespace App\Admin\Fields\ExcelExporter;

use App\Admin\Models\TranTransOrder;
use Encore\Admin\Grid\Exporters\AbstractExporter;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class ExportTaskInfo extends AbstractExporter
{

    public function export()
    {
        // 这段逻辑是从表格数据中取出需要导出的字段
        $rows = collect($this->getData())->map(function ($item) {
            return $item;
        });
        $file = "task_info.xls";
        $reader = IOFactory::createReader("Xls");
        $spreadsheet = $reader->load($file);

        $worksheet = $spreadsheet->getActiveSheet();
        $i=3;
        foreach($rows as $k => $v){
            $worksheet->setCellValue('A'.$i, '\''.$v['id']);
            $worksheet->setCellValue('B'.$i, $v['title']);
            $worksheet->setCellValue('C'.$i, $v['desc']);
            $worksheet->setCellValue('D'.$i, $v['bean']);
            $worksheet->setCellValue('E'.$i, $v['task_code']);
            $worksheet->setCellValue('F'.$i, $v['target']);
            $worksheet->setCellValue('G'.$i, $v['reward_type']);
            $worksheet->setCellValue('H'.$i, $v['reward']);
            $worksheet->setCellValue('I'.$i, $v['type']);
            $worksheet->setCellValue('J'.$i, $v['start_time']);
            $worksheet->setCellValue('K'.$i, $v['end_time']);
            $i++;
        }
        $writer = new Xls($spreadsheet);
        $name = '任务信息'.date('YmdHis').'.xls';
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