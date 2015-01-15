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
				<?php echo'<title>Les détails d\'utilisateur </title>';?>
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
				<li><a href="profile_controle.php" >Utilisateurs</a></li>	
		</ul>
	
		
		<p class="clear"></p>
		
		<?php
		echo'<div class="left_administrastion">';
							if($_GET['operation']=="show")
																								 {
																									echo'<div class="show_controle_user">';
																								 
																									$Q=$db->prepare('SELECT * FROM user WHERE id_user=:id');
																									$Q->execute(array(
																												'id'=>$_GET['id']
																									));
																									$O=$Q->fetch();
																									
																									echo'<div class="user_name_img"><img src="'.$O['picture_user'].'" height=200 width=200 >';
																									echo '<p id="name_user"> '.$O['first'].' '.$O['last'].' </p></div>';
																									echo'<div class="info">';
																									if($O['type_account']=="user") echo'<img src="images/user.png" width=120 height=40 >';
																									else if($O['type_account']=="administrator") echo'<img src="images/administrator_hard.png" width=120 height=40 >';
																									
																									
																												
																													if($O['statue_account']=="enable")
																													{
																															echo'<form id="enable_disable"  action="show_user.php?operation='.$_GET['operation'].'&id='.$_GET['id'].'" method="POST">';
																															echo'<input type="submit" name="desactiver" id="desactiver" value="desactiver" ></form>';
																													
																													}
																													
																													else if($O['statue_account']=="disable")
																													{
																															echo'<form id="enable_disable" action="show_user.php?operation='.$_GET['operation'].'&id='.$_GET['id'].'" method="POST">';
																															echo'<input type="submit" name="activer" id="activer" value="activer" ></form>';
																													
																													}
																													
																													if(isset($_POST['desactiver']))
																													{
																															$F=$db->prepare('UPDATE user SET statue_account=\'disable\' WHERE id_user=:id');
																															$F->execute(array(
																																	'id'=>$_GET['id']
																																	));
																															header('location:show_user.php?operation='.$_GET['operation'].'&id='.$_GET['id']);
																													
																													
																													}
																													
																													else if(isset($_POST['activer']))
																													{
																															$F=$db->prepare('UPDATE user SET statue_account=\'enable\' WHERE id_user=:id');
																															$F->execute(array(
																																	'id'=>$_GET['id']
																																	));
																																	header('location:show_user.php?operation='.$_GET['operation'].'&id='.$_GET['id']);
																													}
																									
																										echo'<a id="send_mini" href="send_controle.php?id='.$_GET['id'].'"> SEND </a>';
																										echo ' <a id="edit_done" href="show_user.php?operation=edit&id='.$_GET['id'].'" > edit done </a> ';
																									
																										echo'<iframe id="delet_done" src="delet_controle.php?id='.$_GET['id'].'&type=user" height="40" width="80" SCROLLING="no" NORESIZE FRAMEBORDER="0"></iframe>';
																										
																										
																									
																									
																									
																									
																									echo '<p><span> Identifiant : </span> '.$O['login'].' </p>';
																									
																									if(isset($_POST['show_password'])==false)
																									{
																												
																												
																												echo'<form  id="show_password"  action="show_user.php?operation='.$_GET['operation'].'&id='.$_GET['id'].'" method="POST">';
																												echo'<input type="submit" name="show_password" id="show_password" ></form>';
																												echo'<p id="show_password"  ><span> Mot de passe : </span>&nbsp;&nbsp;'.$O['password'][0].' ';
																												for($i=1;$i<strlen($O['password']);$i++)
																												{
																													echo'*';
																												}
																												echo'</p>';
																												
																									}
																									else
																										echo '<p id="show_password"  ><span> Mot de passe : </span>&nbsp;&nbsp;'.$O['password'].'</p>' ;
																									
																									
																									echo '<p class="clear_left">';
																									echo'<span> Fonction : </span> '.$O['fonction'].' </p>';
																									echo'<p><span> Departement : </span> '.$O['departement'].' </p>';
																									echo'<p><span> Téléphone : </span> '.$O['telephone'].' </p>';
																									echo '<p><span> Email : </span> '.$O['email'].' </p>';

																									echo '<p><span> Numéro de matricule : </span> '.$O['nm'].' </p>';
																									echo '<p><span> Statue de compte: </span> ';
																									if($O['statue_account']=="disable") echo' <span class="disable">Désactivé </span></p>';
																									if($O['statue_account']=="enable") echo'<span class="enable"> Activé </span></p>';
																									
																									
																									
																								 
																								 
																									echo'</div>';
																									echo'</div>';
																								 }
																								 
																								else if($_GET['operation']=="edit")
																																 {
																																 
																																				$R_edit=$db->prepare('SELECT * FROM user WHERE id_user=:id');
																																				$R_edit->execute(array(
																																						'id'=>$_GET['id']
																																						));
																																				$D_edit=$R_edit->fetch();
																																				if($D_edit==false) header('location:Administration.php');
																																				$error=0;
																																				echo'<div class="edit_user">';
																																				echo'<form method="POST"  action="show_user.php?operation=edit&id='.$_GET['id'].'"  enctype="multipart/form-data">';
																																				
																																					echo'<div class="add_test_title"><p>Modifier l\'utilisateur : '.$D_edit['first'].' '.$D_edit['last'].'</p></div>';
																																					
																																					
																																					
																																						
																																	echo'<p class="main">* Nom  : <input type="text" name="add_user_first" ';
																																	
																																	if(isset($_POST['add_user_first'])) echo 'value="'.$_POST['add_user_first'].'"';
																																	else echo 'value="'.$D_edit['first'].'"';
																																	echo'>';
																																	
																																	
																																	 echo' </p>';
																																	if(isset($_POST['add_user']) && $_POST['add_user_first']=="")
																																			{
																																					echo'<span class="error" ><img src="images/waring2.png"> Vous ne pouvez pas laisser ce champ vide</span>' ;
																																					$error=1;
																																					
																																			
																																			}
																																	 echo'<p class="main">* Prénom  : <input type="text" name="add_user_last"';
																																	
																																	if(isset($_POST['add_user_last'])) echo 'value="'.$_POST['add_user_last'].'"';
																																	else echo 'value="'.$D_edit['last'].'"';
																																	echo'>';
																																	
																																	
																																	 echo' </p>';
																																	 if(isset($_POST['add_user']) && $_POST['add_user_last']=="")
																																			{
																																					echo'<span class="error" ><img src="images/waring2.png"> Vous ne pouvez pas laisser ce champ vide</span>' ;
																																					$error=1;
																																					
																																			
																																			}
																																	  echo'<p class="main">* Identifiant (pour se connecter): <input type="text" name="add_user_login"';
																																	
																																	if(isset($_POST['add_user_login'])) echo 'value="'.$_POST['add_user_login'].'"';
																																	else echo 'value="'.$D_edit['login'].'"';
																																	echo'>';
																																	
																																	
																																	 echo' </p>';
																																	 if(isset($_POST['add_user']) && $_POST['add_user_login']=="")
																																			{
																																					echo'<span class="error" ><img src="images/waring2.png"> Vous ne pouvez pas laisser ce champ vide</span>' ;
																																					$error=1;
																																					
																																			
																																			}
																																	else if(isset($_POST['add_user']) && $_POST['add_user_login']!="")
																																			{
																																					$g=$db->prepare('SELECT * FROM user WHERE login=:login');
																																					$g->execute(array(
																																							'login'=>$_POST['add_user_login']
																																							));
																																					$t=$g->fetch();
																																					if($t!=false && $t['login']!=$D_edit['login'])
																																					{
																																					
																																					echo'<span class="error" ><img src="images/waring2.png"> Identifiant déja exist </span>' ;
																																					$error=1;
																																					
																																					}
																																					
																																					
																																					
																																			
																																			}
																																	  echo'<input type="submit" name="add_user" class="edit_user" value="">';
																																	 
																																	  echo'<p class="main">* Mot de passe &nbsp; : &nbsp;&nbsp;<input type="password" name="add_user_password"';
																																	
																																	if(isset($_POST['add_user_password'])) echo 'value="'.$_POST['add_user_password'].'"';
																																	else echo 'value="'.$D_edit['password'].'"';
																																	echo'></P>';
																																	  
																																	  if(isset($_POST['add_user']) && $_POST['add_user_password']=="")
																																			{
																																					echo'<span class="error" ><img src="images/waring2.png"> Vous ne pouvez pas laisser ce champ vide</span>' ;
																																					$error=1;
																																					
																																			
																																			}
																																			else if(isset($_POST['add_user']) && strlen($_POST['add_user_password'])<8  && $_POST['add_user_password']!="")
																																			{
																																					echo'<span class="error" ><img src="images/waring2.png"> le mot de passe doit être de plus de 8 caractères</span>' ;
																																					$error=1;
																																					
																																			
																																			}
																																		echo'<p class="main">* Re-Mot de passe  : <input type="password" name="add_user_re_password"';
																																	
																																	if(isset($_POST['add_user_re_password'])) echo 'value="'.$_POST['add_user_re_password'].'"';
																																	else echo 'value="'.$D_edit['password'].'"';
																																	echo'></P>';
																																	 if(isset($_POST['add_user']) && $_POST['add_user_re_password']!=$_POST['add_user_password'])
																																			{
																																					echo'<span class="error" ><img src="images/waring2.png">s\'il vous plaît confirmer le mot de passe</span>' ;
																																					$error=1;
																																					
																																			
																																			}
																																	
																																	
																																	  
																																	   echo'<p class="main">* Type de compte  : ' ;
																																	  echo ' <select name="statue"><option value="user" ';
																																	  
																																	  if(isset($_POST['statue'])&& $_POST['statue']=="user") echo ' selected ';
																																	  else if(!isset($_POST['statue'])&& $D_edit['type_account']=="user")  echo ' selected ';
																																	  echo'> Utilisateur </option><option value="administrator" ';
																																	  
																																	  if(isset($_POST['statue'] )&& $_POST['statue']=="administrator") echo ' selected ';
																																	  else if(!isset($_POST['statue'])&& $D_edit['type_account']=="administrator")  echo ' selected ';
																																	  echo '>administrateur  </option></select></p>';
																																	  
																																
																																	echo'<p class="main">Fonction  : <input type="text" name="fonction"';
																																	
																																	if(isset($_POST['fonction'])) echo 'value="'.$_POST['fonction'].'"';
																																	else echo 'value="'.$D_edit['fonction'].'"';
																																	echo'></p>';
																																	
																																	echo'<p class="main">Departement  : <input type="text" name="departement"';
																																	
																																	if(isset($_POST['departement'])) echo 'value="'.$_POST['departement'].'"';
																																	else echo 'value="'.$D_edit['departement'].'"';
																																	echo'></p>';
																																	
																																
																																	echo'<p class="main">Télephone  : <input type="text" name="add_user_Telephone"';
																																	
																																	if(isset($_POST['add_user_Telephone'])) echo 'value="'.$_POST['add_user_Telephone'].'"';
																																	else echo 'value="'.$D_edit['telephone'].'"';
																																	echo'></p>';
																																	echo'<p class="main">Email  : <input type="text" name="add_user_email"';
																																	
																																	if(isset($_POST['add_user_email'])) echo 'value="'.$_POST['add_user_email'].'"';
																																	else echo 'value="'.$D_edit['email'].'"';
																																	echo'></p>';
																																	echo'<p class="main">Numéro de matricule  : <input type="text" name="add_user_nm"';
																																	
																																	if(isset($_POST['add_user_nm'])) echo 'value="'.$_POST['add_user_nm'].'"';
																																	else echo 'value="'.$D_edit['nm'].'"';
																																	echo'></p>';
																																	echo'<p class="main">Image : <input type="FILE" name="user_image"';
																																	
																																	
																																	echo'></p>';
																														
																														
																														
																														if(isset($_POST['add_user']) && $_FILES['user_image']['error']!=0 && $_FILES['user_image']['size']!=0)
																															{
													
																																			echo'<span class="error" ><img src="images/waring2.png"> Erreur de Téléchargement .. essayer plus tard</span>' ;
																																					$error=1;
													
													
																															}
																														else if(isset($_POST['add_user']) && $_FILES['user_image']['error']==0 && $_FILES['user_image']['size']!=0)
																														{
																																	if(isset($_POST['add_user']) && $_FILES['user_image']['error']!=0 && $_FILES['user_image']['size']> 4000000)
																																	{
															
																																					echo'<span class="error" ><img src="images/waring2.png">le size d\'image doit être inférieure à 4 mo</span>' ;
																																							$error=1;
															
															
																																	}
																																	else
																																	{
																																			$infosfichier = pathinfo($_FILES['user_image']['name']);
																																			$extension_upload = $infosfichier['extension'];
																																			$extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png','flv','bmp','JPG','JPEG','GIF','PNG','FLV','BMP');
																																			if (in_array($extension_upload, $extensions_autorisees)==false)
																																			{
																																				echo'<span class="error" ><img src="images/waring2.png">incorrect extention </span>' ;
																																							$error=1;
																																	
																																	
																																	
																																			}
																																	}
																															}
																														
														
																												
																												
																														if(isset($_POST['add_user']) && $error==0)
																														{
																														
																																
																																if($_FILES['user_image']['size']==0)
																																$image=$D_edit['picture_user'];
																																else
																																{
																																		$da=$_POST['add_user_first'].'_'.$_POST['add_user_last'].'_'.date('Y').'_'.date('m').'_'.date('d').'_'.date('h').'_'.date('i').'_'.$_POST['add_user_nm'];
																																		$infosfichier = pathinfo($_FILES['user_image']['name']);
																																		$extension_upload = $infosfichier['extension'];
																																		$image='user/'.$da.'.'.$extension_upload;
																																		move_uploaded_file($_FILES['user_image']['tmp_name'], $image);
																																
																																}
																																if($D_edit['first']!=$_POST['add_user_first'])
																																
																																{
																																		$update1=$db->prepare('UPDATE user SET first=:first WHERE id_user=:id');
																																		$update1->execute(array(
																																					'first'=>$_POST['add_user_first'],
																																					'id'=>$D_edit['id_user']
																																					));
																																}
																																
																																if($D_edit['last']!=$_POST['add_user_last'])
																																
																																{
																																		$update1=$db->prepare('UPDATE user SET last=:last WHERE id_user=:id');
																																		$update1->execute(array(
																																					'last'=>$_POST['add_user_last'],
																																					'id'=>$D_edit['id_user']
																																					));
																																}
																																if($D_edit['fonction']!=$_POST['fonction'])
																																
																																{
																																		$update1=$db->prepare('UPDATE user SET fonction=:fonction WHERE id_user=:id');
																																		$update1->execute(array(
																																					'fonction'=>$_POST['fonction'],
																																					'id'=>$D_edit['id_user']
																																					));
																																}
																																
																																if($D_edit['departement']!=$_POST['departement'])
																																
																																{
																																		$update1=$db->prepare('UPDATE user SET departement=:departement WHERE id_user=:id');
																																		$update1->execute(array(
																																					'departement'=>$_POST['departement'],
																																					'id'=>$D_edit['id_user']
																																					));
																																}
																																
																																if($D_edit['telephone']!=$_POST['add_user_Telephone'])
																																
																																{
																																		$update1=$db->prepare('UPDATE user SET telephone=:telephone WHERE id_user=:id');
																																		$update1->execute(array(
																																					'telephone'=>$_POST['add_user_Telephone'],
																																					'id'=>$D_edit['id_user']
																																					));
																																}
																																
																																
																																
																																
																																
																																if($D_edit['email']!=$_POST['add_user_email'])
																																
																																{
																																		$update1=$db->prepare('UPDATE user SET email=:email WHERE id_user=:id');
																																		$update1->execute(array(
																																					'email'=>$_POST['add_user_email'],
																																					'id'=>$D_edit['id_user']
																																					));
																																}
																																
																																
																																if($D_edit['login']!=$_POST['add_user_login'])
																																
																																{
																																		$update1=$db->prepare('UPDATE user SET login=:login WHERE id_user=:id');
																																		$update1->execute(array(
																																					'login'=>$_POST['add_user_login'],
																																					'id'=>$D_edit['id_user']
																																					));
																																}
																																
																																if($D_edit['password']!=$_POST['add_user_password'])
																																
																																{
																																		$update1=$db->prepare('UPDATE user SET password=:password WHERE id_user=:id');
																																		$update1->execute(array(
																																					'password'=>$_POST['add_user_password'],
																																					'id'=>$D_edit['id_user']
																																					));
																																}
																																
																																
																																if($D_edit['type_account']!=$_POST['statue'])
																																
																																{
																																		$update1=$db->prepare('UPDATE user SET type_account=:statue WHERE id_user=:id');
																																		$update1->execute(array(
																																					'statue'=>$_POST['statue'],
																																					'id'=>$D_edit['id_user']
																																					));
																																}
																																
																																if($D_edit['nm']!=$_POST['add_user_nm'])
																																
																																{
																																		$update1=$db->prepare('UPDATE user SET nm=:nm WHERE id_user=:id');
																																		$update1->execute(array(
																																					'nm'=>$_POST['add_user_nm'],
																																					'id'=>$D_edit['id_user']
																																					));
																																}
																																
																																
																																$update1=$db->prepare('UPDATE user SET picture_user=:picture WHERE id_user=:id');
																																		$update1->execute(array(
																																					'picture'=>$image,
																																					'id'=>$D_edit['id_user']
																																					));
																																
																																
																																					
																																					header('location:show_user.php?operation=show&id='.$_GET['id']);
																																			
																																			
																																			
																														
																														
																																		
																																		
																																					}
																																				 
																																				 
																																				 
																																				 echo'</div>';
																																				}
		



 echo'</div>';

?>
			<p class="clear"></p>
			<br>
			
			</div><!-----------  ALL ---------------->
			
			<div id="bottom">
		
		</div> <!---------------- header -------------------->
			
		</body>
		
</html>