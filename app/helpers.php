<?php

// Cek dulu apakah fungsi sudah ada
if (!function_exists('activeMenu')) {
    function activeMenu($cond)
    {
        return $cond
            ? 'text-indigo-600 font-semibold border-b-2 border-indigo-600'
            : 'text-gray-700 hover:text-indigo-500 transition';
    }
}
