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
		
		if(isset($_GET['id'])==false OR isset($_GET['type'])==false OR ($_GET['type']!="show" AND $_GET['type']!="edit" ))
		header('location:follow.php?limit=15');
?>


	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//en"

       "http://www.w3.org/TR/html4/strict.dtd">




<html>
		<head> 
				<?php echo'<title> Les détails de votre demande </title>';?>
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
		
				<li><a href="home.php" > Rédiger Demande</a></li>
				<li><a href="follow.php?limit=15"> Suivre Demande</a></li>
				<li><a href="message.php"> Messages</a></li>
				<li><a href="profile.php"> Profil</a></li>		
		</ul>
		
	<?php
	$R1=$db->prepare('SELECT * FROM request WHERE id_request=:id ');
	$R1->execute(array(
				'id'=>$_GET['id']
				));
	$D1=$R1->fetch();
	if($D1==false)
	header('location:follow.php?limit=15');
	else
	{
				if($_GET['type']=='show')
				{
						$update2=$db->prepare('UPDATE request SET statue_sender=\'seen\' WHERE id_request=:id_request');
																				$update2->execute(array(
																							
																							'id_request'=>$_GET['id']
																							));
						$R2=$db->prepare('SELECT * FROM item WHERE id_item=:id ');
						$R2->execute(array(
									'id'=>$D1['id_item']
									));
						$D2=$R2->fetch();
						
						echo'<div class="show_request_title">';
						echo '<strong>'.$D2['type_item'].':</strong>'.$D2['category'].' '.$D2['name_item'];		
						echo'</div>';
						
						
										
										echo'<div class="show_request_content">';
										
										if($D1['statue_request']=="rejected" OR $D1['statue_request']=="none" OR $D1['statue_request']=="seen")
											{
											echo ' <a id="edit_done" href="show_request.php?type=edit&id='.$_GET['id'].'" > edit done </a> ';
											echo'<iframe id="delet_request" src="delet_request.php?id='.$D1['id_request'].'" height="40" width="80" SCROLLING="no" id="delet_request" NORESIZE FRAMEBORDER="0"></iframe>';
											
											}
											
										echo'<p> <span> Informations technique : </span>'.$D2['description'].'</p>';
										
										echo'<p> <span>La quantié restante : </span>'.$D2['quantity_item'].'</p>';
										
										echo'<p> <span> La date d\'ajout : </span>'.$D2['time_item'].'</p>';
										
										
										echo'<p> <span> La quantité de votre demande  : </span>'.$D1['quantity_request'].'</p>';
										
										
										echo'<p> <span> La date de votre demande : </span>'.$D1['time_request'].'</p>';
										
										echo'<p> <span> Votre commentaire : </span></p><p>'.$D1['comment_request'].' </p></div>';
				
										
				echo'<div class="show_request_div"> <img src="'.$D2['image_item'].'" height="250" width="250" class="show_request_content" >';
						echo'<p class="name_item_show"> '.$D2['name_item'].'</p></div><p class="clear"></p><br>';
				
				
				if($D1['statue_request']=='none')
				{
						echo'<div class="show_statue_request_none" >	<img src="images/none2.png"> <div class="in"><p> l\'administration n\'a pas encore vu votre demande </p></div><p class="clear"></p></div>';
				
				}
				
				if($D1['statue_request']=='seen')
				{
						echo'<div class="show_statue_request_seen" >	<img src="images/seen2.png"> <div class="in"><p> l\'administration a  vu votre demande  le <span>'.$D1['time_answer'].'</span> </p></div><p class="clear"></p></div>';
				
				}
				
				if($D1['statue_request']=='rejected')
				{
						echo'<div class="show_statue_request_rejected" >	<img src="images/rejected2.png"> <div class="in"><p> l\'administration a refusé votre demande  le <span>'.$D1['time_answer'].' </span> </p>';
						
						echo'<p> Detail : <span>'.$D1['detail_answer'].'<span></p>';
						echo'</div><p class="clear"></p></div>';
				
				}
				
				if($D1['statue_request']=='accepted')
				{
						echo'<div class="show_statue_request_accepted" >	<img src="images/accepted2.png"> <div class="in"><p> l\'administration a accepté votre demande  le  <span>'.$D1['time_answer'].'</span>  </p>';
						
						echo'<p> Detail : <span>'.$D1['detail_answer'].'<span></p>';
						echo'</div><p class="clear"></p></div>';
				
				}
				
				
				}
				
				else if($_GET['type']=="edit")
				{
				
										$update2=$db->prepare('UPDATE request SET statue_sender=\'seen\' WHERE id_request=:id_request');
																				$update2->execute(array(
																							
																							'id_request'=>$_GET['id']
																							));
									$ereur=0;
									$R1=$db->prepare('SELECT * FROM request WHERE id_request=:id ');
									$R1->execute(array(
												'id'=>$_GET['id']
												));
									$D1=$R1->fetch();
									if($D1==false)
									header('location:follow.php?limit=15');
									else
									{
											$R=$db->prepare('SELECT * FROM item WHERE id_item=:id');
											$R->execute(array(
															'id'=>$D1['id_item']
															));
											$D=$R->fetch();
											if($D==false)
											header('location:home.php');
											else
											{
												echo'<div class="edit_request_title">';
												echo' <form action="show_request.php?id='.$_GET['id'].'&type=edit" method="POST"  > ';
												echo '<strong>'.$D['type_item'].':</strong>'.$D['category'].' '.$D['name_item'];
												
														
												echo'</div>';
												
												
												echo'<div class="edit_request_content">';
												
												echo'<p> <span> Informations technique : </span>'.$D['description'].'</p>';
												
												echo'<p> <span>La quantié restante : </span>'.$D['quantity_item'].'</p>';
												
												
												
												
												
												
												
												echo'<p> <span> La date d\'ajout : </span>'.$D['time_item'].'</p>';
												
												
												
												
												if($D['quantity_item']!=1000000000)
												{
												if(isset($_POST['send']) && $_POST['quantity']=="") 
														{
														echo'<p class="error_in" ><img src="images/waring2.png" > Vous ne pouvez pas laisser ce champ vide</p>' ;
														$ereur=1;
														}
												else if(isset($_POST['send']) && $_POST['quantity']>$D['quantity_item']) 
														{
														echo'<p class="error_in" ><img src="images/waring2.png" > Vous ne pouvez pas demander cette quantité </p>' ;
														$ereur=1;
														}
												echo '<p> <span>La quantité de votre demande  :</span> <input type="text" name="quantity" id="quantity" ';
												if(isset($_POST['quantity'])) echo 'value='.$_POST['quantity'];
												else echo'value="'.$D1['quantity_request'].'"';
												echo'></p>';
												
												}
												
											
												echo '<p> <span>Votre commentaire</span></p>';
												echo'<textarea  name="comment" COLS="80" ROWS="5"   WRAP="virtual">';
												if(isset($_POST['comment'])) echo htmlspecialchars($_POST['comment']);
												else echo $D1['comment_request'];												
												echo'</textarea>';
													echo'</div>';
												echo'<div class="show_request_div"><img src="'.$D['image_item'].'" height="250" width="250" class="show_request_content" ></div>';
											
											echo'<input type="submit" name="send" id="edit" value="">';
											
													if(isset($_POST['send']) && $ereur==0)
													{
													
														
																			
																		if($D1['quantity_request']!=$_POST['quantity'])
																																
																		{
																				$update2=$db->prepare('UPDATE request SET quantity_request=:quantity WHERE id_request=:id_request');
																				$update2->execute(array(
																							'quantity'=>$_POST['quantity'],
																							'id_request'=>$_GET['id']
																							));
																		}
																		
																		if($D1['comment_request']!=$_POST['comment'])
																																
																		{
																				$update3=$db->prepare('UPDATE request SET comment_request=:comment_request WHERE id_request=:id_request');
																				$update3->execute(array(
																							'comment_request'=>$_POST['comment'],
																							'id_request'=>$_GET['id']
																							));
																		}
																		
																		
																		if($D1['statue_request']!="none")
																																
																		{
																				$update1=$db->prepare('UPDATE request SET statue_request=:statue_request WHERE id_request=:id');
																				$update1->execute(array(
																							'statue_request'=>"none",
																							'id'=>$_GET['id']
																							));
																							
																				$update1=$db->prepare('UPDATE request SET detail_answer=:detail_answer WHERE id_request=:id');
																				$update1->execute(array(
																							'detail_answer'=>"none",
																							'id'=>$_GET['id']
																							));
																							
																				
																		}
																				$update1=$db->prepare('UPDATE request SET time_request=NOW() WHERE id_request=:id');
																				$update1->execute(array(
																							
																							'id'=>$_GET['id']
																							));
																																
																												
																												
																												
																			header('location:show_request.php?id='.$_GET['id'].'&type=show');
																		
																			
																			
												}
									
				
				
				
				
											}
											}
											}
		
	
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
	