<?php
		
		try{
			$conn = mysqli_connect("mysql", "root", "1234", "sistema_veiculos"); 
		} catch (mysqli_sql_exception $e){
			die("Erro ao conectar");

		}
?>