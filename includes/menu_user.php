<?php
//if(isset($_GET['encoded_id'])){
//    $encoded_id = "&encoded_id=" . $_GET['encoded_id'];
//}else{
//    $encoded_id = "";
//}
//?>

<div id="header">
    <div id="header"
         style="float: none;display:block;max-width:60em;margin: 0px auto;">
        <a class="header_genotate" href='/'>Genotate</a>
        <li class="dropdown">
            <a href="#" class="header_dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
          Annotate<span style='margin-left:7px;' class="caret"></span></a>
            <ul class="dropdown-menu" style='margin-top: 10px;'>
                <a class="header_dropdown_link" href="/index.php?page=annotate_single">Single transcript</a>
                <a class="header_dropdown_link" href="/index.php?page=annotate_multiple">Multiple transcripts</a>
            </ul>
        </li>
       <a class="header_link" href="/index.php?page=view_annotations">View annotation results</a>
		<a class="header_link" href="/index.php?page=explore_annotations">Explore annotation results</a>
        <li class="dropdown" style="float:right;">
          <a href="#" class="header_dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            Help<span style='margin-left:7px;' class="caret"></span></a>
            <ul class="dropdown-menu" >
                <a class="header_dropdown_link" href="/index.php?page=tutorial">Tutorial<span class="sr-only"/></a>
                <a class="header_dropdown_link" href="/index.php?page=about">About<span class="sr-only"/></a>
            </ul>
            <a style="vertical-align: middle;float:right;font-size:16px;background-color:black;height:40px;width:40px;padding:10px;" href="/admin/index.php"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></a>
        </li>

    </div>
</div>
