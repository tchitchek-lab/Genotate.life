<?php
if (! empty ( $_GET ['dataset_id'] ) && $_GET ['dataset_id'] != '') {
	$dataset_id = $_GET ['dataset_id'];
	$request = "SELECT * FROM blast WHERE blast_id='$dataset_id' ORDER BY name";
	$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
	$row = mysqli_fetch_array ( $results, MYSQLI_ASSOC );
	?>
<div class="div-border-title" style='margin-top:10px;'>
	Homology reference dataset informations <a style='float: right;margin-right: 10px;' data-toggle="tooltip" data-placement="top" href="./index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['reference_details']; ?>"> <img src="/img/tutorial.svg" style='margin-bottom: 2px; height: 20px; filter: invert(90%);'></a>
</div>
<div class="div-border" style="margin-bottom: 10px;">
	<div style="width: 100%; padding: 5px;">
		<div class="form-group" style="width: 100%;">
			<label for='db_name'>name</label>
			<input readonly type="text" id="name" name="name" value="<?php echo $row['name'];?>" style="width: 100%; height: 2em; text-align: left;background-color:rgba(229,229,229, 0.2);">
		</div>
		<div style="width: 100%;">
			<label for='email'>creation date</label>
			<input readonly type="text" value="<?php echo $row['creation_date'];?>" style="width: 100%; height: 2em; text-align: left;background-color:rgba(229,229,229, 0.2);">
		</div>
		<div class="form-group" style="width: 100%;">
			<label for='species'>species</label>
			<input readonly type="text" id="species" name="species" value="<?php echo $row['species'];?>" style="width: 100%; height: 2em; text-align: left;background-color:rgba(229,229,229, 0.2);">
		</div>
		<div class="form-group" style="width: 100%;">
			<label for='release'>release</label>
			<input readonly type="text" id="release" name="release" value="<?php echo $row['version'];?>" style="width: 100%; height: 2em; text-align: left;background-color:rgba(229,229,229, 0.2);">
		</div>
		<div class="form-group" style="width: 100%;">
			<label for='description'>description</label>
			<input readonly id="description" name="description" style="width: 100%; height: 7em; text-align: left; resize: none;background-color:rgba(229,229,229, 0.2);"><?php echo $row['description'];?></input>
		</div>
	</div>
</div>
<?php
}else{
  echo "Specify a dataset id";
} 
?>