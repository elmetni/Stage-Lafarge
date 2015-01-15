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
	
		if(isset($_GET['id'])==false OR isset($_GET['operation'])==false OR ($_GET['operation']!="show" AND $_GET['operation']!="edit" ))
		header('location:administration.php?limit=15');

?>


	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//en"

       "http://www.w3.org/TR/html4/strict.dtd">




<html>
		<head> 
				<?php echo'<title>Les détails d\'article </title>';?>
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
		
				<li><a href="administration.php"   >Demandes</a></li>
				<li><a href="item.php" >Articles</a></li>
				<li><a href="message_controle.php"> Messages</a></li>
				<li><a href="profile_controle.php">Utilisateurs</a></li>		
		</ul>
		<?php
			$R2=$db->prepare('SELECT * FROM item WHERE id_item=:id ');
	$R2->execute(array(
				'id'=>$_GET['id']
				));
	$D2=$R2->fetch();
	if($D2==false)
	header('location:follow.php?limit=15');
	else
	{
				if($_GET['operation']=='show')
				{
						
						
						echo'<div class="answer_request"><div class="show_request_title">';
						echo '<strong>l\'Article </strong></div>';
						
							
								
								
										echo'<div class="show_request_content">';
										
										echo ' <a id="edit_done_detail2" href="item_controle.php?operation=edit&id='.$D2['id_item'].'" > edit done </a> ';
										echo'<iframe id="delet_done" src="delet_controle.php?id='.$D2['id_item'].'&type=item" height="40" width="80" SCROLLING="no" NORESIZE FRAMEBORDER="0"></iframe>';
										echo'<p> <span class="_name">'.$D2['name_item'].'</span></p>';
										
										echo'<p> <span> Categorie : </span>'.$D2['description'].'</p>';
										
										echo'<p> <span> Informations technique : </span>'.$D2['type_item'].'/'.$D2['category'].'</p>';
										
										echo'<p> <span>La quantié restante : </span>'.$D2['quantity_item'].'</p>';
										
										echo'<p> <span> La date d\'ajout : </span>'.$D2['time_item'].'</p>';
										
										
									
										
										
									
										
										echo'</div>';
				
										echo'<div class="show_request_div"> <img src="'.$D2['image_item'].'" height="150" width="150" class="show_request_content" >';
										echo'</div><p class="clear"></p><br></div>';						
										}
										
										
										
										
						
					
				if($_GET['operation']=='edit')
				{
							$error=0;
							
							echo'<div class="left_administrastion"><div class="edit_user">';
							echo'<form method="POST"  action="item_controle.php?operation='.$_GET['operation'].'&id='.$_GET['id'].'"  enctype="multipart/form-data">';
							
								echo'<div class="add_test_title"><p  > Modifier: '.$D2['name_item'].' </p></div>';
								
								
								
									
								echo'<p class="main">Nom d\'arctile  : <input type="text" name="name" ';
								
								if(isset($_POST['name'])) echo 'value="'.$_POST['name'].'"';
								else echo'value="'.$D2['name_item'].'"';
								echo'>';
								
								
								 echo' </p>';
								if(isset($_POST['name']) && $_POST['name']=="")
										{
												echo'<span class="error" ><img src="images/waring2.png"> Vous ne pouvez pas laisser ce champ vide</span>' ;
												$error=1;
												
										
										}
									echo'<p class="main">Le type :  ';
																									
									if(isset($_POST['edit']) && $_POST['type']==-1 && $_POST['type_creat']=="")
											{
													echo'<span class="error" ><img src="images/waring2.png"> Vous ne pouvez pas laisser ce champ vide</span>' ;
													$error=1;
													
											
											}
											
									echo'<p>Vous pouvez choisir un type déja exisiter : ';
									
									echo'<select name="type">';
									echo'<option value="-1"';
									  if(!isset($_POST['type'])) ' selected';
									 echo'> Choisir </option></p>';
									
									$R_add=$db->query('SELECT * FROM item GROUP BY type_item ');	
									while($D_add=$R_add->fetch())
									{
									
									echo'<option value="'.$D_add['type_item'].'" ';
									 if(isset($_POST['type']) && $_POST['type']==$D_add['type_item']) echo ' selected';
									 else if($D_add['type_item']==$D2['type_item']) echo ' selected';
									 
									 echo' > '.$D_add['type_item'].' </option>';
									
									}
									echo'</select>';
									 echo'<p> Ou bien créer un nouveau type :' ;
									 echo'<input type="text" name="type_creat"';
									
									if(isset($_POST['type_creat'])) echo 'value="'.$_POST['type_creat'].'"';
									
									echo'></p>';
									
									
									
									
									echo'<p class="main">La catégorie :  ';
																									
									if(isset($_POST['edit']) && $_POST['type']==-1 && $_POST['type_creat']=="")
											{
													echo'<span class="error" ><img src="images/waring2.png"> Vous ne pouvez pas laisser ce champ vide</span>' ;
													$error=1;
													
											
											}
									echo'<p>Vous pouvez choisir une catégorie déja exisiter : ';
									
									echo'<select name="category">';
									echo'<option value="-1"';
									  if(!isset($_POST['category'])) ' selected';
									 echo'> Choisir </option></p>';
									
									$R_add=$db->query('SELECT * FROM item GROUP BY category ');	
									while($D_add=$R_add->fetch())
									{
									
									echo'<option value="'.$D_add['category'].'" ';
									 if(isset($_POST['category']) && $_POST['category']==$D_add['category']) echo ' selected';
									  else if($D_add['category']==$D2['category']) echo ' selected';
									 
									 echo' > '.$D_add['category'].' </option>';
									
									}
									echo'</select>';
									 echo'<p> Ou bien créer une nouvelle catégorie :' ;
									 echo'<input category="text" name="category_creat"';
									
									if(isset($_POST['category_creat'])) echo 'value="'.$_POST['category_creat'].'"';
									echo'></p>';
									
									
									
									
																									
								 echo'<p class="main">Quantité  : <input type="text" name="quantity_item"';
								
								if(isset($_POST['quantity_item'])) echo 'value="'.$_POST['quantity_item'].'"';
								else echo'value="'.$D2['quantity_item'].'"';
								echo'>';
								
								
								 echo' </p>';
								 if(isset($_POST['quantity_item']) && $_POST['quantity_item']=="")
										{
												echo'<span class="error" ><img src="images/waring2.png"> Vous ne pouvez pas laisser ce champ vide</span>' ;
												$error=1;
												
										
										}
										
								
								
								echo'<p class="main">Image : <input type="FILE" name="item_image"';
								
								
								echo'></p>';
					
					
					
					if(isset($_POST['edit']) && $_FILES['item_image']['error']!=0 && $_FILES['item_image']['size']!=0)
						{

										echo'<span class="error" ><img src="images/waring2.png"> Erreur de Téléchargement .. essayer plus tard</span>' ;
												$error=1;


						}
					else if(isset($_POST['edit']) && $_FILES['item_image']['error']==0 && $_FILES['item_image']['size']!=0)
					{
								if(isset($_POST['edit']) && $_FILES['item_image']['error']!=0 && $_FILES['item_image']['size']> 4000000)
								{

												echo'<span class="error" ><img src="images/waring2.png">le size d\'image doit être inférieure à 4 mo</span>' ;
														$error=1;


								}
								else
								{
										$infosfichier = pathinfo($_FILES['item_image']['name']);
										$extension_upload = $infosfichier['extension'];
										$extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png','flv','bmp','JPG','JPEG','GIF','PNG','FLV','BMP');
										if (in_array($extension_upload, $extensions_autorisees)==false)
										{
											echo'<span class="error" ><img src="images/waring2.png">incorrect extention </span>' ;
														$error=1;
								
								
								
										}
								}
						}
						
						 echo'<p class="main">Details  :</p>';
						 echo'<textarea name="detail" id="detail">';
						 if(isset($_POST['detail'])) echo $_POST['detail'];
						 else echo $D2['description'] ;
						 echo'</textarea>';
						 
					 echo'<input type="submit" name="edit" id="edit" value="">';

				echo'</div>';
			
					if(isset($_POST['edit']) && $error==0)
					{
					
						if($_POST['type']!=-1 && $_POST['type_creat']=="")
							$type=$_POST['type'];
						 else 
						$type=$_POST['type_creat'];
					
					
						if($_POST['category']!=-1 && $_POST['category_creat']=="")
							$category=$_POST['category'];
						 else 
						$category=$_POST['category_creat'];
						
						
						if($_FILES['item_image']['size']==0)
						$image=$D2['image_item'];
						else
						{
								$max=$db->query('SELECT MAX(id_item) AS maxid FROM item');
								$d=$max->fetch();
								$d['maxid']++;
								$d['maxid']++;
								$infosfichier = pathinfo($_FILES['item_image']['name']);
								$extension_upload = $infosfichier['extension'];
								$image='item/'.$d['maxid'].'.'.$extension_upload;
								move_uploaded_file($_FILES['item_image']['tmp_name'], $image);
						
						}
						
						if($D2['name_item']!=$_POST['name'])																																
						{
								$update1=$db->prepare('UPDATE item SET name_item=:name_item WHERE id_item=:id');
								$update1->execute(array(
											'name_item'=>$_POST['name'],
											'id'=>$_GET['id']
											));
						}

						
						if($D2['quantity_item']!=$_POST['quantity_item'])																																
						{
								$update1=$db->prepare('UPDATE item SET quantity_item=:quantity_item WHERE id_item=:id');
								$update1->execute(array(
											'quantity_item'=>$_POST['quantity_item'],
											'id'=>$_GET['id']
											));
						}
						
						
						if($D2['type_item']!=$type)																																
						{
								$update1=$db->prepare('UPDATE item SET type_item=:type_item WHERE id_item=:id');
								$update1->execute(array(
											'type_item'=>$type,
											'id'=>$_GET['id']
											));
						}

						
						if($D2['category']!=$category)																																
						{
								$update1=$db->prepare('UPDATE item SET category=:category WHERE id_item=:id');
								$update1->execute(array(
											'category'=>$category,
											'id'=>$_GET['id']
											));
						}
						
						
						if($D2['description']!=$_POST['detail'])																																
						{
								$update1=$db->prepare('UPDATE item SET description=:description WHERE id_item=:id');
								$update1->execute(array(
											'description'=>$_POST['detail'],
											'id'=>$_GET['id']
											));
						}
						
						$update1=$db->prepare('UPDATE item SET image_item=:image_item WHERE id_item=:id');
						$update1->execute(array(
									'image_item'=>$image,
									'id'=>$_GET['id']
									));
						
						
						
					
					header('location:item_controle.php?operation=show&id='.$_GET['id']);
					
					}
					echo'</div>';
					
				}
				
									
			
				
				
				
						
	
	}
	
	
	
		?>
		<p class="clear"></p>
		
		
		
		</div><!-----------  ALL ---------------->
			
			<div id="bottom">
		
		</div> <!---------------- header -------------------->
			
		</body>
		
</html>