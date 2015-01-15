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
		
	if(isset($_GET['id'])==false )
	header('location:message.php');
	else if( $_GET['limit']<15 OR is_numeric($_GET['limit'])==false)
	header('location:read.php?id='.$_GET['id'].'&limit=15');
		

?>


	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//en"

       "http://www.w3.org/TR/html4/strict.dtd">




<html>
		<head> 
				<?php echo'<title>  Afficher message </title>';?>
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
		
				<li><a href="home.php"  > Rédiger Demande</a></li>
				<li><a href="follow.php"> Suivre Demande</a></li>
				<li><a href="message.php" class="here"> Messages</a></li>
				<li><a href="profile.php"> Profil</a></li>		
		</ul>
		<div id="height"></div>
		<div id="left_message">
		<?php
						echo'<ul>';
								echo'<li><a href="message.php?go=new"';
						
								echo'>Nouveau message</a></li>';
								echo'<li><a href="message.php"';
								
								echo'>Boîte de réception</a></li>';
								echo'<li><a href="message.php?go=send"';
							
								echo'>Boîte d\'envoi</a></li>';
			
						echo'</ul>';
		?>
		
		
		</div>
		
		<div id="right_message">
						<?php
								$R=$db->prepare('SELECT * FROM message WHERE id_message=:id');
								$R->execute(array(
												'id'=>$_GET['id']
											));
								$D=$R->fetch();
								if($D==false)
								header('location:message.php');
								else if($D['id_sender']!=$_SESSION['id'] && $D['id_reciever']!=$_SESSION['id'] && $D['id_reciever']!=-1 )
								header('location:message.php');
								else
								{
												$update2=$db->prepare('UPDATE message SET statue_message=\'seen\' WHERE repeat_title=:repeat_title AND id_reciever=:id_reciever ');
												$update2->execute(array(
															
															'repeat_title'=>$D['repeat_title'],
															'id_reciever'=>$D['id_reciever']
															));
										
										
										
										
													$R_first=$db->prepare('SELECT * FROM message WHERE repeat_title=:repeat_title');
									
													$R_first->execute(array(
															'repeat_title'=>$D['repeat_title']
														));
											
													$D_first=$R_first->fetch();
												
												echo'<div class="first_sender">';
													
								
													$R_first_sender=$db->prepare('SELECT * FROM user WHERE id_user=:id');
													$R_first_sender->execute(array(
															'id'=>$D_first['id_sender']
														));
													$D_first_sender=$R_first_sender->fetch();
													echo'<div class="info_sender">';
													echo'<p class="title"> '.$D_first_sender['first'].' '.$D_first_sender['last'].' </p>';
													echo'<img src="'.$D_first_sender['picture_user'].'" height="170" width="170">';
													echo'</div>';
													echo'<div class="message_sender">';
													echo'<p class="title" > '.$D_first['title_message'].'</p>';
													echo'<p>'.$D_first['value_message'].'</p>';
													
													
										$R10=$db->prepare('SELECT COUNT(*) AS none FROM message WHERE  repeat_title=:repeat_title');
																						$R10->execute(array(
																									
																									'repeat_title'=>$D['repeat_title']
																									)
																									);
																						
																						$number0=$R10->fetch();
																						$resultat=$number0['none'];			
													echo'</div>';
													echo'<p class="clear"></p>';
													echo'</div>';
													
													
													echo'<div class="rest">';
													$p=$resultat-$_GET['limit'];
													if($p>0) 
													{
													$new_limit=$_GET['limit']+15;
													
													echo '<a id="more_down" href="read.php?limit='.$new_limit.'&id='.$_GET['id'].'"  > here </a>';
													
													}
													
													else $p=0;
													$R11=$db->prepare('SELECT * FROM message WHERE  repeat_title=:repeat_title LIMIT '.$p.','.$resultat.'');
													$R11->execute(array(
															'repeat_title'=>$D['repeat_title']
														));
													
													$D11=$R11->fetch();
															while($D11=$R11->fetch())
															{
															
															
																
																$R88=$db->prepare('SELECT * FROM user WHERE id_user=:id');
																$R88->execute(array(
																		'id'=>$D11['id_sender']
																	));
																$D88=$R88->fetch();
																echo'<div class="a_message">';
																echo'<img src="'.$D88['picture_user'].'" height="70" width="70">';
																echo'<div>';
																echo'<p class="name"> '.$D88['first'].' '.$D88['last'].'</p>';
																echo'<p class="time"> '.$D11['time_message'].'</p>';
																echo'<p class="message"> '.$D11['value_message'].' </p>';
																
																echo'</div>';echo'<p class="clear"></p>';
																echo'</div>';
																
															
															
															
															}
															
															
													echo'<div class="a_message">';
																echo'<img src="'.$D_user['picture_user'].'" height="70" width="70">';
																echo'<div>';
																echo'<p class="name"> '.$D_user['first'].' '.$D_user['last'].'</p>';
																echo'<form action="read.php?id='.$_GET['id'].'&limit='.$_GET['limit'].'" method="POST">';
																echo'<br><br><textarea name="replay" id="replay" >';
																if(isset($_POST['replay'])) echo $_POST['replay'];
																echo'</textarea>';
																echo'<input type="submit" name="replay_botton" id="replay_botton">';
																echo'<form>';
																
																echo'</div>';echo'<p class="clear"></p>';
																echo'</div>';
																
																
													echo'</div>';
								
													if(isset($_POST['replay']) && $_POST['replay']!="")
													{
															$R12=$db->prepare('INSERT INTO message VALUES(\'\',:id_sender,\'-1\',:value_message,:title_message,NOW(),\'seen\',:repeat_title)');
																											
																$R12->execute(array(
																				
																				'id_sender'=>$_SESSION['id'],
																				'value_message'=>$_POST['replay'],
																				'title_message'=>$D['title_message'],
																				'repeat_title'=>$D['repeat_title'],
																				
																			)
																			);
																	header('location:read.php?id='.$_GET['id'].'&limit='.$_GET['limit']);
													
													}
								
								
								
								
								
								}
								
						
						?>
		</div>
		<p class="clear"></p>
		
		
			</div><!-----------  ALL ---------------->
			
			<div id="bottom">
		
		</div> <!---------------- header -------------------->
			
		</body>
		
</html>