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
		
			if(isset($_GET['id'])==false  )
			header('location:message_controle.php');
			
		

?>



	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//en"

       "http://www.w3.org/TR/html4/strict.dtd">




<html>
		<head> 
				<?php echo'<title>Envoyer un message </title>';?>
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
		
				<li><a href="home.php"  >Demandes</a></li>
				<li><a href="item.php" >Articles</a></li>
				<li><a href="message_controle.php"   > Messages</a></li>
				<li><a href="profile_controle.php">Utilisateurs</a></li>	
		</ul>
		<div id="height"></div>
		
		<?php
			
				$ereur=0;
							
							
							echo'<form method="POST" action="send_controle.php?id='.$_GET['id'].'">';
							
							$R_reciever=$db->prepare('SELECT * FROM user WHERE id_user=:id_user');
							$R_reciever->execute(array(
											'id_user'=>$_GET['id']
											));
											
							$D_reciever=$R_reciever->fetch();
							if($D_reciever==false) header('location:message_controle.php');
							else
							{
								echo'<div class="reciever_message_controle"><a href="show_user.php?operation=show&id='.$D_reciever['id_user'].'"><img height=170 width=170 src="'.$D_reciever['picture_user'].'"></a><p> '.$D_reciever['first'].' '.$D_reciever['last'].' </p></div>';
							
							
							
							
							
							}
							echo'<div id="right_message"><div class="message_new">';
							if(isset($_POST['send_message']) && $_POST['message_text']=="") 
												{
												echo'<p class="error_in" ><img src="images/waring2.png" > Vous ne pouvez pas laisser ce champ vide</p>' ;
												$ereur=1;
												}
							echo'<p> Objet : <input type="text" name="message_text" id="message_text" ';
							if(isset($_POST['message_text'])) echo 'value='.$_POST['message_text'];
										
							echo'></p>';
							if(isset($_POST['send_message']) && $_POST['message_body']=="") 
												{
												echo'<p class="error_in" ><img src="images/waring2.png" > Vous ne pouvez pas laisser ce champ vide</p>' ;
												$ereur=1;
												}
							echo'<textarea name="message_body" id="message_body">';
							if(isset($_POST['message_body'])) echo$_POST['message_body'];
							echo'</textarea>';
							echo'<input type="submit" name="send_message" id="send_message">';
							echo'</div>';
							echo'</form>';
								if(isset($_POST['send_message']) && $ereur==0)
											{
											
																
																 
																 $R_test=$db->prepare('SELECT * FROM message WHERE title_message=:title_message');
																 $R_test->execute(array(
																					'title_message'=>$_POST['message_text']
																					));
																$D_test= $R_test->fetch();
																if($D_test==false) $repeat='1*'.$_POST['message_text'];
																else
																{
																		$R_max=$db->prepare('SELECT MAX(repeat_title) AS numbers FROM message WHERE title_message=:title_message');
																		$R_max->execute(array(
																						'title_message'=>$_POST['message_text']
																						));
																		
																		$number=$R_max->fetch();
																		$resultat=$number['numbers'];
																		$tab=explode('*',$resultat);
																		
																		$p=$tab[0]+1;
																	
																		$repeat=$p.'*'.$_POST['message_text'];
																
																
																}
																	 // id_message 	id_sender 	id_reciever 	value_message 	title_message 	time_message 	statue_message 	repeat_title 
																$R12=$db->prepare('INSERT INTO message VALUES(\'\',:id_sender,:id_reciever,:value_message,:title_message,NOW(),\'none\',:repeat_title)');
																											
																$R12->execute(array(
																				
																				'id_sender'=>$_SESSION['id'],
																				'id_reciever'=>$_GET['id'],
																				'value_message'=>$_POST['message_body'],
																				'title_message'=>$_POST['message_text'],
																				'repeat_title'=>$repeat,
																				
																			)
																			);
																header('location:message_controle.php');
																
																	
																	
												}
		
		
		?>
		</div>
		<p class="clear"></p>
		
		
			</div><!-----------  ALL ---------------->
			
			<div id="bottom">
		
		</div> <!---------------- header -------------------->
			
		</body>
		
</html>