<?php
namespace App\Helper;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class Helper
{
    // public static function custom_paginate($items,$perPage)
	//     {
	//         $pageStart = \Request::get('page', 1);
	//         $offSet = ($pageStart * $perPage) - $perPage; 
	//         $itemsForCurrentPage = array_slice($items, $offSet, $perPage, false);
	//         return new LengthAwarePaginator($itemsForCurrentPage, count($items), $perPage,Paginator::resolveCurrentPage(), array('path' => Paginator::resolveCurrentPath()));
	//     }
}


?>