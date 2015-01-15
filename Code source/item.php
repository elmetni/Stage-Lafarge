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
				<?php echo'<title>La gestion des articles </title>';?>
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
				<li><a href="item.php"  class="here">Articles</a></li>
				<li><a href="message_controle.php"> Messages</a></li>
				<li><a href="profile_controle.php">Utilisateurs</a></li>	
		</ul>
	
		
		<p class="clear"></p>
		
		<?php
		
				echo'<a href="item.php?go=add" id="add_item"> add </a>';
				if(isset($_GET['go']) && $_GET['go']=="add")
				{
						
					

							$error=0;
							
							echo'<div class="add_test">';
							echo'<form method="POST"  action="item.php?go=add"  enctype="multipart/form-data">';
							
								echo'<div class="add_test_title"><p  > Ajouter un Article </p></div>';
								
								
								
									
								echo'<p class="main">Nom d\'arctile  : <input type="text" name="name" ';
								
								if(isset($_POST['name'])) echo 'value="'.$_POST['name'].'"';
								echo'>';
								
								
								 echo' </p>';
								if(isset($_POST['name']) && $_POST['name']=="")
										{
												echo'<span class="error" ><img src="images/waring2.png"> Vous ne pouvez pas laisser ce champ vide</span>' ;
												$error=1;
												
										
										}
									echo'<p class="main">Le type :  ';
																									
									if(isset($_POST['add_test']) && $_POST['type']==-1 && $_POST['type_creat']=="")
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
									 
									 echo' > '.$D_add['type_item'].' </option>';
									
									}
									echo'</select>';
									 echo'<p> Ou bien créer un nouveau type :' ;
									 echo'<input type="text" name="type_creat"';
									
									if(isset($_POST['type_creat'])) echo 'value="'.$_POST['type_creat'].'"';
									echo'></p>';
									
									
									
									
									echo'<p class="main">La catégorie :  ';
																									
									if(isset($_POST['add_test']) && $_POST['type']==-1 && $_POST['type_creat']=="")
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
									 
									 echo' > '.$D_add['category'].' </option>';
									
									}
									echo'</select>';
									 echo'<p> Ou bien créer une nouvelle catégorie :' ;
									 echo'<input category="text" name="category_creat"';
									
									if(isset($_POST['category_creat'])) echo 'value="'.$_POST['category_creat'].'"';
									echo'></p>';
									
									
									
									
																									
								 echo'<p class="main">Quantité  : <input type="text" name="quantity_item"';
								
								if(isset($_POST['quantity_item'])) echo 'value="'.$_POST['quantity_item'].'"';
								else echo'value=1';
								echo'>';
								
								
								 echo' </p>';
								 if(isset($_POST['quantity_item']) && $_POST['quantity_item']=="")
										{
												echo'<span class="error" ><img src="images/waring2.png"> Vous ne pouvez pas laisser ce champ vide</span>' ;
												$error=1;
												
										
										}
										
								
								
								echo'<p class="main">Image : <input type="FILE" name="item_image"';
								
								
								echo'></p>';
					
					
					
					if(isset($_POST['add_user']) && $_FILES['item_image']['error']!=0 && $_FILES['item_image']['size']!=0)
						{

										echo'<span class="error" ><img src="images/waring2.png"> Erreur de Téléchargement .. essayer plus tard</span>' ;
												$error=1;


						}
					else if(isset($_POST['add_user']) && $_FILES['item_image']['error']==0 && $_FILES['item_image']['size']!=0)
					{
								if(isset($_POST['add_user']) && $_FILES['item_image']['error']!=0 && $_FILES['item_image']['size']> 4000000)
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
						
						 echo'<p class="main">Details  :</p>'; echo'<input type="submit" name="add_test" class="add_test" value="">';
						 echo'<textarea name="detail" id="detail">';
						 if(isset($_POST['detail'])) echo $_POST['detail'];
						 echo'</textarea>';
					

			
			
					if(isset($_POST['add_test']) && $error==0)
					{
					
							
							if($_FILES['item_image']['size']==0)
							$image="images/no_img.png";
							else
							{
									$max=$db->query('SELECT MAX(id_item) AS maxid FROM item');
									$d=$max->fetch();
									$d['maxid']++;
									$da=$d['maxid']++;
									
									$infosfichier = pathinfo($_FILES['item_image']['name']);
									$extension_upload = $infosfichier['extension'];
									$image='item/'.$da.'.'.$extension_upload;
									move_uploaded_file($_FILES['item_image']['tmp_name'], $image);
							
							}
							$type=0;
							$category=0;
							 if($_POST['type']!=-1 && $_POST['type_creat']=="")
																									$type=$_POST['type'];
							 else 
							$type=$_POST['type_creat'];
											
							if($_POST['category']!=-1 && $_POST['category_creat']=="")
																									$category=$_POST['category'];
							 else 
							$category=$_POST['category_creat'];
										
							$R1=$db->prepare('INSERT INTO item VALUES(\'\',:name,:image,:quantity,:description,NOW(),:type,:category)');
												
							$R1->execute(array(
											'name'=>$_POST['name'],
											'image'=>$image,
											'quantity'=>$_POST['quantity_item'],
											'description'=>$_POST['detail'],
											'type'=>$type,
											'category'=>$category
											
										)
										);
										
										
						header('location:item.php');
					
					
					
					
					
					
						}
					echo'</div>';
					
				}
				
				else
				{
				$R=$db->query('SELECT * FROM item GROUP BY type_item ');
				while($D=$R->fetch())
				{
				
						echo'<div class="item_controle">';
						echo'<div class="item_controle_type"><p>'.$D['type_item'].'</p></div>';
						
						$R_category=$db->prepare('SELECT * FROM item WHERE type_item=:type_item GROUP BY category ORDER BY name_item');
						$R_category->execute(array(
										'type_item'=>$D['type_item']
									));
						while($D_category=$R_category->fetch())
						{
						
							echo'<p class="clear"></p><div class="item_controle_category"><p>'.$D_category['category'].'</p></div>';
							$R_item=$db->prepare('SELECT * FROM item WHERE type_item=:type_item  AND category=:category ORDER BY name_item');
							$R_item->execute(array(
												'type_item'=>$D['type_item'],
												'category'=>$D_category['category']
											));
							while($D_item=$R_item->fetch())
							{
									echo'<div class="show_item">';
									echo ' <a id="edit_done_detail" href="item_controle.php?operation=edit&id='.$D_item['id_item'].'" > edit done </a> ';
								echo'<iframe id="delet_done" src="delet_controle.php?id='.$D_item['id_item'].'&type=item" height="40" width="80" SCROLLING="no" NORESIZE FRAMEBORDER="0"></iframe>';
								
								 
								 echo'<a href="item_controle.php?operation=show&id='.$D_item['id_item'].'" class="no"><img src="'.$D_item['image_item'].'" height="120" width="120" ><p> '.$D_item['name_item'].'</p></a>';
									
									
									echo'</div>';
							
							
							
							
							}
						
						
						
						}
						echo'<p class="clear"></p></div>';
				}
			
				
				}
		
			?>
			
			<br>
			
			</div><!-----------  ALL ---------------->
			
			<div id="bottom">
		
		</div> <!---------------- header -------------------->
			
		</body>
		
</html>