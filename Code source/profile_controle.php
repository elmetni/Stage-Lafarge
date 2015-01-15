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
		

?>


	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//en"

       "http://www.w3.org/TR/html4/strict.dtd">




<html>
		<head> 
				<?php echo'<title>La guestion des utilisateurs </title>';?>
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
		
				<li><a href="administration.php"  >Demandes</a></li>
				<li><a href="item.php" >Articles</a></li>
				<li><a href="message_controle.php"> Messages</a></li>
				<li><a href="profile_controle.php"  class="here">Utilisateurs</a></li>	
		</ul>
	
		
		<p class="clear"></p>
		
		<?php
		
				echo'<a href="add_user.php" id="add_item"> add </a>';
				if(isset($_GET['go']) && $_GET['go']=="add")
				{
				
				
				
				
				
				
				
				}
				
				else
				{
						$Q=$db->query('SELECT * FROM user ');
																								
																							while($G=$Q->fetch())
																							{
																								echo'<div class="user_card">';
																								echo'<a href="show_user.php?operation=show&id='.$G['id_user'].'" title="'.$G['first'].' '.$G['last'].'"> <img src="'.$G['picture_user'].'" width=120 height=120 > </a>';
																								echo'<p>'.$G['first'].'<br>'.$G['last'].'</p>';
																								echo'<a href="show_user.php?operation=show&id='.$G['id_user'].'" class="'.$G['type_account'].'"  > here </a>';
																								
																								
																								echo'</div>';
																								
																							
																							
																							}
																					
				
				
				}
				
		?>
			<p class="clear"></p>
			<br>
			
			</div><!-----------  ALL ---------------->
			
			<div id="bottom">
		
		</div> <!---------------- header -------------------->
			
		</body>
		
</html>