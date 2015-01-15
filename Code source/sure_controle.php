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
		
?>
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	
	<html>
			<head>
			<link href="frame.css" rel="stylesheet" type="text/css" media="screen" >
			</head>
			<?php
			
			if(!isset($_SESSION['loged']) or $_SESSION['loged']!=1 OR $D_user['type_account']=="user" )
			{
				echo ' <img src="images/remove_done_block.png" class="remove_block" >';
			
			}
			else if (!isset($_GET['type']) OR !isset($_GET['id']) )
			echo ' <img src="images/remove_done_block.png" class="remove_block" >';
			else
			{	
					if($_GET['type']=="user" )
					{
							$R=$db->prepare('SELECT * FROM user WHERE id_user=:id_user ');
							$R->execute(array(
										'id_user'=>$_GET['id']
										));
							
							$D=$R->fetch();
							
							if($D==false  )
								{
									echo ' <img src="images/remove_done_block.png" class="remove_block" >';
								}
							else
								{
									echo'<form action="sure_controle.php?type='.$_GET['type'].'&id='.$_GET['id'].'"    method="post">			
									<input type="submit" name="sure" id="sure" title="remove">
									</form>';
									
									if(isset($_POST['sure']))
									{
											
											$R=$db->prepare('DELETE  FROM user WHERE id_user= :user');
											$R->execute(array(
														'user'=>$D['id_user']
														)
														);
														
											$R=$db->prepare('DELETE  FROM message WHERE id_sender= :user OR id_reciever=:user');
											$R->execute(array(
														'user'=>$D['id_user']
														)
														);
														
											$R=$db->prepare('DELETE  FROM read_message WHERE id_user= :user');
											$R->execute(array(
														'user'=>$D['id_user']
														)
														);
														
											
														
											$R=$db->prepare('DELETE  FROM request WHERE id_user= :user');
											$R->execute(array(
														'user'=>$D['id_user']
														)
														);
														
												
													echo'<script language="JavaScript" type="text/javascript">
													top.location ="profile_controle.php";				
													</script>
													';
												
												
									
									
									
									}
								
								}
					
					
					}
					
					if($_GET['type']=="item" )
					{
							$R=$db->prepare('SELECT * FROM item WHERE id_item=:id_test ');
							$R->execute(array(
										'id_test'=>$_GET['id']
										));
							
							$D=$R->fetch();
							
							if($D==false  )
								{
									echo ' <img src="images/remove_done_block.png" class="remove_block" >';
								}
							else
								{
									echo'<form action="sure_controle.php?type='.$_GET['type'].'&id='.$_GET['id'].'"    method="post">			
									<input type="submit" name="sure" id="sure_detail" title="remove">
									</form>';
									
									if(isset($_POST['sure']))
									{
											
											$R=$db->prepare('DELETE  FROM item WHERE id_item= :id_test');
											$R->execute(array(
														'id_test'=>$D['id_item']
														)
														);
														
											$R=$db->prepare('DELETE  FROM request WHERE id_item= :id_test');
											$R->execute(array(
														'id_test'=>$D['id_item']
														)
														);
														
											
														
												
													echo'<script language="JavaScript" type="text/javascript">
													top.location ="item.php";				
													</script>
													';
												
												
									
									
									
									}
								
								}
					
					
					}
					
					
					if($_GET['type']=="valeur" )
					{
							$R=$db->prepare('SELECT * FROM support WHERE id_support=:id_support ');
							$R->execute(array(
										'id_support'=>$_GET['id']
										));
							
							$D=$R->fetch();
							
							if($D==false  )
								{
									echo ' <img src="images/remove_done_block.png" class="remove_block" >';
								}
							else
								{
									echo'<form action="sure_controle.php?type='.$_GET['type'].'&id='.$_GET['id'].'"    method="post">			
									<input type="submit" name="sure" id="sure_valeur" title="remove">
									</form>';
									
									if(isset($_POST['sure']))
									{
											
											$R=$db->prepare('DELETE  FROM support WHERE id_support= :id_support');
												$R->execute(array(
															'id_support'=>$D['id_support']
															)
															);
														
												
													echo'<script language="JavaScript" type="text/javascript">
													parent.location ="show_detail.php?type=show&id='.$D['id_test'].'&detail='.$D['detail'].'";				
													</script>
													';
												
												
									
									
									
									}
								
								}
					
					
					}
					
			
			
			}
			?>
			</body>
			
	</html>