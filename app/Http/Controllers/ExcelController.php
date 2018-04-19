<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Excel;
use PHPExcel_IOFactory;

class ExcelController extends Controller
{
    public function index(Request $request)
    {
        return view('welcome', ['error'=>'']);
    }

    public function store(Request $request)
    {
        # 校验文件格式
        $file_obj = $request->file('file');

        if (!$file_obj || !$file_obj->isValid()) {
            $error = '上传文件不可用';
            return view('welcome', ['error'=>$error]);

        }





        $ext = $file_obj->getClientOriginalExtension();
        if (!in_array($ext, ['xls', 'xlsx'])) {
            $error = '请导入Excel格式文件！文件格式必须是xls、xlsx后缀的Excel格式的一种';
            return view('welcome', ['error'=>$error]);
        }

        // 分析excel
        $file_name = $file_obj->getPathName();

        try {
            $obj_phpexcel = PHPExcel_IOFactory::load($file_name);
        } catch (PHPExcel_Exception $exception) {
            $error = '无效的 Excel 文件';
            return view('welcome', ['error'=>$error]);
        }

        //默认选中sheet0表
        $sheet_selected = 0;
        $obj_phpexcel->setActiveSheetIndex($sheet_selected);

        // 获取表格行数
        $sheet     = $obj_phpexcel->getActiveSheet();
        $row_count = $sheet->getHighestRow();

        $new_data = [];

        for ($row = 2; $row <= $row_count; $row++) {
            // 验证解析的第一个和第二个字段，如果都为NULL或''，则认为到了解析边界

            $create_date = $sheet->getCell('A' . $row)->getValue();
            $order_id = $sheet->getCell('D' . $row)->getValue();
            $customer_name = $sheet->getCell('B' . $row)->getValue();
            $phone = $sheet->getCell('K' . $row)->getValue();
            $address = $sheet->getCell('H' . $row)->getValue();
            $zip_code = $sheet->getCell('J' . $row)->getValue();
            $product_name = $sheet->getCell('F' . $row)->getValue();
            $product_name = trim($product_name);
            # 如果空数据 停止解析
            if (!$create_date) {
                break;
            }

            // if ($row == 865) {
                # 拆分不同的产品
            $product_name_array = explode("\n", $product_name);
            foreach ($product_name_array as $name) {
                # 拆分数量
                $data_array = explode("包邮 * ",$name);
                $product_count = $data_array[1];
                $new_product_name = implode('包邮 * ', [$data_array[0], '1']);
                for ($x=1; $x<=$product_count; $x++) {
                    ;
                    $data_dict = [
                        'order_id' => $order_id,
                        'customer_name' => $customer_name,
                        'phone' => $phone,
                        'address' => $address,
                        'zip_code' => $zip_code,
                        'new_product_name' => $name,

                    ];

                    $new_data[] = $data_dict;
                }
            }

            // }

        }

        # 创建新的excel文件
        $file_name = $file_obj->getClientOriginalName();

        $excelName = '新' . date('md') . $file_name;
        $excelName = rawurlencode($excelName);

        Excel::create($excelName, function ($excel) use ($new_data) {
            $excel->sheet('sheet1', function ($sheet) use ($new_data) {
                $sum = count($new_data);
                $sheet->setAutoSize(true);
                $sheet->setColumnFormat(array('E' => '@'));
                $sheet->row(1, ['订单号', '客户', '手机', '地址', '邮编', '产品',]);

                $index = 0;
                for ($i = 2; $i < $sum + 2; $i++) {
                    $obj = $new_data[$index];

                    $sheet->row($i, array(
                        '订单号' => $obj['order_id'],
                        '客户' => $obj['customer_name'],
                        '手机' => $obj['phone'],
                        '地址' => $obj['address'],
                        '邮编' => $obj['zip_code'],
                        '产品' => $obj['new_product_name'],
                    ), $explicit = true);
                    $index = $index + 1;
                }
            });

        })->export('xlsx');



        return view('welcome', ['error'=>'']);
    }
}
