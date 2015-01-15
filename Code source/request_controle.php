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
	
		if(isset($_GET['id'])==false OR isset($_GET['type'])==false OR ($_GET['type']!="show" AND $_GET['type']!="edit" ))
		header('location:administration.php?limit=15');

?>


	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//en"

       "http://www.w3.org/TR/html4/strict.dtd">




<html>
		<head> 
				<?php echo'<title> les details du demande</title>';?>
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
						if($D1['statue_request']=='none')
						{
						$update2=$db->prepare('UPDATE request SET  statue_request=\'seen\' WHERE id_request=:id_request');
																				$update2->execute(array(
																							
																							'id_request'=>$_GET['id']
																							));
						$update2=$db->prepare('UPDATE request SET  time_answer=NOW() WHERE id_request=:id_request');	
						$update2->execute(array(
																							
																							'id_request'=>$_GET['id']
																							));
																							
																							}
						$R2=$db->prepare('SELECT * FROM item WHERE id_item=:id ');
						$R2->execute(array(
									'id'=>$D1['id_item']
									));
						$D2=$R2->fetch();
						
						echo'<div class="answer_request"><div class="show_request_title">';
						echo '<strong>l\'Article </strong></div>';
						
						
										
										echo'<div class="show_request_content">';
										
										
										echo'<p> <span class="_name">'.$D2['name_item'].'</span></p>';
										
										echo'<p> <span> Categorie : </span>'.$D2['description'].'</p>';
										
										echo'<p> <span> Informations technique : </span>'.$D2['type_item'].'/'.$D2['category'].'</p>';
										
										echo'<p> <span>La quantié restante : </span>'.$D2['quantity_item'].'</p>';
										
										echo'<p> <span> La date d\'ajout : </span>'.$D2['time_item'].'</p>';
										
										
									
										
										
									
										
										echo'</div>';
				
									
				echo'<div class="show_request_div"> <img src="'.$D2['image_item'].'" height="150" width="150" class="show_request_content" >';
						echo'</div><p class="clear"></p><br></div>';
						
						
						
						$R_demande=$db->prepare('SELECT * FROM user WHERE id_user=:id ');
								$R_demande->execute(array(
											'id'=>$D1['id_user']
											));
								$D_demande=$R_demande->fetch();	
								
								
				echo'<div class="answer_request"><div class="show_request_title">';
						echo '<strong> la Demande </strong></div>';
						
						
										
										echo'<div class="show_request_content">';
										
										echo'<a href="send_controle.php?id='.$D_demande['id_user'].'" id="send_message_big"> SEND </a>';
										echo'<p> <span class="_name">'.$D_demande['first'].' '.$D_demande['last'].'</span></p>';
										
										echo'<p> <span> La quantité de  demande : </span>'.$D1['quantity_request'].'</p>';
										
										echo'<p> <span> La date de demande : </span>'.$D1['time_request'].'</p>';
										
										echo'<p> <span>Commentaire : </span>'.$D1['comment_request'].'</p>';
										
										
										
										
									
										
										
									
										
										echo'</div>';
				
										
				echo'<div class="show_request_div"><a href="show_user.php?operation=show&id='.$D_demande['id_user'].'"> <img src="'.$D_demande['picture_user'].'" height="150" width="150" class="show_request_content" ></a>';
						echo'</div><p class="clear"></p><br></div>';
						
						
				
				
				if($D1['statue_request']=='none')
				{
						echo'<div class="show_statue_request_none" >	<img src="images/none2.png"> <div class="in"><p> l\'administration n\'a pas encore vu cette demande </p>';
						echo'<form action="request_controle.php?id='.$_GET['id'].'&type='.$_GET['type'].'" method="POST" >';
						echo'<form action="request_controle.php?id='.$_GET['id'].'&type='.$_GET['type'].'" method="POST" >';
						if(isset($_POST['yes']))  echo'<input type="submit" name="yes" id="yes_block">';
						else echo'<input type="submit" name="yes" id="yes">';
						if(isset($_POST['no']))  echo'<input type="submit" name="no" id="no_block"></form>';
						else echo'<input type="submit" name="no" id="no"></form>';
						if(isset($_POST['yes']) OR isset($_POST['no']))
						{
								$answer=0;
								if(isset($_POST['yes'])) $answer='accepted' ;
								if(isset($_POST['no'])) $answer='rejected' ;
								echo'<form action="request_controle.php?id='.$_GET['id'].'&type='.$_GET['type'].'" method="POST" >';
								echo'<input type="hidden" value="'.$answer.'"  name="answer">';
								echo'<p class="clear"></p><p>Détailles : </p>';
								echo'<textarea name="detail_answer" id="detail_answer"></textarea>';
								echo'<input type="submit" name="send_answer" id="send_answer"></form>';
						
						}
						echo'<p class="clear"></p></br></div>';
				}
				
				if($D1['statue_request']=='seen')
				{
						echo'<div class="show_statue_request_seen" >	<img src="images/seen2.png"> <div class="in"><p> l\'administration a vu cette  demande  le <span>'.$D1['time_answer'].'</span> </p>';
						echo'<form action="request_controle.php?id='.$_GET['id'].'&type='.$_GET['type'].'" method="POST" >';
						if(isset($_POST['yes']))  echo'<input type="submit" name="yes" id="yes_block">';
						else echo'<input type="submit" name="yes" id="yes">';
						if(isset($_POST['no']))  echo'<input type="submit" name="no" id="no_block"></form>';
						else echo'<input type="submit" name="no" id="no"></form>';
						if(isset($_POST['yes']) OR isset($_POST['no']))
						{
								$answer=0;
								if(isset($_POST['yes'])) $answer='accepted' ;
								if(isset($_POST['no'])) $answer='rejected' ;
								echo'<form action="request_controle.php?id='.$_GET['id'].'&type='.$_GET['type'].'" method="POST" >';
								echo'<input type="hidden" value="'.$answer.'"  name="answer">';
								echo'<p class="clear"></p><p>Détailles : </p>';
								echo'<textarea name="detail_answer" id="detail_answer"></textarea>';
								echo'<input type="submit" name="send_answer" id="send_answer"></form>';
						
						}
						echo'<p class="clear"></p></br></div>';
				}
				
				if($D1['statue_request']=='rejected')
				{
						echo'<div class="show_statue_request_rejected" >	<img src="images/rejected2.png"> <div class="in"><p> l\'administration a refusé cette demande  le <span>'.$D1['time_answer'].' </span> </p>';
						
						echo'<p> Detail : <span>'.$D1['detail_answer'].'<span></p>';
						echo'</div><p class="clear"></p>';
				
				}
				
				if($D1['statue_request']=='accepted')
				{
						echo'<div class="show_statue_request_accepted" >	<img src="images/accepted2.png"> <div class="in"><p> l\'administration a accepté cette demande  le  <span>'.$D1['time_answer'].'</span>  </p>';
						
						echo'<p> Detail : <span>'.$D1['detail_answer'].'<span></p>';
						echo'</div><p class="clear"></p>';
				
				}
				 echo'<p class="clear"></p></div>';
				
				}
				
				if(isset($_POST['send_answer']))
				{
							$update2=$db->prepare('UPDATE request SET  time_answer=NOW() WHERE id_request=:id_request');	
							$update2->execute(array(
																							
																							'id_request'=>$_GET['id']
																							));
																							
																						
																							
							$update2=$db->prepare('UPDATE request SET  statue_request=:answer WHERE id_request=:id_request');	
							$update2->execute(array(
																							'answer'=>$_POST['answer'],
																							'id_request'=>$_GET['id']
																							));
																							
							if($_POST['answer']=="accepted")
							{
							
									$quantity_item=$D2['quantity_item']-$D1['quantity_request'];
									
										$update2=$db->prepare('UPDATE item SET  quantity_item=:quantity_item WHERE id_item=:id_item');	
										$update2->execute(array(
																							'quantity_item'=>$quantity_item,
																							'id_item'=>$D2['id_item']
																							));
							
							
							}
																														
																							
						
							$update2=$db->prepare('UPDATE request SET  detail_answer=:detail WHERE id_request=:id_request');	
							$update2->execute(array(
																							'detail'=>$_POST['detail_answer'],
																							'id_request'=>$_GET['id']
																							));
																							
																							
				
							$update2=$db->prepare('UPDATE request SET  statue_sender=\'none\' WHERE id_request=:id_request');	
							$update2->execute(array(
																							
																							'id_request'=>$_GET['id']
																							));
																							
							header('location:request_controle.php?id='.$_GET['id'].'&type='.$_GET['type']);
																							
																							
				
				}
				
						
	
	}
	
	
	
		?>
		<p class="clear"></p>
		
		
		
		</div><!-----------  ALL ---------------->
			
			<div id="bottom">
		
		</div> <!---------------- header -------------------->
			
		</body>
		
</html>