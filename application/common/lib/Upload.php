<?php

namespace app\common\lib;

/**
 * 上传基类
 * Class Upload
 * @package app\common\lib
 */
class Upload
{
    //允许上传文件的类型
    protected static $allowFileType = ['jpg', 'gif', 'bmp', 'jpeg', 'png'];

    public static function uploadByFile($fileName, $bucket = ''){
        if (!$_FILES[$fileName]){
            render_json('文件不存在', 0);
        }
        $tmpFileName = $_FILES[$fileName]['name'];
        $filePath = $_FILES[$fileName]['tmp_name'];
        $fileSize = $_FILES[$fileName]['size'];

        if (!$filePath || !file_exists($filePath)){
            render_json('文件路径不合法', 0);
        }
        $now = date('Y-m-d H:i:s');
        $tmpFileExtend = explode('.', $tmpFileName);
        $fileType = strtolower(end($tmpFileExtend));// 文件后缀名

        // 验证文件类型
        if (!in_array($fileType, self::$allowFileType)){
            render_json('上传文件类型不支持', 0);
        }
        // 验证文件大小
        if($fileSize > config('api.upload_max_size')){
            render_json('上传文件大小超过限制', 0);
        }
        $uploadConfig = config('api.upload');
        if (!isset($uploadConfig[$bucket])){
            render_json('指定的bucket不存在或者没有配置', 0);
        }

        $hashKey = md5(file_get_contents($filePath));
        $uploadDirPath = ROOT_PATH.'/public';
        $folderName = $uploadConfig[$bucket].'/'.date('Ymd', strtotime($now));
        $uploadDir = $uploadDirPath.$folderName;

        if (!file_exists($uploadDir)){
            mkdir($uploadDir, 0777, true);
            chmod($uploadDir, 0777);
        }

        $uploadFileName = "{$folderName}/{$hashKey}.".$fileType;

        if (is_uploaded_file($filePath)){
            if (!move_uploaded_file($filePath, $uploadDirPath.$uploadFileName)){
                render_json('上传失败，系统繁忙请稍后再试', 0);
            }
        } else{
            file_put_contents($uploadDirPath.$uploadFileName, file_get_contents($filePath));
        }

        $data = array(
            'file_name' => $tmpFileName,
            'save_name' => $uploadFileName,
            'ext' => $fileType,
            'size' => $fileSize,
            'bucket' => $bucket,
            'on_time' => time(),
        );

        try {
            model('File')->insert($data);
        } catch (\Exception $e){
            render_json('提交失败', 0);
        }

        return $uploadFileName;
    }
}