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
		
		$R_go=$db->query('SELECT * FROM item ');
		$D_go=$R_go->fetch();
		
		if((isset($_GET['type'])==false OR isset($_GET['category'])==false ) AND  $D_go!=false)
		{
		
		header('location:home.php?type='.$D_go['type_item'].'&category='.$D_go['category']);
		}
		else if($D_go==false)
		{
			
		
		}

?>


	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//en"

       "http://www.w3.org/TR/html4/strict.dtd">




<html>
		<head> 
				<?php echo'<title>Envoyer demande</title>';?>
				<link href="style.css" rel="stylesheet" type="text/css" media="screen" >
		</head>
		
		<body>
		<div id="all" >
		<div id="height"></div>
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
		<div id="content">
		<ul id="menu">
		
				<li><a href="home.php" class="here" > Rédiger Demande</a></li>
				<li><a href="follow.php?limit=15"> Suivre Demande</a></li>
				<li><a href="message.php"> Messages</a></li>
				<li><a href="profile.php"> Profil</a></li>		
		</ul>
		
	<?php
	
			if($D_go==false)
			{
			
			echo'<p id="nothing">Il n\'y a pas d\'article pour le moment</p> <br>'; 
			}
			else
			{
				echo'<div class="left_home"> <ul>';
				$R_item=$db->query('SELECT * FROM item GROUP BY type_item');
				
			
				while($D_item=$R_item->fetch())
				{
					echo'<li class="type_item">'.$D_item['type_item'].'</li>';
					$R_category=$db->prepare('SELECT * FROM item WHERE type_item=:type_item GROUP BY category');
					$R_category->execute(array(
								'type_item'=>$D_item['type_item']
								));
					while($D_category=$R_category->fetch())
					{
					
					echo'<li><a href="home.php?type='.$D_category['type_item'].'&category='.$D_category['category'].'">'.$D_category['category'].'</a></li>';
					}
				
				
				}
				echo' </ul></div>';
				
	
				echo'<div class="right_home">';
					if(isset($_GET['type'])&& isset($_GET['category']))
					{
						$R1=$db->prepare('SELECT * FROM item WHERE type_item=:type_item AND category=:category');
						$R1->execute(array(
								'type_item'=>$_GET['type'],
								'category'=>$_GET['category']
								));
						$D1=$R1->fetch();
						if($D1!=false)
						echo '<p class="title_item"> '.$D1['type_item'].' : '.$D1['category'].'</p>';
						else header('location:home.php');
						while($D1)
						{
							if($D1['quantity_item']>0)
							{
							echo'<div class="item_card">';
							echo'<div class="img_item_card"><a  href="show_item.php?id='.$D1['id_item'].'&type=show"><img src="'.$D1['image_item'].'" width="120" height="120" ></a>';
							echo'</div><a href="show_item.php?id='.$D1['id_item'].'&type=show">'.$D1['name_item'].'</a>';
							
							}
							
							
							echo'</div>';
						
						
						
						$D1=$R1->fetch();
						
						}
					
					
					
					
					
					}
				
				
				
				echo'</div>';
				}
	
	?>
	<br>
		</div><!-----------  content ---------------->
		
		<p class="clear"></p>
			</div><!-----------  ALL ---------------->
			
			<div id="bottom">
		
		</div> <!---------------- header -------------------->
			
		</body>
		
</html>