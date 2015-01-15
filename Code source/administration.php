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
		if($D_user['type_account']=="user")
		header('location:home.php');
		
		if(isset($_GET['limit'])==false OR is_numeric($_GET['limit'])==false OR $_GET['limit']<15 OR (isset($_GET['go']) && $_GET['go']!="search"))
		header('location:administration.php?limit=15');
		
		function mois($m)
{
		$month=0;
		if($m==1)$month="Janvier";
		else if($m==2) $month="Février";
		else if($m==3) $month="Mars";
		else if($m==4) $month="Avril";
		else if($m==5) $month="Mai";
		else if($m==6) $month="Juin";
		else if($m==7) $month="Juillet";
		else if($m==8) $month="août";
		else if($m==9) $month="Septembre";
		else if($m==10) $month="Octobre";
		else if($m==11) $month="Novembre";
		else if($m==12) $month="Décembre";
		return $month;
		}

?>


	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//en"

       "http://www.w3.org/TR/html4/strict.dtd">




<html>
		<head> 
				<?php echo'<title> la gestion des demandes </title>';?>
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
					
					$R1=$db->query('SELECT COUNT(*) AS message FROM message ');
																						
																						
																						$number=$R1->fetch();
																						$resultat1=$number['message'];
																						
				
					$R3=$db->prepare('SELECT COUNT(*) AS m FROM message WHERE id_sender=:id_user ');
																						$R3->execute(array(
																									'id_user'=>$_SESSION['id']
																									)
																									);
																						
																						$number=$R3->fetch();
																						$resultat3=$number['m'];
																						
					$R3=$db->prepare('SELECT COUNT(*) AS a FROM read_message WHERE id_user=:id_user ');
																						$R3->execute(array(
																									'id_user'=>$_SESSION['id']
																									)
																									);
																						
																						$number=$R3->fetch();
																						$resultat4=$number['a'];
																						
					$resultat1=$resultat1-$resultat3-$resultat4;
																						
					$R2=$db->query('SELECT COUNT(*) AS request FROM request WHERE  statue_request=\'none\'');
																					
																						
																						$number=$R2->fetch();
																						$resultat2=$number['request'];
					
					
					
					echo'<p> Messages : '.$resultat1.'</p>';
					echo'<p> Demandes : '.$resultat2.'</p>';
					
					
				echo'</div></div>';
					
					
		
		?>
		</div> <!---------------- header -------------------->
<ul id="menu">
		
				<li><a href="administration.php"   class="here">Demandes</a></li>
				<li><a href="item.php" >Articles</a></li>
				<li><a href="message_controle.php"> Messages</a></li>
				<li><a href="profile_controle.php">Utilisateurs</a></li>		
		</ul>
	
		
		<p class="clear"></p>
		
		<?php
		
				echo'<a id="search" href="search.php"> here </a>';
				
				
				$R3=$db->query('SELECT * FROM request ORDER BY time_request DESC limit 0,'.$_GET['limit'].'');
				
				
				$D3=$R3->fetch();
				
				if($D3==false) echo'<p id="nothing">Il n\'y a pas de demande pour le moment</p> <br>'; 
				else
				{
					echo '<table class="search_body"><tr class="th">
							<th> </th>
							<th class="name_item"> Produit </th>
							<th> Categoré </th>
							<th> Utilisateur </th>
							<th> date d\'envoie </th>
							<th> statue </th>
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
						 if($D3['statue_request']=="none") echo'class="none"';
						 else if($D3['statue_request']=="seen") echo'class="seen"';
						
			
						 echo'>';
						 echo'<td>'.$i.'</td>';
						 echo'<td class="name_item"><a href="request_controle.php?id='.$D3['id_request'].'&type=show" ><img src="'.$D4['image_item'].'" width="40" height="40"> '.$D4['name_item'].' </a></td>';
						 echo'<td> '.$D4['type_item'].' : '.$D4['category'].' </td>';
						 $R_sender=
						 $R_sender=$db->prepare('SELECT * FROM user WHERE id_user=:id');
				
						$R_sender->execute(array(
								'id'=>$D3['id_user']
								));
						$D_sender=$R_sender->fetch();
						 echo'<td class="name_item"><a href="show_user.php?operation=show&id='.$D_sender['id_user'].'"><img  src="'.$D_sender['picture_user'].'" width="40" height="40"></a>'.$D_sender['first'].' '.$D_sender['last'].'<a id="send_mini2" href="send_controle.php?id='.$D_sender['id_user'].'"> SEND </a></td>';
						 echo'<td> '.$D3['time_request'].'</td>';
						 echo'<td> ';
						 if($D3['statue_request']=="none") echo'<a href="request_controle.php?id='.$D3['id_request'].'&type=show" class="none">  </a> Pas vu';
						 else if($D3['statue_request']=="seen") echo'<a href="request_controle.php?id='.$D3['id_request'].'&type=show" class="seen"> seen </a> vu  ';
						 else if($D3['statue_request']=="rejected") echo'<a href="request_controle.php?id='.$D3['id_request'].'&type=show" class="rejected"> seen </a> Refusé ';
						 else if($D3['statue_request']=="accepted") echo'<a href="request_controle.php?id='.$D3['id_request'].'&type=show" class="accepted"> seen </a> accepté ';

						 
						 
						 echo'</tr>';
						
						$D3=$R3->fetch();
						$i++;
					
					}
					echo'</table>';
					
					$R7=$db->query('SELECT COUNT(id_request) AS number  FROM request  ');
					
					
						$number=$R7->fetch();
						$resultat=$number['number'];
						
						if($resultat>$_GET['limit'])
						{
						$new_limit=$_GET['limit']+15;
						echo '<br><br><br><a id="more" href="administration.php?limit='.$new_limit.'"  > here </a><br>';
						}
				
				}
				
		
		
		?>
			</div><!-----------  ALL ---------------->
			
			<div id="bottom">
		
		</div> <!---------------- header -------------------->
			
		</body>
		
</html>