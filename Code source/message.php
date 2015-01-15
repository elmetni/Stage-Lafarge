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
		
		if(isset($_GET['go']) && $_GET['go']!="new" && $_GET['go']!="send" )
		header('location:message.php');
		

?>


	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//en"

       "http://www.w3.org/TR/html4/strict.dtd">




<html>
		<head> 
				<?php echo'<title> Les messages</title>';?>
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
								if(isset($_GET['go'])&&$_GET['go']=="new") echo'class="here"';
								echo'>Nouveau message</a></li>';
								echo'<li><a href="message.php"';
								if(!isset($_GET['go']) OR (isset($_GET['go'])&&$_GET['go']!="new" && $_GET['go']!="send" ) ) echo'class="here"';
								echo'>Boîte de réception</a></li>';
								echo'<li><a href="message.php?go=send"';
								if(isset($_GET['go'])&&$_GET['go']=="send") echo'class="here"';
								echo'>Boîte d\'envoi</a></li>';
			
						echo'</ul>';
		?>
		
		
		</div>
		
		<div id="right_message">
						<?php
						if(isset($_GET['go'])&& $_GET['go']=="send")
						{
							echo'<table class="messsage">';
							
									$R_message=$db->prepare('SELECT * FROM message WHERE id_sender=:id GROUP BY  repeat_title  ORDER BY time_message DESC ');
									$R_message->execute(array(
												'id'=>$_SESSION['id']
												));
									$D_message=$R_message->fetch();
									if($D_message==false) echo'<p id="nothing"> vous n\'avez pas des messages dans votre boîte d\'envoi maintenant </p>';
									else
									{
									
										while($D_message)
										{
											
											$R_message2=$db->prepare('SELECT * FROM message WHERE  repeat_title=:repeat_title  AND id_sender=:id  ORDER BY time_message DESC ');
											$R_message2->execute(array(
												
												'repeat_title'=>$D_message['repeat_title'],
												'id'=>$_SESSION['id']
												));
											$D_message2=$R_message2->fetch();
											$R_last=$db->prepare('SELECT * FROM user WHERE id_user=:id');
											$R_last->execute(array(
														'id'=>$D_message2['id_sender']
													));
											$D_last=$R_last->fetch();
													
											echo'<tr';
											if($D_message2['statue_message']=='none') echo' class="none" ';
											echo'>';
											
											echo'<td class="body_message">';
													echo'<a href="read.php?id='.$D_message2['id_message'].'"><span class="title_message">'.$D_message2['title_message'].' :</span><span class="first_message"> ';
													
													for($i=0;$i<strlen($D_message2['value_message']);$i++)
													{
													
													echo $D_message2['value_message'][$i];
													if(($i+strlen($D_message2['title_message']))>60) { $i=-1 ; break;}
													}
													if($i==-1) echo"...";
													
													echo'</span></a>';
											
											echo'</td>';
											echo'<td class="time_message">';
													echo'<span >'.$D_message2['time_message'].'</span>';
											
											echo'</td>';
											echo'</tr>';
											$D_message=$R_message->fetch();
												}
											
								
									
									}
							
							echo'</table>';
							
						}
						
						else if(isset($_GET['go'])&& $_GET['go']=="new")
						{
						$ereur=0;
							
							
							echo'<form method="POST" action="message.php?go=new">';
							
							echo'<div class="message_new">';
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
																$R12=$db->prepare('INSERT INTO message VALUES(\'\',:id_sender,\'-1\',:value_message,:title_message,NOW(),\'seen\',:repeat_title)');
																											
																$R12->execute(array(
																				
																				'id_sender'=>$_SESSION['id'],
																				'value_message'=>$_POST['message_body'],
																				'title_message'=>$_POST['message_text'],
																				'repeat_title'=>$repeat,
																				
																			)
																			);
																header('location:message.php');
																
																	
																	
												}
							
						}
						else
						{
							echo'<table class="messsage">';
							
									$R_message=$db->prepare('SELECT * FROM message  WHERE id_reciever=:id_reciever  GROUP BY  repeat_title  ORDER BY time_message DESC ');
									$R_message->execute(array(
												'id_reciever'=>$_SESSION['id']
												));
									$D_message=$R_message->fetch();
									if($D_message==false) echo'<p id="nothing"> vous n\'avez pas des messages dans votre boîte de réception maintenant </p>';
									else
									{
									
										while($D_message)
										{
											
											$R_message2=$db->prepare('SELECT * FROM message WHERE  repeat_title=:repeat_title   ORDER BY time_message DESC ');
											$R_message2->execute(array(
												
												'repeat_title'=>$D_message['repeat_title'],
												
												));
											$D_message2=$R_message2->fetch();
											$R_last=$db->prepare('SELECT * FROM user WHERE id_user=:id');
											$R_last->execute(array(
														'id'=>$D_message2['id_sender']
													));
											$D_last=$R_last->fetch();
													
											$R10=$db->prepare('SELECT COUNT(*) AS none FROM message WHERE  repeat_title=:repeat_title');
																						$R10->execute(array(
																									
																									'repeat_title'=>$D_message['repeat_title']
																									)
																									);
																						
																						$number0=$R10->fetch();
																						$resultat=$number0['none'];
																						
											echo'<tr';
											if($D_message2['statue_message']=='none') echo' class="none" ';
											echo'>';
											echo'<td>';
													echo'<p class="name_sender"> <img src="'.$D_last['picture_user'].'"  height="25" width="25">'.$D_last['first'].' '.$D_last['last'].' </p>';
											echo'</td>';
											echo'<td>';
													echo'<a href="read.php?id='.$D_message2['id_message'].'"><span class="title_message">'.$D_message2['title_message'].'('.$resultat.') :</span><span class="first_message"> ';
													
													for($i=0;$i<strlen($D_message2['value_message']);$i++)
													{
													
													echo $D_message2['value_message'][$i];
													if(($i+strlen($D_message2['title_message']))>60) { $i=-1 ; break;}
													}
													if($i==-1) echo"...";
													
													echo'</span></a>';
											
											echo'</td>';
											echo'<td>';
													echo'<span class="time_message">'.$D_message2['time_message'].'</span>';
											
											echo'</td>';
											echo'</tr>';
											$D_message=$R_message->fetch();
												}
											
											
								
									
									}
							
							echo'</table>';
							
						}
						
						?>
		</div>
		<p class="clear"></p>
		
		
			</div><!-----------  ALL ---------------->
			
			<div id="bottom">
		
		</div> <!---------------- header -------------------->
			
		</body>
		
</html>