<?php
class Utilities{
 
    public function getPaging($page, $total_rows, $records_per_page, $page_url){
 
        // array de paginacion
        $paging_arr=array();
 
        // boton de la primera pag
        $paging_arr["first"] = $page>1 ? "{$page_url}page=1" : "";
 
        // cuenta todos los customers en la db y calcula el total de pag
        $total_pages = ceil($total_rows / $records_per_page);
 
        // rango de enlaces a mostrar
        $range = 2;
 
        // mostrar los enlaces de 'rango de pags' alrededor de 'pag actual'
        $initial_num = $page - $range;
        $condition_limit_num = ($page + $range)  + 1;
 
        $paging_arr['pages']=array();
        $page_count=0;
         
        for($x=$initial_num; $x<$condition_limit_num; $x++){
            // aseguramos que '$x es mayor que 0' y ' menor o igual que $total_pages'
            if(($x > 0) && ($x <= $total_pages)){
                $paging_arr['pages'][$page_count]["page"]=$x;
                $paging_arr['pages'][$page_count]["url"]="{$page_url}page={$x}";
                $paging_arr['pages'][$page_count]["current_page"] = $x==$page ? "yes" : "no";
 
                $page_count++;
            }
        }
 
        // boton para la ultima pag
        $paging_arr["last"] = $page<$total_pages ? "{$page_url}page={$total_pages}" : "";
 
        // en formato json
        return $paging_arr;
    }
 
}
?>