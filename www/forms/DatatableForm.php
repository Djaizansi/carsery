<?php

namespace Carsery\Forms;

class DatatableForm{

	 public static function CreateDatatable($action,$id,$columnsName,$data = null) : array{
        return [
                    "configDatatable"=>[
                  
                        "action"=>$action,
                        "id"=>$id,
                        "width"=>"100%",
                        "cellspacing"=>"0",
                    ],
                    
                    "dataTable"=> [
                        
                        "nameColumnsDatatable"=>$columnsName,
                        "rows"=> $data,
                    ]       
        ];
    }
}

