<?php
        #Conexión con la BD
	$link = mysqli_connect("mysql.hostinger.es", "u923585965_root", "Informatica", "u923585965_quiz");
	if(!$link){
		echo "Fallo al conectar a MySQL:" . $link->connect_error;
		mysqli_close($link);
	}

	#Si la especialidad indicada en el formulario es 'otra', tomamos el valor que se haya introducido en el campo 'otraEspec'
	$laespecialidad= $_POST[Especialidad];
	if(strnatcasecmp($laespecialidad,"Otra...")==0){
		$laespecialidad= $_POST[otraEspec];
	}
	
        #Comprobamos que se ha subido un archivo
	if (is_uploaded_file($_FILES["img"]["tmp_name"])){ #Y que dicho archivo es una imagen en cualquiera de los formatos que se listan en la condicón (gif, jpeg, ...)
		if ($_FILES["img"]["type"]=="image/jpeg" || $_FILES["img"]["type"]=="image/pjpeg" || $_FILES["img"]["type"]=="image/gif" || $_FILES["img"]["type"]=="image/bmp" || $_FILES["img"]["type"]=="image/png"){
			
                        #Obtenemos el 'valor' de la imagen
			$valorImagen=mysqli_real_escape_string($link, file_get_contents($_FILES["img"]["tmp_name"]));

	                #Insertamos la imagen en BD con el resto de datos del usuario. Almacenaremos también el tipo de imagen
			$sql="INSERT INTO usuario VALUES ('$_POST[nombreyapellidos]','$_POST[correo]','$_POST[password]','$_POST[numtelefono]','$laespecialidad','$_POST[intereses]','$valorImagen','$_FILES[img][type]')";
			if (!mysqli_query($link ,$sql)){
				die('Error al insertar tupla: ' . mysqli_error($link));
			}
			echo "El registro se ha guardado correctamente";

		}else{ # Si el archivo no es una imagen válida, no la insertamos. Como valor del atributo 'imagen' y 'tipo_imagen' guardaremos NULL.
			$sql="INSERT INTO usuario VALUES ('$_POST[nombreyapellidos]','$_POST[correo]','$_POST[password]','$_POST[numtelefono]','$laespecialidad','$_POST[intereses]',NULL,NULL)";
			if (!mysqli_query($link ,$sql)){
				die('Error al insertar tupla: ' . mysqli_error($link));
			}
			echo "El registro se ha guardado correctamente, pero la imagen no es valida. Valor guardado para la imagen: NULL";
		}

	}else{ #Si no se ha subido ningún archivo (valor del atributo 'imagen' y 'tipo_imagen' --> NULL).
		$sql="INSERT INTO usuario VALUES ('$_POST[nombreyapellidos]','$_POST[correo]','$_POST[password]','$_POST[numtelefono]','$laespecialidad','$_POST[intereses]',NULL,NULL)";
		if (!mysqli_query($link ,$sql)){
			die('Error al insertar tupla: ' . mysqli_error($link));
		}
		echo "El registro se ha completado con éxito";
	}


	#Enlace para ver los usuarios
	echo "<p> <a href='VerUsuariosConFoto.php'> Ver registros </a>";
	mysqli_close($link);
?>			