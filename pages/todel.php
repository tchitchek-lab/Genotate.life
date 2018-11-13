test

<?php if($user->isLoggedIn()){echo "true";}else{echo "false";} //anyone is logged in?>

<?php 

echo $user->data()->id;
echo echousername($user->data()->id);


echo '<pre>'; print_r($user->data()); echo '</pre>';

?>