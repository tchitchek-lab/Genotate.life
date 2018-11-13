<?php

function page_bar($activepage, $numberpage)
{
	echo "<div style='line-height:30px;height:40px;border:1px solid lightgrey;padding:5px;border-radius:5px;'>";
	echo "<div class='btn-group' style='float:right;'> ";
 echo "<label class='btn btn-default' onclick=\"reloadphp_div(" . 1 . ");\">first page</label>";
      
   echo "<label class='btn btn-default' onclick=\"reloadphp_div(" . max($activepage-1,1) . ");\">previous page &laquo;</label>";
    for ($i =  max($activepage-2,1); $i <= min($activepage+2,$numberpage); ++$i) {
        if ($i !== 0) {
            if ($activepage == $i) {
            	echo "<label class='btn btn-default active'>$i</label>";
            } else {
                echo "<label class='btn btn-default' onclick=\"reloadphp_div(" . $i . ");\">$i</label>";
            }
        }
    }
    echo "<label class='btn btn-default' onclick=\"reloadphp_div(" . min($activepage+1,$numberpage) . ");\">&raquo; next page</label>";
    echo "<label class='btn btn-default' onclick=\"reloadphp_div(" . $numberpage . ");\">last page</label>";
    echo "</div>";
    echo "</div>";
}

?>