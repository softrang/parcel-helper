<?php


namespace Softrang\ParcelHelper\Facades;


use Illuminate\Support\Facades\Facade;


class ParcelHelper extends Facade
{
protected static function getFacadeAccessor()
{
return \Softrang\ParcelHelper\ParcelHelper::class;
}
}