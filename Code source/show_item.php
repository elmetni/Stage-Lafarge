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

?>


	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//en"

       "http://www.w3.org/TR/html4/strict.dtd">




<html>
		<head> 
				<?php echo'<title> Rédiger la demande </title>';?>
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
				$ereur=0;
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
				echo'<div class="send_request_title"> ';
								$R=$db->prepare('SELECT * FROM item WHERE id_item=:id');
									$R->execute(array(
													'id'=>$_GET['id']
													));
									$D=$R->fetch();
									if($D==false)
									header('location:home.php');
									else
									{
										echo' <form action="show_item.php?id='.$_GET['id'].'" method="POST"  > ';
										echo '<strong>'.$D['type_item'].':</strong>'.$D['category'].' '.$D['name_item'];
										
												
										echo'</div>';
										echo'<img src="'.$D['image_item'].'" height="200" width="200" class="image_request" >';
										
										echo'<div class="request_content">';
										
										echo'<p> <span> Informations technique : </span>'.$D['description'].'</p>';
										
										echo'<p> <span>La quantié restante : </span>'.$D['quantity_item'].'</p>';
										
										
										
										
										
										
										
										echo'<p> <span> La date d\'ajout : </span>'.$D['time_item'].'</p>';
										
										
										
										
										if($D['quantity_item']!=-1)
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
										else echo'value=1';
										echo'></p>';
										
										}
										
									
										echo '<p> <span>Votre commentaire</span></p>';
										echo'<textarea  name="comment" COLS="80" ROWS="5"   WRAP="virtual">';
										if(isset($_POST['comment'])) echo htmlspecialchars($_POST['comment']); 
										echo'</textarea>';
											echo'</div>';
									
									echo'<input type="submit" name="send" class="upload" value="">';
									
											if(isset($_POST['send']) && $ereur==0)
											{
											
												
																	
																$R12=$db->prepare('INSERT INTO request VALUES(\'\',:id_user,:id_item,:quantity,NOW(),\'none\',:comment,\'non\',\'non\',\'seen\')');
																											
																$R12->execute(array(
																				
																				'id_user'=>$_SESSION['id'],
																				'id_item'=>$_GET['id'],
																				'quantity'=>$_POST['quantity'],
																				'comment'=>$_POST['comment'],
																				
																			)
																			);
																header('location:follow.php?limit=15');
																
																	
																	
												}
									}

				
				echo'</div>';
				
	?>
	<br>
		</div><!-----------  content ---------------->
		
		<p class="clear"></p>
			</div><!-----------  ALL ---------------->
			
			<div id="bottom">
		
		</div> <!---------------- header -------------------->
			
		</body>
		
</html>
	