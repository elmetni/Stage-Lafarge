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
					if($_GET['type']=="user"   )
					{
						
						
							echo'<form action="sure_controle.php?type='.$_GET['type'].'&id='.$_GET['id'].'"    method="post">			
							<input type="submit" name="delet_done" id="delet_done" title="remove">
							</form>';
						
						
					
				
					}
					else if($_GET['type']=="item" )
					{
						echo'<form action="sure_controle.php?type='.$_GET['type'].'&id='.$_GET['id'].'"    method="post">			
							<input type="submit" name="delet_done" id="delet_done_detail" title="remove">
							</form>';
					
					
					}
					else
					{
						echo ' <img src="images/remove_done_block.png" class="remove_block" >';
			
					}
					
					
			}
			?>
			</body>
			
	</html>