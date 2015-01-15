<?php session_start();

			if(!isset($_SESSION['loged']) or $_SESSION['loged']!=1 )
				{
						header('location:login.php');
				
				
				}
				
		
			try
			{
				$db=new PDO('mysql:host='.$_SERVER['HTTP_HOST'].';dbname=intervention','root','');
			}
			catch(exception $e)
			{
				die('Error :'.$e->getmessage());
			}
		$R_user=$db->prepare('SELECT * FROM user WHERE id_user=:id');
		$R_user->execute(array(
							'id'=>$_SESSION['id']
							));
		$D_user=$R_user->fetch();
		
		if($D_user['statue_account']=="disable" OR $D_user==false)
		{
				session_destroy();
				header('location:login.php');
		}
		
		

	
		
		if(isset($_POST['logout']))
			{
		session_destroy();
		setcookie('login', $d['login'], $time -60*60*24*7,null, null,false,true);
		setcookie('password', $d['password'], $time -60*60*24*7,null, null,false,true);
		header('location:login.php');

			}
		if($D_user['type_account']!="user")
		header('location:administration.php');
		
		if(isset($_GET['limit'])==false OR is_numeric($_GET['limit'])==false OR $_GET['limit']<15 )
		header('location:follow.php?limit=15');

?>


	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//en"

       "http://www.w3.org/TR/html4/strict.dtd">




<html>
		<head> 
				<?php echo'<title> Suivez votre demande</title>';?>
				<link href="style.css" rel="stylesheet" type="text/css" media="screen" >
		</head>
		
		<body>
		<div id="all" >
		<div id="header">
		<?php
				echo'<div id="user_bar">';
					echo'<form action='.$_SERVER['PHP_SELF'].' method="POST">
											<input type="submit" name="logout" id="logout" title="logout" >
											</form>';
					echo'<p class="name">'.$D_user['last'].' '.$D_user['first'].' </p>';
					
					echo'<img src="'.$D_user['picture_user'].'" height=55 width=55>';
					echo'<div>';
					if($D_user['type_account']=="user")
					{
					$R1=$db->prepare('SELECT COUNT(*) AS message FROM message WHERE id_reciever=:id_reciever AND statue_message=\'none\'');
																						$R1->execute(array(
																									'id_reciever'=>$_SESSION['id']
																									)
																									);
																						
																						$number=$R1->fetch();
																						$resultat1=$number['message'];
																						
																						
					$R2=$db->prepare('SELECT COUNT(*) AS request FROM request WHERE id_user=:id_user AND statue_sender=\'none\'');
																						$R2->execute(array(
																									'id_user'=>$_SESSION['id']
																									)
																									);
																						
																						$number=$R2->fetch();
																						$resultat2=$number['request'];
					}
					
					
					echo'<p> Messages : '.$resultat1.'</p>';
					echo'<p> Demandes : '.$resultat2.'</p>';
					
					
				echo'</div></div>';
					
					
		
		?>
		
		</div> <!---------------- header -------------------->
<ul id="menu">
		
				<li><a href="home.php"   > Rédiger Demande</a></li>
				<li><a href="follow.php?limit=15" class="here"> Suivre Demande</a></li>
				<li><a href="message.php"> Messages</a></li>
				<li><a href="profile.php"> Profil</a></li>		
		</ul>
	
		
		<p class="clear"></p>
		
		<?php
				$R3=$db->prepare('SELECT * FROM request WHERE id_user=:id ORDER BY time_request DESC limit 0,'.$_GET['limit'].'');
				
				$R3->execute(array(
						'id'=>$_SESSION['id']
						));
				$D3=$R3->fetch();
				
				if($D3==false) echo'<p id="nothing"> vous n\'avez pas envoyé aucune demande </p><br>';
				else
				{
					echo '<table class="follow">
							<tr>
							<th> </th>
							<th class="name_item"> Produit </th>
							<th> Categoré </th>
							<th> date d\'envoie </th>
							<th> statue de demande </th>
							</tr>';
					$i=1;
					while($D3)
					{
						$R4=$db->prepare('SELECT * FROM item WHERE id_item=:id');
				
						$R4->execute(array(
								'id'=>$D3['id_item']
								));
						$D4=$R4->fetch();
						
						 echo'<tr ';
						 if($D3['statue_sender']=="none") echo'class="none"';
						 else if($D3['statue_sender']=="seen") echo'class="seen"';
						
			
						 echo'>';
						 echo'<td>'.$i.'</td>';
						 echo'<td><a href="show_request.php?id='.$D3['id_request'].'&type=show" ><img src="'.$D4['image_item'].'" width="40" height="40"><p> '.$D4['name_item'].' </p></a></td>';
						 echo'<td> '.$D4['type_item'].' : '.$D4['category'].' </td>';
						 echo'<td> '.$D3['time_request'].'</td>';
						 echo'<td> ';
						 if($D3['statue_request']=="none") echo'<a href="show_request.php?id='.$D3['id_request'].'&type=show" class="none">  </a> Pas vu';
						 else if($D3['statue_request']=="seen") echo'<a href="show_request.php?id='.$D3['id_request'].'&type=show" class="seen"> seen </a> vu  ';
						 else if($D3['statue_request']=="rejected") echo'<a href="show_request.php?id='.$D3['id_request'].'&type=show" class="rejected"> seen </a> Refusé ';
						 else if($D3['statue_request']=="accepted") echo'<a href="show_request.php?id='.$D3['id_request'].'&type=show" class="accepted"> seen </a> accepté ';

						 
						 
						 echo'</tr>';
						
						$D3=$R3->fetch();
						$i++;
					
					}
					echo'</table>';
					
					$R7=$db->prepare('SELECT COUNT(id_request) AS number  FROM request WHERE id_user=:id ');
					$R7->execute(array(
								'id'=>$_SESSION['id']
								));
								
					
						$number=$R7->fetch();
						$resultat=$number['number'];
						
						if($resultat>$_GET['limit'])
						{
						$new_limit=$_GET['limit']+15;
						echo '<a id="more" href="follow.php?limit='.$new_limit.'"  > here </a>';
						}
				
				}
		
		
		?>
			</div><!-----------  ALL ---------------->
			
			<div id="bottom">
		
		</div> <!---------------- header -------------------->
			
		</body>
		
</html>