<?php

namespace App;

use App\Models\Major;
use App\Models\User;

class AppConstants {

    const PASSWORD_MINIMUM_LENGTH = 6;
    const STRINGS_MINIMUM_LENGTH = 3;
    const STRINGS_MAXIMUM_LENGTH = 255;
    const INDEXED_STRINGS_MAXIMUM_LENGTH = 170;
    const TEXT_MAXIMUM_LENGTH = 1000;
    const NUMERIC_MINIMUM_LENGTH = 1;
    const INTEGER_MAXIMUM_VALUE = 999999999;
    const SMALL_INTEGER_MAXIMUM_VALUE = 255;
    const LIST_ITEMS_COUNT_PER_PAGE = 255;
    const REGEX_NO_SPACE = '/^\S*$/';
    const FLAG_YES = 1;
    const FLAG_NO = 0;

    /**
     *
     * @return array
     */
    public static function getHowDidYouFindUsOptions(): array {
        return [
            'twitter' => __('company.twitter'),
            'linkedin' => __('company.linkedin'),
            'facebook' => __('company.facebook'),
            'email' => __('company.email'),
            'friends' => __('company.friends'),
            'other' => __('company.other'),
        ];
    }

    public static function getYesNoOptions(): array {
        return [
            'no' => __('no'),
            'yes' => __('yes'),
        ];
    }

    public static function getIconForFile($file) {
        $info = pathinfo($file);
        $extension = $info["extension"];
        // $info = new SplFileInfo($file);
        // $extension = $info->getExtension();
        switch (strtolower($extension)) {
            case 'png':
            case 'jpeg':
            case 'jpg':
                return url('images/icon-extension/png.png');
                break;
            case 'pdf':
            case 'Pdf':
                return url('images/icon-extension/pdf.png');
                break;
            case 'xls':
            case 'xlsx':
                return url('images/icon-extension/excel.png');
                break;
            case 'doc':
            case 'docx':
                return url('images/icon-extension/word.png');
                break;
            case 'ppt':
                return url('images/icon-extension/ppt.png');
                break;
            default:
                # code...
                break;
        }
    }


    public static function academicYear() {
        return [

            'first_year' =>  __('user.first_year'),
            'second_year' =>  __('user.second_year'),
            'third_year' =>    __('user.third_year'),  
            'four_year' =>    __('user.four_year'),                    
            'last_year' => __('user.last_year'),
            
        ];
    }

    /**
     * format SizeUnits size
     * https://stackoverflow.com/questions/5501427/php-filesize-mb-kb-conversion
     */
    static function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

}
