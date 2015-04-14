<?php
class ImageParser
{
    const ;
    const ;

    public function __construct ()
    {

    }


    public function parse($fileToParse, $outputDataType = null)
    {

        $file = \exif_read_data($fileToParse);

        // array (size=9)
        //  'FileName' => string 'bg.jpg' (length=6)
        //  'FileDateTime' => int 1427541765
        //  'FileSize' => int 171446
        //  'FileType' => int 2
        //  'MimeType' => string 'image/jpeg' (length=10)
        //  'SectionsFound' => string 'IFD0, APP12' (length=11)
        //  'COMPUTED' =>
        //    array (size=5)
        //      'html' => string 'width="1920" height="1160"' (length=26)
        //      'Height' => int 1160
        //      'Width' => int 1920
        //      'IsColor' => int 1
        //      'ByteOrderMotorola' => int 0
        //  'Company' => string 'Ducky' (length=5)
        //  'Info' => string '' (length=1)


    }
}