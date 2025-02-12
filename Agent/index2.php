<?php
// status=2&orderId=12345&userId=67890
$Monstatus  =  $_GET['status']; 
$MyorderId =  $_GET['orderId']; 
$MyUserid =  $_GET['userId'];  

print("Monstatus $Monstatus -  MyorderId $MyorderId  - MyUserid $MyUserid"); 

if($Monstatus=='1'){

// decompte de quantite 1 
	
print("<br> <b> Vendu </b>  ");

 	
	
}

if($Monstatus=='2'){
	
print("<br> <b> Refuser </b>  "); 		
}



if($Monstatus=='3'){
	
print("<br> <b> Ne repond pas  </b>  "); 		
}




if($Monstatus=='4'){
	
print("<br> <b> Reporte </b>  "); 		
}



if($Monstatus=='5'){
	
print("<br> <b> Annuler le rendez vous  </b>  "); 		
}


?>

