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
				<li><a href="message_controle.php"  class="here" > Messages</a></li>
				<li><a href="profile_controle.php">Utilisateurs</a></li>	
		</ul>
	
		
		<p class="clear"></p>
		<div id="left_message">
			<?php
						echo'<ul>';
								
								echo'<li><a href="message_controle.php"';
								if(!isset($_GET['go']) OR (isset($_GET['go'])&&$_GET['go']!="new" && $_GET['go']!="send" ) ) echo'class="here"';
								echo'>Boîte de réception</a></li>';
								echo'<li><a href="message_controle.php?go=send"';
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
										
											$R_test_read=$db->prepare('SELECT * FROM read_message WHERE id_user=:id_user AND id_message=:id_message');
																$R_test_read->execute(array(
																				'id_user'=>$_SESSION['id'],
																				'id_message'=>$D_message2['id_message']
																			));
																$D_test_read=$R_test_read->fetch();
																if($D_test_read==false AND $D_message2['id_sender']!=$_SESSION['id'])
																{
																	 echo' class="none" ';
																}
											echo'>';
											
											echo'<td class="body_message">';
													echo'<a href="read_controle.php?id='.$D_message2['id_message'].'&limit=15"><span class="title_message">'.$D_message2['title_message'].' :</span><span class="first_message"> ';
													
													
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
						
						else
						{
							echo'<table class="messsage">';
							
									$R_message=$db->prepare('SELECT * FROM message WHERE id_reciever=:id GROUP BY  repeat_title  ORDER BY time_message DESC ');
									$R_message->execute(array(
												'id'=>'-1'
												));
									$D_message=$R_message->fetch();
									if($D_message==false) echo'<p id="nothing"> vous n\'avez pas des messages dans votre boîte de réception maintenant </p>';
									else
									{
									
										while($D_message)
										{
											
											$R_message2=$db->prepare('SELECT * FROM message WHERE  repeat_title=:repeat_title    ORDER BY time_message DESC ');
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
											
											$R_test_read=$db->prepare('SELECT * FROM read_message WHERE id_user=:id_user AND id_message=:id_message');
																$R_test_read->execute(array(
																				'id_user'=>$_SESSION['id'],
																				'id_message'=>$D_message2['id_message']
																			));
																$D_test_read=$R_test_read->fetch();
																if($D_test_read==false AND $D_message2['id_sender']!=$_SESSION['id'])
																{
																	 echo' class="none"';
																}
											echo'>';
											echo'<td>';
													echo'<p class="name_sender"> <a href="show_user.php?id='.$D_last['id_user'].'&operation=show"><img src="'.$D_last['picture_user'].'"  height="25" width="25"></a>'.$D_last['first'].' '.$D_last['last'].' </p>';
											echo'</td>';
											echo'<td>';
													echo'<a href="read_controle.php?id='.$D_message2['id_message'].'&limit=15"><span class="title_message">'.$D_message2['title_message'].'('.$resultat.') :</span><span class="first_message"> ';
													
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
			
			<br>
			
			</div><!-----------  ALL ---------------->
			
			<div id="bottom">
		
		</div> <!---------------- header -------------------->
			
		</body>
		
</html>