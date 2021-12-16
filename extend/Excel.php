<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Class Excel 正常导出
 */
class Excel
{
    private static $cellKey = [
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
        'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM',
        'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ'
    ];
    private static $width_row = [];//区间
    private static $spreadsheet;
    private static $worksheet;
    private static $title;
    private static $Prow = 1;
    private static $list_key = [];
    private static $style = [
        'alignment' => [
            'horizontal' => 'center',
            'vertical' => 'center',
        ],
        'borders' => [
            'outline' => [
                'borderStyle' => 'thin',
                'color' => ['argb' => '000000']
            ],
        ],
        'font' => [
            'name' => '黑体',
            'bold' => true,
            'size' => 22
        ]
    ];

    /**
     * 初始化
     */
    private static function initialize()
    {
        self:: $spreadsheet = new Spreadsheet();
        self:: $worksheet = self:: $spreadsheet->getActiveSheet();
        self:: $worksheet->getDefaultColumnDimension()->setWidth(20);//设置默认宽度
        self::  $worksheet->getDefaultRowDimension()->setRowHeight(30);//设置默认行高

    }

    /**
     * 头部
     * @param string $title 标题
     * @param array $header 栏目 ['id'=>'编号'，’name‘=>'名字'，’time‘=>'时间']
     * @param string $subtitle 副标题
     * @return Excel|string
     */
    public static function header($title = '标题', $header = [], $subtitle = '')
    {
        self::initialize();
        $length = count($header);
        self:: $title = date('Y-m-d') . ' ' . $title;
        if ($length > 0) {
            self::$width_row = array_slice(self::$cellKey, 0, $length);
        } else {
            return '表格数量字段异常';
        }

        self::$worksheet->setTitle(self::$title); //设置导出文件名
        self::$worksheet->getRowDimension(self::$Prow)->setRowHeight(50);//设置第一行行高
        $titlemerge = reset(self::$width_row) . self::$Prow . ':' . end(self::$width_row) . self::$Prow;
        self::$worksheet->mergeCells($titlemerge);
        self::$worksheet->getStyle($titlemerge)->applyFromArray(self::$style);
        self::$worksheet->setCellValueByColumnAndRow(1, self::$Prow, self::$title);
        self::$style['font']['size'] = 12;

        if ($subtitle) {   //设置副标题
            self::$Prow++;
            $Subtitle = reset(self::$width_row) . self::$Prow . ':' . end(self::$width_row) . self::$Prow;
            self::$worksheet->mergeCells($Subtitle);
            self::$worksheet->getStyle($Subtitle)->applyFromArray(self::$style);
            self::$worksheet->setCellValueByColumnAndRow(1, self::$Prow, $subtitle);
        }
        //设置列表标题
        self::bander($header);

        return new self;


    }

    /**
     * 设置导航
     */
    private static function bander($data)
    {
        self::$Prow++;
        $index = 0;
        foreach ($data as $k => $item) {
            self::$list_key[] = $k;
            $index++;
            self:: $worksheet->setCellValueByColumnAndRow($index, self::$Prow, $item);
        }
    }


    /**
     * 设置内容二维数组
     */
    public function content($list = [])
    {
        foreach ($list as $item) {
            self::$Prow++;
            foreach (self::$list_key as $k => $v) {
                self:: $worksheet->setCellValueByColumnAndRow($k + 1, self::$Prow, $item[$v] ?? '');
            }
        }
        return $this;
    }

    /**
     * 导出
     */
    public function save()
    {
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . self:: $title . '.xlsx');
        header('Cache-Control: max-age=0');

        $write = IOFactory::createWriter(self::$spreadsheet, 'Xlsx');
        $write->save('php://output');
        exit();
    }

}