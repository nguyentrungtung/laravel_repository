<?php


if (!function_exists('url_slug')) {
    /**
     * @param $str
     * @return array|string|string[]|null
     * generate string slug frequency
     */
    function url_slug($str)
    {
        $str = iconv('UTF-8', 'ASCII//TRANSLIT', $str); // Chuyển đổi sang dạng không dấu
        $str = preg_replace('/[^a-zA-Z0-9\/_|+ -]/', '', $str); // Xóa các ký tự không phù hợp
        $str = strtolower(trim($str, '-')); // Chuyển đổi thành chữ thường và loại bỏ ký tự '-' thừa
        $str = preg_replace('/[\/_|+ -]+/', '-', $str); // Thay thế các ký tự phân cách bằng '-'
        return $str;
    }
}

if (!function_exists('isValidEmail')) {
    /**
     * @param $email
     * @return false|int
     * This email regex is not fully RFC5322-compliant, but it will validate most common email address formats correctly.
     */
    function isValidEmail($email) {
        return preg_match('/^([a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4})*$/', $email);
    }
}

if (!function_exists('isValidIpAddress')) {
    /**
     * @param $ipAddress
     * @return false|int
     * Test IP Addresses with this regular expression.
     */
    function isValidIpAddress($ipAddress) {
        return preg_match('/^((?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?))*$/', $ipAddress);
    }
}

if (!function_exists('isValidDigits')) {
    /**
     * @param $number
     * @return false|int
     * This regex will test for digits (whole numbers).
     */
    function isValidDigits($number) {
        return preg_match( '/^[0-9]*$/', $number);
    }
}

if (!function_exists('isValidDateYMD')) {
    /**
     * @param $date
     * @return false|int
     * Date (YYYY/MM/DD)
     * Validate the calendar date in YYYY/MM/DD format with this regex. Optional separators are spaces, hyphens, forward slashes, and periods. The year is limited between 1900 and 2099.
     */
    function isValidDateYMD($date){
        return preg_match('#^((19|20)?[0-9]{2}[- /.](0?[1-9]|1[012])[- /.](0?[1-9]|[12][0-9]|3[01]))*$#', $date);
    }
}

if (!function_exists('isValidDateMDY')) {
    /**
     * @param $date
     * @return false|int
     * Date (MM/DD/YYYY)
     * Validate the calendar date in MM/DD/YYYY format with this regex. Optional separators are spaces, hyphens, forward slashes, and periods. The year is limited between 1900 and 2099..
     */
    function isValidDateMDY($date){
        return preg_match('/^((0?[1-9]|1[012])[- /.](0?[1-9]|[12][0-9]|3[01])[- /.](19|20)?[0-9]{2})*$/', $date);
    }
}

if (!function_exists('isValidDateDMY')) {
    /**
     * @param $date
     * @return false|int
     * Date (DD/MM/YYYY)
     * Validate the calendar date in DD/MM/YYYY format with this regex. Optional separators are spaces, hyphens, forward slashes, and periods.
     */
    function isValidDateDMY($date){
        return preg_match('/^(0[1-9]|1\d|2\d|3[01])\/(0[1-9]|1[0-2])\/((19|20)\d{2})$/', $date);
    }
}

if (!function_exists('isValidAlphaChar')) {
    /**
     * @param $string
     * @return false|int
     * Alphabetic Characters
     * Alphabetic characters only
     */
    function isValidAlphaChar($string){
        return preg_match('/^[a-zA-Z]*$/', $string);
    }
}

if (!function_exists('isValidAlphaCharForNumber')) {
    /**
     * @param $string
     * @return false|int
     * Alpha-numeric characters with spaces only
     */
    function isValidAlphaChar($string){
        return preg_match('/^[a-zA-Z0-9 ]*$/', $string);
    }
}

if (!function_exists('isValidCreditCard')) {
    /**
     * @param $creditCard
     * @return false|int
     * This regular expression will validate all major credit cards: American Express (Amex), Discover, Mastercard, and Visa.
     */
    function isValidCreditCard($creditCard){
        return preg_match('/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6011[0-9]{12}|622((12[6-9]|1[3-9][0-9])|([2-8][0-9][0-9])|(9(([0-1][0-9])|(2[0-5]))))[0-9]{10}|64[4-9][0-9]{13}|65[0-9]{14}|3(?:0[0-5]|[68][0-9])[0-9]{11}|3[47][0-9]{13})*$/', $creditCard);
    }
}

if (!function_exists('isValidStrongPassword')) {
    /**
     * @param $password
     * @return false|int
     * Test for a strong password with this regex. The password must contain one lowercase letter, one uppercase letter, one number, and be at least 6 characters long.
     */
    function isValidStrongPassword($password){
        return preg_match('/^(?=^.{6,}$)((?=.*[A-Za-z0-9])(?=.*[A-Z])(?=.*[a-z]))^.*$/', $password);
    }
}

if (!function_exists('isValidURL')) {
    /**
     * @param $url
     * @return false|int
     * This URL regex will validate most common URL formats correctly.
     */
    function isValidURL($url){
        return preg_match('/^(((http|https|ftp):\/\/)?([[a-zA-Z0-9]\-\.])+(\.)([[a-zA-Z0-9]]){2,4}([[a-zA-Z0-9]\/+=%&_\.~?\-]*))*$/', $url);
    }
}

if (!function_exists('isValidPhoneNumberVN')) {
    /**
     * @param $phoneNumber
     * @return false|int
     * This phone number regex will validate most common phone number formats correctly.
     */
    function isValidPhoneNumberVN($phoneNumber){
        return preg_match('/(84|0[3|5|7|8|9])+([0-9]{8})\b/', $phoneNumber);
    }
}


if (!function_exists('renderMenu')) {
    function renderMenu($menuItems)
    {
        $output = '';
        foreach ($menuItems as $item) {
            if (isset($item['permissions']) && !checkPermissions($item['permissions'])) {
                continue;
            }

            $output .= '<li';

            if (isset($item['children'])) {
                $output .= ' class="treeview"';
            }

            $output .= '>';

            if (isset($item['route'])) {
                $output .= '<a href="' . route($item['route']) . '">';
            } else {
                $output .= '<a href="#">';
            }

            if (isset($item['icon'])) {
                $output .= '<i class="' . $item['icon'] . '"></i> ';
            }

            $output .= '<span>' . __($item['text']) . '</span>';

            if (isset($item['children'])) {
                $output .= '<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>';
                $output .= '<ul class="treeview-menu">';
                $output .= renderMenu($item['children']);
                $output .= '</ul>';
            }

            $output .= '</a>';
            $output .= '</li>';
        }

        return $output;
    }
}

if (!function_exists('checkPermissions')) {
    function checkPermissions($permissions)
    {
        //auth()->user()->can($permission)
        return true;
    }
}
