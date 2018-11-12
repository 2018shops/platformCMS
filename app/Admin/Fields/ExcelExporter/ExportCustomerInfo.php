<?php

namespace App\Admin\Fields\ExcelExporter;

use App\Admin\Models\TranTransOrder;
use Encore\Admin\Grid\Exporters\AbstractExporter;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class ExportCustomerInfo extends AbstractExporter
{

    public function export()
    {
        // 这段逻辑是从表格数据中取出需要导出的字段
        $rows = collect($this->getData())->map(function ($item) {
            return $item;
        });
        $file = "customer_info.xls";
        $reader = IOFactory::createReader("Xls");
        $spreadsheet = $reader->load($file);

        $worksheet = $spreadsheet->getActiveSheet();
        $i=3;
        foreach($rows as $k => $v){
            $worksheet->setCellValue('A'.$i, '\''.$v['id']);
            $worksheet->setCellValue('B'.$i, $v['from_way']);
            $worksheet->setCellValue('C'.$i, $v['name']);
            $worksheet->setCellValue('D'.$i, $v['sex']);
            $worksheet->setCellValue('E'.$i, $v['age']);
            $worksheet->setCellValue('F'.$i, $v['tel']);
            $worksheet->setCellValue('G'.$i, $v['address']);
            $worksheet->setCellValue('H'.$i, $v['intention_brand']);
            $worksheet->setCellValue('I'.$i, $v['intention_car']);
            $worksheet->setCellValue('J'.$i, $v['consult_time']);
            $worksheet->setCellValue('K'.$i, $v['plan_time']);
            $worksheet->setCellValue('L'.$i, $v['buy_budget']);
            $worksheet->setCellValue('M'.$i, $v['user']['user_name'].'|'.$v['user']['login_name'].'|'.$v['partner_id']);
            $worksheet->setCellValue('N'.$i, $v['user']['user_name'].'|'.$v['user']['login_name'].'|'.$v['agent_id']);
            $worksheet->setCellValue('O'.$i, $v['audit']);
            $worksheet->setCellValue('P'.$i, $v['status']);
            $worksheet->setCellValue('Q'.$i, $v['data']);
            $worksheet->setCellValue('R'.$i, $v['day']);
            $worksheet->setCellValue('S'.$i, $v['weekday']);
            $worksheet->setCellValue('T'.$i, $v['way']);
            $worksheet->setCellValue('U'.$i, $v['create_time']);
            $worksheet->setCellValue('V'.$i, $v['follow_type']);
            $worksheet->setCellValue('W'.$i, $v['consult_type']);
            $worksheet->setCellValue('X'.$i, $v['into_time']);
            $worksheet->setCellValue('Y'.$i, $v['in_time']);
            $worksheet->setCellValue('Z'.$i, $v['car_user']);
            $worksheet->setCellValue('AA'.$i, $v['hobby']);
            $worksheet->setCellValue('AB'.$i, $v['received_after']);
            $worksheet->setCellValue('AC'.$i, $v['receiver']);
            $worksheet->setCellValue('AD'.$i, $v['track_time']);
            $worksheet->setCellValue('AE'.$i, $v['loss_time']);
            $worksheet->setCellValue('AF'.$i, $v['loss_type']);
            $worksheet->setCellValue('AG'.$i, $v['reason']);
            $worksheet->setCellValue('AH'.$i, $v['conclusion']);
            $worksheet->setCellValue('AI'.$i, $v['remark']);
            $i++;
        }
        $writer = new Xls($spreadsheet);
        $name = '客户信息'.date('YmdHis').'.xls';
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